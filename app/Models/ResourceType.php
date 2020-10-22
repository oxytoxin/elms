<?php

namespace App\Models;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResourceType extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }
}
