<?php

namespace App\Exports;

use App\Models\Section;
use App\Models\TaskType;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GradesExport implements FromView, ShouldAutoSize
{

    public function view(): View
    {
        return view('grades', [
            'task_types' => TaskType::withTaskCount()->get(),
            'tasks' => Section::find(1)->tasks()->with('task_type')->get()->groupBy('task_type_id')->sortKeys(),
            'students' => Section::find(1)->students()->withName()->get()->sortBy('name'),
            'section' => Section::find(1),
            'grading_system' => Section::find(1)->grading_system,
        ]);
    }
}