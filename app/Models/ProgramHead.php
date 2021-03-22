<?php

namespace App\Models;

use App\Models\User;
use App\Models\College;
use App\Models\Teacher;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgramHead extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function college()
    {
        return $this->belongsTo(College::class);
    }
    public function departments()
    {
        return $this->hasMany(Department::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTeachersAttribute()
    {

        return $this->department ? $this->department->teachers : collect();
    }

    public function getCoursesAttribute()
    {
        $departmentcourses = $this->department ? $this->department->courses : collect();
        $facultycourses = $this->teachers->flatMap(fn ($t) => $t->courses);
        return $departmentcourses->merge($facultycourses);
    }
}