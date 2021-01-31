<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradingSystem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function getWeightValue($task_type)
    {
        switch ($task_type) {
            case 1:
                return $this->assignment_weight;
                break;
            case 2:
                return $this->quiz_weight;
                break;
            case 3:
                return $this->activity_weight;
                break;
            case 4:
                return $this->exam_weight;
                break;
            case 'attendance':
                return $this->attendance_weight;
                break;

            default:
                return null;
                break;
        }
    }

    public function getGradeValue($value)
    {
        $value = round($value);
        switch ($value) {
            case (100 >= $value && $value >= 99):
                return '1.0';
                break;
            case (98 >= $value && $value >= 96):
                return '1.25';
                break;
            case (95 >= $value && $value >= 93):
                return '1.5';
                break;
            case (92 >= $value && $value >= 90):
                return '1.75';
                break;
            case (89 >= $value && $value >= 87):
                return '2.0';
                break;
            case (86 >= $value && $value >= 84):
                return '2.25';
                break;
            case (83 >= $value && $value >= 81):
                return '2.5';
                break;
            case (80 >= $value && $value >= 78):
                return '2.75';
                break;
            case (77 >= $value && $value >= 75):
                return '3.0';
                break;
            case (74 >= $value && $value >= 71):
                return '4.0';
                break;
            case 70 >= $value:
                return '5.0';
                break;

            default:
                return $value;
                break;
        }
    }
}