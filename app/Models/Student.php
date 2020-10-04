<?php

namespace App\Models;

use App\Models\User;
use App\Models\Course;
use App\Models\College;
use App\Models\Teacher;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
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
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class)->withPivot('course_id');
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class)->withPivot('teacher_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
