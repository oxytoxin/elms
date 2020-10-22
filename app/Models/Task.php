<?php

namespace App\Models;

use App\Models\TaskType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function task_type()
    {
        return $this->belongsTo(TaskType::class);
    }
}
