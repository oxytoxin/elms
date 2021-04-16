<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Module;
use App\Models\College;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Department;
use App\Models\CourseTeacherStudent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'name_conflict' => AsCollection::class
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function getNameAttribute($value)
    {
        if (Auth::check()) {
            return $this->name_conflict[auth()->user()->campus_id] ?? $value;
        }
        return $value;
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_teacher')->using(CourseTeacherStudent::class)->withPivot(['section_id', 'teacher_id']);
    }



    public function studentsBySection($section)
    {
        return $this->belongsToMany(Student::class, 'student_teacher')->using(CourseTeacherStudent::class)->wherePivot('section_id', $section)->withPivot(['section_id', 'teacher_id']);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
    public function scopeByDepartment($query, $department)
    {
        return $query->where('department_id', $department);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}