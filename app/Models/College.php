<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
    public function dean()
    {
        return $this->hasOne(Dean::class);
    }
    public function program_heads()
    {
        return $this->hasMany(ProgramHead::class);
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
