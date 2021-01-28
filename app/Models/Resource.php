<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    public function resource_type()
    {
        return $this->belongsTo(ResourceType::class);
    }
    public function files()
    {
        return $this->morphMany('App\Models\File', 'fileable');
    }
}
