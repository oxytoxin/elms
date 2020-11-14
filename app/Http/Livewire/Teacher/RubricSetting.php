<?php

namespace App\Http\Livewire\Teacher;

use App\Models\User;
use Livewire\Component;

class RubricSetting extends Component
{

    public $rubric = [];
    public $new_criterion = "";
    public $new_performance_rating = "";
    public $showEdit = false;
    public $editDialogTitle = "";
    public $editDialogInputValue = "";
    public $editing;


    protected $messages = [
        'editDialogInputValue.required' => 'This field cannot be blank.',
        'editDialogInputValue.max' => 'Criterion weights must not exceed 100%.',
        'editDialogInputValue.min' => 'Criterion weights cannot be less than 1%.'
    ];

    public function mount()
    {
        $this->rubric = [
            'criteria' => [
                [
                    'name' => 'Structure (Spelling, Grammar, etc.)',
                    'weight' => 50
                ],
                [
                    'name' => 'Content (Relevance to theme, coherence, etc.)',
                    'weight' => 50
                ],
            ],
            'performance_rating' => [
                'Excellent', 'Good', 'Satisfactory'
            ]

        ];
    }

    public function getRating($key)
    {
        return $rating = round(100 * (1 / ($key + 1)), 2);
    }
    public function render()
    {
        return view('livewire.teacher.rubric-setting');
    }

    public function resetRubric()
    {
        $this->rubric = [
            'criteria' => [
                [
                    'name' => 'Structure (Spelling, Grammar, etc.)',
                    'weight' => 50
                ],
                [
                    'name' => 'Content (Relevance to theme, coherence, etc.)',
                    'weight' => 50
                ],
            ],
            'performance_rating' => [
                'Excellent', 'Good', 'Satisfactory'
            ]

        ];
    }

    public function addCriterion()
    {
        $this->validate([
            'new_criterion' => 'required'
        ]);

        if (count($this->rubric['criteria']) >= 4) {
            session()->flash('max_criteria', 'The rubric allows maximum of four criteria only.');
            $this->new_criterion = "";
            return false;
        }
        array_push($this->rubric['criteria'], ['name' => $this->new_criterion, 'weight' => 50]);
        $this->new_criterion = "";

        $criterion_count = count($this->rubric['criteria']);
        foreach ($this->rubric['criteria'] as $key => $criterion) {
            $this->rubric['criteria'][$key]['weight'] = round(100 / $criterion_count, 2);
        }
    }

    public function addPerformanceRating()
    {
        $this->validate([
            'new_performance_rating' => 'required'
        ]);

        if (count($this->rubric['performance_rating']) >= 4) {
            session()->flash('max_criteria', 'The rubric allows maximum of four performance ratings only.');
            $this->new_performance_rating = "";
            return false;
        }
        array_push($this->rubric['performance_rating'], $this->new_performance_rating);
        $this->new_performance_rating = "";
    }

    public function editCriterionName($id)
    {
        $this->editing = ['of' => 'name', 'id' => $id];
        $this->showEdit = true;
        $this->editDialogTitle = "Editing Criterion Name...";
        $this->editDialogInputValue = $this->rubric['criteria'][$id]['name'];
    }

    public function editCriterionWeight($id)
    {
        $this->editing = ['of' => 'weight', 'id' => $id];
        $this->showEdit = true;
        $this->editDialogTitle = "Editing Criterion Weight...";
        $this->editDialogInputValue = $this->rubric['criteria'][$id]['weight'];
    }

    public function updateValues()
    {
        if ($this->editing['of'] == 'weight') {
            $this->validate([
                'editDialogInputValue' => 'required|numeric|max:100|min:1'
            ]);
        }
        $this->validate([
            'editDialogInputValue' => 'required'
        ]);
        $this->rubric['criteria'][$this->editing['id']][$this->editing['of']] = $this->editDialogInputValue;
        $this->showEdit = false;
    }

    public function saveRubric()
    {
        $total = array_sum(array_map(function ($r) {
            return $r['weight'];
        }, $this->rubric['criteria']));
        if ($total != 100) {
            session()->flash('weights_error', 'The rubric weights must add up to 100.');
            return false;
        }
        $this->emitUp('rubricSet', $this->rubric);
        $this->emitUp('hideRubricEdit');
    }

    public function hideRubricEdit()
    {
        $this->emitUp('hideRubricEdit');
    }

    public function equalWeights()
    {
        $criterion_count = count($this->rubric['criteria']);
        foreach ($this->rubric['criteria'] as $key => $criterion) {
            $this->rubric['criteria'][$key]['weight'] = round(100 / $criterion_count, 2);
        }
    }
}
