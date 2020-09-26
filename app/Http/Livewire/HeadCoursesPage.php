<?php

namespace App\Http\Livewire;

use Livewire\Component;

class HeadCoursesPage extends Component
{
    public $tab = 'faculty';
    public function render()
    {
        return view('livewire.head-courses-page');
    }
}
