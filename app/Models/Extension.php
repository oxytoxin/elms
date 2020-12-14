<?php

namespace App\Models;

use App\Models\Task;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Extension extends Model
{
    use HasFactory;
    protected $dates = ['deadline'];
    protected $guarded = [];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
