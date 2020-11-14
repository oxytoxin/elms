<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Module;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TaskType;
use App\Models\StudentTask;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $dates = [
        'deadline'
    ];

    public function getCourseAttribute()
    {
        return $this->module->course;
    }

    public function task_type()
    {
        return $this->belongsTo(TaskType::class);
    }
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class)->using(StudentTask::class)->withPivot('score', 'date_submitted', 'isGraded', 'answers');
    }

    public function getSubmissionsAttribute()
    {
        return $this->students->count();
    }
    public function getUngradedAttribute()
    {
        return $this->students()->wherePivot('isGraded', false)->count();
    }
    public function getGradedAttribute()
    {
        return $this->students()->wherePivot('isGraded', true)->count();
    }

    public function scopeByType($query, $task_type)
    {
        return $query->where('task_type_id', $task_type);
    }
}
