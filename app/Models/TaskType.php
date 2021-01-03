<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskType extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function getPluralNameAttribute()
    {
        return [
            'assignment' => 'assignments',
            'activity' => 'activities',
            'quiz' => 'quizzes',
            'exam' => 'exams',
        ][$this->name] ?? 'tasks';
    }
}
