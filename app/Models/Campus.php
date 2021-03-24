<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function colleges()
    {
        return $this->hasMany(College::class);
    }
}