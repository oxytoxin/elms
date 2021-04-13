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
        return view('grades', [
            'task_types' => TaskType::withTaskCount()->get(),
            'tasks' => Section::find($this->section)->tasks()->with('task_type')->get()->groupBy('task_type_id')->sortKeys(),
            'students' => Section::find($this->section)->students()->withName()->get()->sortBy('name'),
            'section' => Section::find($this->section),
            'grading_system' => Section::find($this->section)->grading_system,
        ]);
    }
}