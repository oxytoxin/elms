<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Facades\URL;
use App\Notifications\GeneralNotification;

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
    public $previous;


    // Essay Grading
    public $uiEssay = false;
    public $weights = [];
    public $essay_item;
    public $essay_maxscore = 0;
    public $essay_score = 0;


    public $messages = [
        'partial.*.required' => 'Please provide valid partial points.'
    ];

    public function mount(Task $task)
    {
        $isAllowed = $task->section->teacher_id == auth()->user()->teacher->id;
        if (!$isAllowed) abort(403);
        $this->previous = URL::previous();
        $this->task = $task;
        $this->rubric = json_decode($task->essay_rubric, true);
        $this->task_content = json_decode($task->content, true);
        $this->submission = $task->students->where('id', request('student'))->first();
        if ($this->submission) $this->submission = $this->submission->pivot;
        else abort(404);
        $this->answers = json_decode($this->submission->answers, true);
        $this->getCorrect();
        if ($this->submission->assessment) $this->items = json_decode($this->submission->assessment, true);
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
        $item = $this->task_content[$key];
        if ($item['essay']) {
            foreach ($this->rubric['criteria'] as $c => $criterion) {
                array_push($this->weights, $c = 100);
            }
        }
        $this->essay_item = $key;
        $this->essay_maxscore = $item['points'];
        isset($this->items['score']) ? $this->item['score'] : $this->essay_score = 0;
        $this->uiEssay = true;
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
                if (strcasecmp(sanitizeString($this->answers[$key]['answer']), sanitizeString($content['answer']))  == 0) {
                    array_push($this->items, $key = ['isCorrect' => true, 'score' => $content['points']]);
                } else array_push($this->items, $key = ['isCorrect' => false, 'score' => 0]);
            } else if ($content['enumeration']) {
                $correctItems = 0;
                $studentEnums = array_unique(array_map('strtolower', json_decode($this->answers[$key]['answer'], true)['items']));
                $correctEnums = array_map('strtolower', $content['enumerationItems']);
                foreach ($studentEnums as $key => $enumItem) {
                    if (in_array(sanitizeString($enumItem), $correctEnums)) $correctItems++;
                }
                if (count($correctEnums) == $correctItems)
                    array_push($this->items, $key = ['isCorrect' => true, 'score' => $content['points'] * count($correctEnums)]);
                else if ($correctItems) array_push($this->items, $key = ['isCorrect' => 'partial', 'score' => $content['points'] * $correctItems]);
                else array_push($this->items, $key = ['isCorrect' => false, 'score' => 0]);
            } else array_push($this->items, $key = null);
        }
    }

    public function enumeratorCheck($key, $id)
    {
        $studentEnums = array_map('strtolower', json_decode($this->answers[$key]['answer'], true)['items']);
        $correctEnums = array_map('strtolower', $this->task_content[$key]['enumerationItems']);
        return in_array(sanitizeString($studentEnums[$id]), $correctEnums);
    }

    public function markAsCorrect($key)
    {
        if ($this->task_content[$key]['enumeration']) {
            $total_points = $this->task_content[$key]['points'] * count($this->task_content[$key]['enumerationItems']);
            $this->items[$key] = ['isCorrect' => true, 'score' => $total_points];
        } else {
            $this->items[$key] = ['isCorrect' => true, 'score' => $this->task_content[$key]['points']];
        }
    }

    public function markAsWrong($key)
    {
        $this->items[$key] = ['isCorrect' => false, 'score' => 0];
    }

    public function partialPoints($key)
    {
        $this->validate([
            "partial.$key" => 'required',
        ]);
        try {
            if ($this->task_content[$key]['enumeration']) {
                $total_points = $this->task_content[$key]['points'] * count($this->task_content[$key]['enumerationItems']);
                if ($this->partial[$key] > 0 && $this->partial[$key] <= $total_points) {
                    $this->items[$key] = ['isCorrect' => 'partial', 'score' => $this->partial[$key]];
                    $this->partial[$key] = null;
                } else {
                    session()->flash("partialError$key", "Please provide a valid score. Total score = # of items * points per item.");
                }
            } else {
                if ($this->partial[$key] > 0 && $this->partial[$key] <= $this->task_content[$key]['points']) {
                    $this->items[$key] = ['isCorrect' => 'partial', 'score' => $this->partial[$key]];
                    $this->partial[$key] = null;
                } else
                    session()->flash("partialError$key", "Please provide a valid score.");
            }
        } catch (\Throwable $th) {
            session()->flash("partialError$key", "Please provide a valid score.");
        }
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
            'assessment' => json_encode($this->items),
        ]);
        $this->submission->student->user->notify(new GeneralNotification('A task has been graded.', route('preview-submission', ['submission' => $this->submission->id])));
        return redirect($this->previous);
    }
}
