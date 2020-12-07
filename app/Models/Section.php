<?php

namespace App\Models;

use App\Models\Task;
use App\Models\Course;
use App\Models\Module;
use App\Models\Student;
use App\Models\Teacher;
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
        return $this->belongsToMany(Student::class, 'student_teacher')->withPivot(['course_id', 'teacher_id']);
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->whereHas('teacher', function (Builder $q) use ($department) {
            $q->where('department_id', $department);
        });
    }
}
