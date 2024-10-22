<?php

namespace App\Http\Livewire;

use DB;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\Draft;
use App\Models\Course;
use App\Models\Module;
use App\Events\NewTask;
use Livewire\Component;
use App\Models\TaskType;
use App\Jobs\TaskOpening;
use App\Models\CalendarEvent;
use Livewire\WithFileUploads;

class TaskMaker extends Component
{
    use WithFileUploads;
    public $draft = null;
    public $type;
    public $allSection = false;
    public $task_name = "";
    public $task_instructions;
    public $module;
    public $modules;
    public $course;
    public $date_due;
    public $time_due = "23:59";
    public $items = [];
    public $total_points = 0;
    public $files = [];
    public $isRubricSet = false;
    public $showrubric = false;
    public $task_rubric = [];
    public $noDeadline = false;
    public $matchingTypeOptions = [];
    public $newMatchingTypeOption = "";
    public $showAddMatchingTypeOption = false;
    public $showMatchingTypeOptions = false;

    public $fileItems = [];

    protected $autocorrect = true;

    public $openImmediately = true;
    public $date_open = null;
    public $time_open = null;

    // Rubric Setting
    public $rubric = [];
    public $new_criterion = "";
    public $new_performance_rating = "";
    public $showEdit = false;
    public $editDialogTitle = "";
    public $editDialogInputValue = "";
    public $editing;

    protected $messages = [
        'items.*.question.required' => 'Question fields are required.',
        'items.*.answer.required' => 'Please specify the correct answer.',
        'items.*.options.*.required' => 'Option fields are required.',
        'items.*.enumerationItems.*.required' => 'Enumeration items are required.',
        'items.*.points.min' => 'Item scores must be greater than 0.',
        'items.*.points.max' => 'Item scores must not be greater than 100.',
        'items.*.points.required' => 'Item scores are required.',
        'items.*.answer.required_with' => 'Please specify the correct answer.',
        // Rubric Setting
        'editDialogInputValue.required' => 'This field cannot be blank.',
        'editDialogInputValue.max' => 'Criterion weights must not exceed 100%.',
        'editDialogInputValue.min' => 'Criterion weights cannot be less than 1%.'
    ];

    protected $listeners = ['rubricSet', 'hideRubricEdit'];


    public function mount()
    {
        $teacher = auth()->user()->teacher;
        if (request('draft_id')) {
            $draft = Draft::find(request('draft_id'));
            if ($draft?->teacher_id != $teacher->id) abort(403);
        } else {
            if (!request('module') || !request('course') || !request('type')) abort(404);
            if (!TaskType::whereName(request('type'))->first()) abort(403);
            $module = Module::findOrFail(request('module'));
            $course = Course::findOrFail(request('course'));
            $isAllowed = $module->section->teacher_id == auth()->user()->teacher->id;
            if (!$isAllowed) abort(403);
            $isAllowed = (bool) $course->teachers->where('id', $teacher->id)->first();
            if (!$isAllowed) abort(403);
        }

        $this->modules = Module::get();
        if (request('draft_id')) {
            [
                'task_name' => $this->task_name,
                'date_due' => $this->date_due,
                'time_due' => $this->time_due,
                'date_open' => $this->date_open,
                'time_open' => $this->time_open,
                'rubric' => $this->rubric,
                'task_rubric' => $this->task_rubric,
                'matchingTypeOptions' => $this->matchingTypeOptions,
                'type' => $this->type,
                'items' => $this->items,
                'task_instructions' => $this->task_instructions,
                'allSection' => $this->allSection,
                'noDeadline' => $this->noDeadline,
                'openImmediately' => $this->openImmediately,
                'isRubricSet' => $this->isRubricSet,
                'total_points' => $this->total_points,
            ] = $draft;
            $this->module = Module::find($draft->module_id);
            $this->course = Course::find($draft->course_id);
            $this->draft = $draft;
        } else {
            $this->date_due = Carbon::tomorrow()->format('Y-m-d');
            $this->module = Module::findOrFail(request('module'));
            $this->course = Course::findOrFail(request('course'));
            $this->type = request('type');
            array_push($this->files, ['fileArray' => []]);
            array_push($this->items, [
                'files' => [],
                'question' => '',
                'points' => "1",
                'options' => [],
                'enumerationItems' => [],
                'torf' => false,
                'essay' => false,
                'enumeration' => false,
                'attachment' => false,
            ]);
            //
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
    }

    public function saveDraft()
    {
        $draft = $this->draft ?? Draft::make();
        $draft->task_name = $this->task_name;
        $draft->task_instructions = $this->task_instructions;
        $draft->matchingTypeOptions = $this->matchingTypeOptions;
        $draft->date_due = $this->date_due;
        $draft->time_due = $this->time_due;
        $draft->date_open = $this->date_open;
        $draft->time_open = $this->time_open;
        $draft->module_id = $this->module->id;
        $draft->course_id = $this->course->id;
        $draft->teacher_id = auth()->user()->teacher->id;
        $draft->items = $this->items;
        $draft->task_rubric = $this->task_rubric;
        $draft->rubric = $this->rubric;
        $draft->type = $this->type;
        $draft->allSection = $this->allSection;
        $draft->noDeadline = $this->noDeadline;
        $draft->openImmediately = $this->openImmediately;
        $draft->isRubricSet = $this->isRubricSet;
        $draft->total_points = $this->total_points;
        $draft->save();
        $this->draft = $draft;
        $this->alert('success', 'Draft saved.');
    }

    public function rubricSet($rubric)
    {
        $this->task_rubric = $rubric;
        $this->isRubricSet = true;
    }

    public function hideRubricEdit()
    {
        $this->showrubric = false;
    }

    public function ExpectAttachment($key)
    {
        $this->items[$key]['attachment'] = !$this->items[$key]['attachment'];
        if ($this->items[$key]['attachment']) $this->alert('success', 'Question ' . ($key + 1) . ' will require file attachment.', ['position' => 'center', 'timer' => 1000]);
        else $this->alert('success', 'Question ' . ($key + 1) . ' will not require file attachment.', ['position' => 'center', 'timer' => 1000]);
    }
    public function TorFtrigger($key)
    {
        $this->items[$key]['torf'] = !$this->items[$key]['torf'];
        unset($this->items[$key]['answer']);
        if ($this->items[$key]['torf']) {
            $this->items[$key]['options'] = [];
            array_unshift($this->items[$key]['options'], "True", "False");
            $this->items[$key]['essay'] = false;
            $this->items[$key]['enumeration'] = false;
            $this->items[$key]['enumerationItems'] = [];
            $this->alert('success', 'Question ' . ($key + 1) . ' is a True or False type.', ['position' => 'center', 'timer' => 1000]);
        } else {
            array_splice($this->items[$key]['options'], 0, 2);
        }
    }

    public function enumerationTrigger($key)
    {
        $this->items[$key]['enumeration'] = !$this->items[$key]['enumeration'];
        if ($this->items[$key]['enumeration']) {
            $this->items[$key]['options'] = [];
            $this->items[$key]['torf'] = false;
            $this->items[$key]['essay'] = false;
            unset($this->items[$key]['answer']);
            array_push($this->items[$key]['enumerationItems'], '');
            array_push($this->items[$key]['enumerationItems'], '');
            $this->alert('success', 'Question ' . ($key + 1) . ' is an Enumeration type.', ['position' => 'center', 'timer' => 1000]);
        } else $this->items[$key]['enumerationItems'] = [];
    }

    public function removeEnumItem($key, $enum)
    {
        array_splice($this->items[$key]['enumerationItems'], $enum, 1);
    }

    public function addEnumerationItem($key)
    {
        array_push($this->items[$key]['enumerationItems'], '');
    }

    public function Essaytrigger($key)
    {
        $this->items[$key]['essay'] = !$this->items[$key]['essay'];
        if ($this->items[$key]['essay'] && isset($this->items[$key]['answer'])) {
            $this->items[$key]['options'] = [];
            unset($this->items[$key]['answer']);
        }
        if ($this->items[$key]['essay']) {
            $this->items[$key]['enumeration'] = false;
            $this->items[$key]['enumerationItems'] = [];
            $this->items[$key]['torf'] = false;
            $this->items[$key]['options'] = [];
            $this->alert('success', 'Question ' . ($key + 1) . ' is an essay type.', ['position' => 'center', 'timer' => 1000]);
            unset($this->items[$key]['answer']);
        }
    }

    public function updated($name, $value)
    {
        if (preg_match('/items.\d+.points/', $name)) {
            if (!is_numeric($value)) {
                $this->items[intval(explode('.', $name)[1])]['points'] = 1;
            }
        }
    }

    public function render()
    {
        $this->total_points = array_sum(array_map(function ($i) {
            if ($i['enumeration'])
                return $i['points'] * count($i['enumerationItems']);
            else return $i['points'];
        }, $this->items));
        $rubrics_weight_total = array_sum(array_map(function ($r) {
            return $r['weight'];
        }, $this->rubric['criteria']));
        return view('livewire.task-maker', ['rubrics_weight_total' => $rubrics_weight_total])
            ->extends('layouts.master')
            ->section('content');
    }
    public function addItem($key)
    {
        $this->emit('item-added');
        array_push($this->files, ['fileArray' => []]);
        array_push($this->items, [
            'files' => [],
            'question' => '',
            'points' => "1",
            'options' => [],
            'enumerationItems' => [],
            'torf' => false,
            'essay' => false,
            'enumeration' => false,
            'attachment' => false,
        ]);
    }
    public function addOption($key)
    {
        if (!count($this->items[$key]['options'])) {
            unset($this->items[$key]['answer']);
        }
        array_push($this->items[$key]['options'], '');
    }
    public function removeOption($key, $id)
    {
        array_splice($this->items[$key]['options'], $id, 1);
        if (isset($this->items[$key]['answer']) && $this->items[$key]['answer'] == $id) {
            unset($this->items[$key]['answer']);
        }
    }
    public function removeItem($key)
    {
        array_splice($this->items, $key, 1);
    }
    public function saveTask()
    {
        // Check if task should be given to all sections under this course of the authenticated teacher
        // Return error if not all sections have the same module
        if ($this->allSection) {
            $sections = $this->course->sections()->where('teacher_id', auth()->user()->teacher->id)->get();
            foreach ($sections as  $section) {
                $module = $section->modules()->where('course_id', $this->course->id)->where('name', $this->module->name)->first();
                if (!$module) {
                    return $this->alert('error', 'Some sections do not have this module.', ['toast' => false, 'position' => 'center']);
                }
            }
        }

        // Validate inputs for each task items
        $this->validate([
            'task_name' => 'required|max:50',
            'task_instructions' => 'max:150',
            'items.*.question' => 'required',
            'items.*.options.*' => 'required',
            'items.*.enumerationItems.*' => 'required',
            'items.*.answer' => 'required_with:items.*.options',
            'items.*.points' => 'required|numeric|min:1|max:100',
        ]);

        // Parse deadline and open date
        $carbondue = Carbon::parse($this->date_due . ' ' . $this->time_due)->format('M d,Y - h:i a');
        $carbonopen = Carbon::parse($this->date_open . ' ' . $this->time_open)->format('M d,Y - h:i a');

        // Insert item number for each items
        for ($i = 0; $i < count($this->items); $i++) {
            $this->items[$i]['item_no'] = $i + 1;
        }

        // Check if deadline and open date and time set is valid
        if (!$this->noDeadline && Carbon::parse($this->date_due . ' ' . $this->time_due) < now()->addHour()) return session()->flash('error', 'Task deadline must at least be one hour from now.');
        if (!$this->openImmediately) {
            $this->validate([
                'date_open' => 'required',
                'time_open' => 'required',
            ]);
            if (Carbon::now()->addMinutes(30) > Carbon::parse($this->date_open . ' ' . $this->time_open)) return session()->flash('error', 'Task opening must at least be 30 minutes later than the current time.');
            $due = Carbon::parse($this->date_due . ' ' . $this->time_due);
            $open = Carbon::parse($this->date_open . ' ' . $this->time_open);
            if ($due->isBefore($open)) return session()->flash('error', 'Cannot set the deadline before task opens.');
        }

        // Check if any item is of type essay
        // Show rubric creator if true
        foreach ($this->items as  $key => $item) {
            if ($item['essay'] && !$this->isRubricSet) {
                $this->showrubric = true;
                return false;
            }
        }

        foreach ($this->items as  $key => $item) {
            if (isset($item['answer']) && $item['options']) {
                $this->items[$key]['answer'] = $item['options'][$item['answer']];
            }
            if (isset($this->files[$key]['fileArray']))
                $this->items[$key]['files'] = $this->files[$key]['fileArray'];
        }

        foreach ($this->items as $key => $item) {
            if (!$item['enumeration'] && !isset($item['answer'])) $this->autocorrect = false;
        }
        foreach ($this->items as $key => $item) {
            $this->items[$key]['files'] = [];
            foreach ($item['enumerationItems'] as $enumId => $enumItem) {
                $this->items[$key]['enumerationItems'][$enumId] = sanitizeString($enumItem);
            }
            foreach ($item['files'] as $id => $file) {
                $filename = $file->getClientOriginalName();
                $url = $file->store("", "tasks");
                $match = gdriver($url);
                array_push($this->items[$key]['files'], ['name' => $filename, 'google_id' => $match['id'], 'url' => $url]);
            }
        }

        DB::transaction(function () {
            if (!$this->task_instructions) $this->task_instructions = null;
            if (!$this->noDeadline) $deadline = $this->date_due . ' ' . $this->time_due;
            else $deadline = null;
            if (!$this->openImmediately) $open_on = $this->date_open . ' ' . $this->time_open;
            else $open_on = null;
            if (count($this->matchingTypeOptions)) $matchingtype_options = json_encode($this->matchingTypeOptions);
            else $matchingtype_options = null;
            if ($this->allSection) {
                $sections = $this->course->sections()->where('teacher_id', auth()->user()->teacher->id)->get();
                foreach ($sections as $key => $section) {
                    $module = $section->modules()->where('course_id', $this->course->id)->where('name', $this->module->name)->first();
                    $task = Task::create([
                        'quarter_id' => $module->quarter_id,
                        'autocorrect' => $this->autocorrect,
                        'module_id' => $module->id,
                        'section_id' => $section->id,
                        'teacher_id' => auth()->user()->teacher->id,
                        'task_type_id' => TaskType::where('name', $this->type)->firstOrFail()->id,
                        'name' => $this->task_name,
                        'instructions' => $this->task_instructions,
                        'max_score' => $this->total_points,
                        'essay_rubric' => json_encode($this->task_rubric),
                        'matchingtype_options' => $matchingtype_options,
                        'content' => json_encode($this->items),
                        'deadline' => $deadline,
                        'open' => $this->openImmediately,
                        'open_on' => $open_on,
                    ]);
                    if (!$this->noDeadline && $this->openImmediately) {
                        $code = Carbon::now()->timestamp;
                        CalendarEvent::create([
                            'user_id' => auth()->user()->id,
                            'code' => $code,
                            'title' => $task->name,
                            'description' => $task->name . ' for module: ' . $task->module->name,
                            'level' => 'tasks',
                            'section_id' => $task->section_id,
                            'task_id' => $task->id,
                            'start' => $task->deadline,
                            'end' => $task->deadline->addDay()->format('Y-m-d'),
                            'url' => '/task/' . $task->id,
                            'allDay' => false
                        ]);
                    }
                    if ($this->openImmediately) {
                        event(new NewTask($task, auth()->user()->teacher));
                    } else {
                        // TaskOpening::dispatch($task)->delay(Carbon::now()->addSeconds(10));
                        TaskOpening::dispatch($task)->delay(Carbon::parse($this->date_open . ' ' . $this->time_open));
                    }
                }
            } else {
                $task = Task::create([
                    'quarter_id' => $this->module->quarter_id,
                    'autocorrect' => $this->autocorrect,
                    'module_id' => $this->module->id,
                    'section_id' => $this->module->section_id,
                    'teacher_id' => auth()->user()->teacher->id,
                    'task_type_id' => TaskType::where('name', $this->type)->firstOrFail()->id,
                    'name' => $this->task_name,
                    'instructions' => $this->task_instructions,
                    'max_score' => $this->total_points,
                    'essay_rubric' => json_encode($this->task_rubric),
                    'matchingtype_options' => $matchingtype_options,
                    'content' => json_encode($this->items),
                    'deadline' => $deadline,
                    'open' => $this->openImmediately,
                    'open_on' => $open_on,
                ]);
                if (!$this->noDeadline && $this->openImmediately) {
                    $code = Carbon::now()->timestamp;
                    CalendarEvent::create([
                        'user_id' => auth()->user()->id,
                        'code' => $code,
                        'title' => $task->name,
                        'description' => $task->name . ' for module: ' . $task->module->name,
                        'level' => 'tasks',
                        'section_id' => $task->section_id,
                        'task_id' => $task->id,
                        'start' => $task->deadline,
                        'end' => $task->deadline->addDay()->format('Y-m-d'),
                        'url' => '/task/' . $task->id,
                        'allDay' => false
                    ]);
                }
                if ($this->openImmediately) {
                    event(new NewTask($task, auth()->user()->teacher));
                } else {
                    // TaskOpening::dispatch($task)->delay(Carbon::now()->addSeconds(10));
                    TaskOpening::dispatch($task)->delay(Carbon::parse($this->date_open . ' ' . $this->time_open));
                }
            }
        });
        session()->flash('message', 'Task was successfully created.');
        return redirect()->route('teacher.module', ['module' => $this->module]);
    }

    //
    public function getRating($key)
    {
        return $rating = round(100 * (1 / ($key + 1)), 2);
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

        if (count($this->rubric['criteria']) >= 5) {
            session()->flash('max_elements', 'The rubric allows maximum of five criteria only.');
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

        if (count($this->rubric['performance_rating']) >= 5) {
            session()->flash('max_elements', 'The rubric allows maximum of five performance ratings only.');
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
        $this->task_rubric = $this->rubric;
        $this->isRubricSet = true;
        $this->showrubric = false;
        $this->saveTask();
    }


    public function equalWeights()
    {
        $criterion_count = count($this->rubric['criteria']);
        foreach ($this->rubric['criteria'] as $key => $criterion) {
            $this->rubric['criteria'][$key]['weight'] = round(100 / $criterion_count, 2);
        }
    }

    public function addMatchingTypeOption()
    {
        $this->validate([
            'newMatchingTypeOption' => 'required',
        ]);
        array_push($this->matchingTypeOptions, $this->newMatchingTypeOption);
        $this->newMatchingTypeOption = "";
    }

    public function removeMatchingTypeOption($g)
    {
        array_splice($this->matchingTypeOptions, $g, 1);
    }
}
