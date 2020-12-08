<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\Course;
use App\Models\Module;
use App\Models\College;
use App\Models\Section;
use App\Models\Student;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function college()
    {
        return $this->belongsTo(College::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class)->withPivot('course_id');
    }

    public function courseStudents($course)
    {
        return $this->belongsToMany(Student::class)->wherePivot('course_id', $course)->withPivot('course_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function ungradedTasks($task_type_id)
    {
        return $this->students->map(function ($s) {
            return $s->ungradedTasks;
        })->flatten()->filter(function ($item) use ($task_type_id) {
            return $item->task_type_id == $task_type_id;
        });
    }
    public function gradedTasks($task_type_id)
    {
        return $this->students->map(function ($s) {
            return $s->gradedTasks;
        })->flatten()->filter(function ($item) use ($task_type_id) {
            return $item->task_type_id == $task_type_id;
        });
    }

    public function modules()
    {
        return $this->hasManyThrough(Module::class, Section::class);
    }
}
