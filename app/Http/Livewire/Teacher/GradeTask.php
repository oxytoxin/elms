<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Task;
use Livewire\Component;

class GradeTask extends Component
{

    public $task;
    public $student_score = 0;
    public $rubric;
    public $task_content;
    public $submission;
    public $answers;
    public $items = [];
    public $partial = [];


    // Essay Grading
    public $uiEssay = false;
    public $weights = [];
    public $essay_item;
    public $essay_maxscore = 0;
    public $essay_score = 0;


    public function mount(Task $task)
    {
        $this->task = $task;
        $this->rubric = json_decode($task->essay_rubric, true);
        $this->task_content = json_decode($task->content, true);
        $this->submission = $task->students->where('id', request('student'))->first()->pivot;
        $this->answers = json_decode($this->submission->answers, true);
        $this->getCorrect();
    }

    public function render()
    {
        return view('livewire.teacher.grade-task')
            ->extends('layouts.master')
            ->section('content');;
    }

    public function getRating($key)
    {
        return $rating = round(100 * (1 / ($key + 1)), 2);
    }

    public function showEssayGrader($key)
    {
        $this->uiEssay = true;
        $item = $this->task_content[$key];
        if ($item['essay']) {
            foreach ($this->rubric['criteria'] as $c => $criterion) {
                array_push($this->weights, $c = 100);
            }
        }
        $this->essay_item = $key;
        $this->essay_maxscore = $item['points'];
        isset($this->items['score']) ? $this->item['score'] : $this->essay_score = 0;
    }

    public function gradeEssay()
    {
        $w = collect($this->rubric['criteria'])->map(function ($c, $index) {
            return ($c['weight'] / 100) * $this->weights[$index];
        });

        $score = round(($w->sum() / 100) * $this->task_content[$this->essay_item]['points']);
        $this->items[$this->essay_item] = ['isCorrect' => 'partial', 'score' => $score];
        $this->uiEssay = false;
    }

    public function getCorrect()
    {
        foreach ($this->task_content as $key => $content) {
            if (array_key_exists('answer', $content)) {
                if ($this->answers[$key]['answer'] == $content['answer']) {
                    array_push($this->items, $key = ['isCorrect' => true, 'score' => $content['points']]);
                } else array_push($this->items, $key = ['isCorrect' => false, 'score' => 0]);
            } else array_push($this->items, $key = null);
        }
    }

    public function markAsCorrect($key)
    {
        $this->items[$key] = ['isCorrect' => true, 'score' => $this->task_content[$key]['points']];
    }

    public function markAsWrong($key)
    {
        $this->items[$key] = ['isCorrect' => false, 'score' => 0];
    }

    public function partialPoints($key)
    {
        if ($this->partial[$key] > 0 && $this->partial[$key] <= $this->task_content[$key]['points']) {
            $this->items[$key] = ['isCorrect' => 'partial', 'score' => $this->partial[$key]];
            $this->partial[$key] = null;
        } else
            session()->flash("partialError$key", "Please provide a valid score.");
    }

    public function getTotalScore()
    {
        return collect($this->items)->map(function ($i) {
            return $i ? $i['score'] : 0;
        })->sum();
    }

    public function verifyItems()
    {
        if (in_array(null, $this->items, true))
            return false;
        else return true;
    }

    public function finishGrading()
    {
        $this->submission->update([
            'score' => $this->getTotalScore(),
            'isGraded' => true,
        ]);
        return redirect()->route('teacher.task', ['task' => $this->task->id]);
    }
}
