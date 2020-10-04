<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
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
        return $this->belongsToMany(Teacher::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class)->withPivot('teacher_id');
    }
    public function modules()
    {
        return $this->hasMany(Module::class);
    }
    public function scopeByDepartment($query, $department)
    {
        return $query->where('department_id', $department);
    }
}
