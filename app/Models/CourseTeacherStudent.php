<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTeacherStudent extends Pivot
{
    use HasFactory;

    protected $table = 'student_teacher';

    public function students()
    {
        $this->belongsToMany(Student::class);
    }
    public function teachers()
    {
        $this->belongsToMany(Teacher::class);
    }
    public function courses()
    {
        $this->belongsToMany(Course::class);
    }
}
