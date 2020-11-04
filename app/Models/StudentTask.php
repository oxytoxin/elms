<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class StudentTask extends Pivot
{
    use HasFactory;
    protected $guarded = [];
    public $incrementing = true;
    protected $dates = ['date_submitted'];
}
