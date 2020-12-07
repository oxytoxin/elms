<?php

namespace App\Http\Livewire\Head;

use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class WorkloadUploader extends Component
{
    use WithFileUploads;

    public $teacher;
    public $workloadArray = [];
    public $workload;
    public $hasWorkload = false;


    public function mount(Teacher $teacher)
    {
        $this->teacher = $teacher;
    }

    public function render()
    {
        return view('livewire.head.workload-uploader')
            ->extends('layouts.master')
            ->section('content');
    }

    public function uploadWorkload()
    {
        $workload = $this->workload->storeAs('workloads', $this->workload->getClientOriginalName(), 'local');


        $handle = fopen(storage_path("app/$workload"), "r");
        while (($data = fgetcsv($handle)) !== FALSE) {
            array_push($this->workloadArray, $data);
        }
        dd($this->workloadArray);
    }
}
