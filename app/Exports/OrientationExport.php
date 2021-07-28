<?php

namespace App\Exports;

use App\Models\Section;
use App\Models\TaskType;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrientationExport implements FromView, ShouldAutoSize
{
    public $section;

    public function __construct($section)
    {
        $this->section = $section;
    }

    public function view(): View
    {
        $section = Section::find($this->section);
        return view('section-orientation', [
            'section' => $section,
        ]);
    }
}
