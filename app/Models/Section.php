<?php

namespace App\Models;

use App\Models\Task;
use App\Models\Course;
use App\Models\Module;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Videoroom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function quarter()
    {
        return $this->belongsTo(Quarter::class);
    }

    public function grading_system()
    {
        return $this->hasOne(GradingSystem::class);
    }

    public function calendar_events()
    {
        return $this->hasMany(CalendarEvent::class);
    }

    public function videoroom()
    {
        return $this->hasOne(Videoroom::class);
    }

    public function chatroom()
    {
        return $this->hasOne(Chatroom::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_teacher')->withPivot(['course_id', 'teacher_id', 'days_present']);
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->whereHas('teacher', function (Builder $q) use ($department) {
            $q->where('department_id', $department);
        });
    }

    public function getUngradedAttribute()
    {
        return $this->tasks->map(function ($t) {
            return $t->students->pluck('pivot');
        })->flatten()->where('isGraded', false)->count();
    }
}