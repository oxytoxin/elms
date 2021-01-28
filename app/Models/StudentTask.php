<?php

namespace App\Models;

use App\Models\Task;
use App\Models\Student;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentTask extends Pivot
{
    use HasFactory;
    protected $guarded = [];
    public $incrementing = true;
    protected $dates = ['date_submitted'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
