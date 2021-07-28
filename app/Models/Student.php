<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\Course;
use App\Models\College;
use App\Models\Section;
use App\Models\Teacher;
use App\Models\Extension;
use App\Models\Department;
use App\Models\StudentTask;
use App\Models\CourseTeacherStudent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Student extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeWithName($query)
    {
        $query->addSelect(['name' => User::select('name')
            ->whereColumn('user_id', 'users.id')
            ->limit(1)]);
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class)->withPivot('course_id');
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'student_teacher')->using(CourseTeacherStudent::class)->withPivot('teacher_id', 'section_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'student_teacher')->withPivot(['course_id', 'teacher_id']);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class)->using(StudentTask::class)->withPivot('score', 'date_submitted', 'isGraded', 'answers', 'assessment');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    // public function getAllTasksAttribute()
    // {
    //     return $this->teachers->unique()->map(function ($t) {
    //         return $t->tasks()->where('open', true)->get();
    //     })->flatten();
    // }
    public function getAllTasksAttribute()
    {
        return $this->sections->map(function ($t) {
            return $t->tasks()->where('open', true)->get();
        })->flatten();
    }

    public function tasksByType($task_type)
    {
        return $this->all_tasks->filter(function ($t) use ($task_type) {
            return $t->task_type_id == $task_type;
        });
    }

    // Student tasks with submissions
    public function hasSubmission($task_type)
    {
        return $this->all_tasks->filter(function ($t) use ($task_type) {
            return $t->task_type_id == $task_type && $t->students()->where('student_id', auth()->user()->student->id)->first();
        });
    }
    // Student tasks with no submissions
    public function hasNoSubmission($task_type)
    {
        return $this->all_tasks->filter(function ($t) use ($task_type) {
            return $t->task_type_id == $task_type && !$t->students()->where('student_id', auth()->user()->student->id)->first();
        });
    }
    // Student tasks with no submissions
    public function pastDeadline($task_type)
    {
        return $this->all_tasks->filter(function ($t) use ($task_type) {
            return $t->task_type_id == $task_type && $t->deadline < now();
        });
    }

    public function course_tasks($course_id)
    {
        return $this->all_tasks->filter(function ($t) use ($course_id) {
            return $t->course->id == $course_id;
        });
    }

    public function task_status($task_id)
    {
        if ($this->tasks()->where('task_id', $task_id)->first()) {
            $task = $this->tasks()->where('task_id', $task_id)->first();
            if ($task->pivot->date_submitted) {
                if ($task->pivot->isGraded) return $task->pivot->score;
                else return 'ungraded';
            } else return false;
        } else return false;
        // return $this->tasks()->where('task_id', $task_id)->first();
    }

    public function gradedTasks()
    {
        return $this->belongsToMany(Task::class)->withPivot('score', 'date_submitted', 'isGraded', 'answers')->wherePivot('isGraded', 1);
    }
    public function ungradedTasks()
    {
        return $this->belongsToMany(Task::class)->withPivot('score', 'date_submitted', 'isGraded', 'answers')->wherePivot('isGraded', 0);
    }
    public function extensions()
    {
        return $this->hasMany(Extension::class);
    }

    public function allTasksBySection(Section $section, $quarter_id)
    {
        $tasks = $this->getSectionTasks($section, $quarter_id)->flatten();
        $student_tasks = $this->tasks->where('section_id', $section->id)->groupBy('task_type_id')->sortKeys()->flatten();
        $tasks = $tasks->map(function ($k) use ($student_tasks) {
            $st = $student_tasks->first(function ($v) use ($k) {
                return $v->id == $k->id;
            });
            // return $st;
            if ($st) return $st;
            return ['task_type_id' => $k->task_type_id];
        });
        return $tasks->groupBy('task_type_id');
//        return Cache::remember("$this->id-allTasks", 5, function () use ($section, $quarter_id) {
//            // $tasks = $tasks->flatten();
//            $tasks = $this->getSectionTasks($section, $quarter_id)->flatten();
//            $student_tasks = $this->tasks->where('section_id', $section->id)->groupBy('task_type_id')->sortKeys()->flatten();
//            $tasks = $tasks->map(function ($k) use ($student_tasks) {
//                $st = $student_tasks->first(function ($v) use ($k) {
//                    return $v->id == $k->id;
//                });
//                // return $st;
//                if ($st) return $st;
//                return ['task_type_id' => $k->task_type_id];
//            });
//            return $tasks->groupBy('task_type_id');
//        });
    }

    public function getDaysPresentAttribute()
    {
        if ($this->pivot && $this->pivot->days_present) return $this->pivot->days_present;
        else return 0;
    }

    public function getGrades(Section $section, $quarter_id)
    {
        $grades = collect();
        $section_tasks = $this->getSectionTasks($section, $quarter_id);
        $alltasks = $this->allTasksBySection($section, $quarter_id);
        foreach ($alltasks as  $key => $tasks) {
            $grades[] = round($tasks->sum('pivot.score') / $section_tasks[$key]->sum('max_score') * $section->grading_system->getWeightValue($key), 3);
        }
        return $grades;
    }

    public function getGradeByTaskType(Section $section, $quarter_id, $task_type)
    {
        $section_tasks = $this->getSectionTasks($section, $quarter_id);
        $alltasks = $this->allTasksBySection($section, $quarter_id);
        if ($alltasks) {
            $grade = round($alltasks[$task_type]->sum('pivot.score') / $section_tasks[$task_type]->sum('max_score') * $section->grading_system->getWeightValue($task_type), 3);
        } else $grade = 0;
        return $grade;
    }

    public function getSectionTasks(Section $section, $quarter_id)
    {
        return $section->tasks()->where('quarter_id', $quarter_id)->with('task_type')->get()->groupBy('task_type_id')->sortKeys();
    }

    public function getAttendanceGrade(Section $section)
    {
        return round($this->days_present / $section->total_days * $section->grading_system->attendance_weight, 2);
    }
}
