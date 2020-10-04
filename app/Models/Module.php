<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function resources()
    {
        return $this->hasMany(Resource::class);
    }
    public function files()
    {
        return $this->morphMany('App\Models\File', 'fileable');
    }
}
