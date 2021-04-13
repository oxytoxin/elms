<?php

namespace App\Exports;

use App\Models\Section;
use App\Models\TaskType;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GradesExport implements FromView, ShouldAutoSize
{
    public $section;
    public $quarter_id;

    public function __construct($section, $quarter_id)
    {
        $this->section = $section;
        $this->quarter_id = $quarter_id;
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
        return view('grades', [
            'weights' => $weights,
            'quarter_id' => $this->quarter_id,
            'task_types' => TaskType::withTaskCount()->get(),
            'tasks' => $section->tasks()->where('quarter_id', $this->quarter_id)->with('task_type')->get()->groupBy('task_type_id')->sortKeys(),
            'students' => $section->students()->withName()->get()->sortBy('name'),
            'section' => $section,
            'grading_system' => $section->grading_system,
        ]);
    }
}