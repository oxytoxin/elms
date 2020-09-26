<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TeacherCoursesPage extends Component
{
    public $tab = 'student';
    public function render()
    {
        return view('livewire.teacher-courses-page');
    }
}
