<?php

namespace App\Exports;

use App\Models\Section;
use App\Models\TaskType;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GradesSummaryExport implements FromView, ShouldAutoSize
{
    public $section;

    public function __construct($section)
    {
        $this->section = $section;
    }

    public function view(): View
    {
        $section = Section::find($this->section);
        $weights = [
            'assignment' => $section->grading_system->assignment_weight,
            'activity' => $section->grading_system->activity_weight,
            'quiz' => $section->grading_system->quiz_weight,
            'exam' => $section->grading_system->exam_weight,
            'attendance' => $section->grading_system->attendance_weight,
        ];
        return view('grades-summary', [
            'weights' => $weights,
            'task_types' => TaskType::withTaskCount()->get(),
            'students' => $section->students()->withName()->get()->sortBy('name'),
            'section' => $section,
            'grading_system' => $section->grading_system,
        ]);
    }
}
