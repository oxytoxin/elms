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
    public function getAllTasksAttribute()
    {
        return $this->teachers->unique()->map(function ($t) {
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

    public function allTasks(Section $section, $tasks)
    {
        $tasks = $tasks->flatten();
        $student_tasks = $this->tasks->groupBy('task_type_id')->sortKeys()->flatten();
        $tasks = $tasks->map(function ($k) use ($student_tasks) {
            $st = $student_tasks->first(function ($v) use ($k) {
                return $v->id == $k->id;
            });
            // return $st;
            if ($st) return $st;
            return ['task_type_id' => $k->task_type_id];
        });
        return $tasks->groupBy('task_type_id');
    }
}