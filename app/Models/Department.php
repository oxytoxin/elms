<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function college()
    {
        return $this->belongsTo(College::class);
    }
    public function program_head()
    {
        return $this->belongsTo(ProgramHead::class);
    }
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}