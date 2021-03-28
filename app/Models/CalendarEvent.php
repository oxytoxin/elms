<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CalendarEvent extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['start', 'end'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}