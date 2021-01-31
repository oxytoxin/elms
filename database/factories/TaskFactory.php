<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Module;
use App\Models\Section;
use App\Models\Teacher;
use App\Models\TaskType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $t = Teacher::get()->count();
        $m = Module::get()->count();
        $k = TaskType::get()->count();
        return [
            'module_id' => rand(1, $m),
            'teacher_id' => rand(1, $t),
            'section_id' => Section::get()->random()->id,
            'task_type_id' => rand(1, $k),
            'name' => $this->faker->catchPhrase,
            'max_score' => 88,
            'essay_rubric' => '{"criteria":[{"name":"Structure (Spelling, Grammar, etc.)","weight":50},{"name":"Content (Relevance to theme, coherence, etc.)","weight":50}],"performance_rating":["Excellent","Good","Satisfactory"]}',
            'matchingtype_options' => '["Option1","Option2","Option3","Option4","Option5"]',
            'content' => '[{"files":[],"question":"What is question 1?","points":"10","options":[],"enumerationItems":[],"torf":false,"essay":false,"enumeration":false,"attachment":false,"answer":"Option1","item_no":1},{"files":[],"question":"Which is question 2?","points":"5","options":["This is option 1","This is option 2","This is option 3"],"enumerationItems":[],"torf":false,"essay":false,"enumeration":false,"attachment":false,"answer":"This is option 1","item_no":2},{"files":[],"question":"This is question 3?","points":"10","options":["True","False"],"enumerationItems":[],"torf":true,"essay":false,"enumeration":false,"attachment":false,"answer":"True","item_no":3},{"files":[],"question":"This is question 4?","points":"30","options":[],"enumerationItems":[],"torf":false,"essay":true,"enumeration":false,"attachment":false,"item_no":4},{"files":[],"question":"This is question 5?","points":"30","options":[],"enumerationItems":[],"torf":false,"essay":false,"enumeration":false,"attachment":true,"item_no":5},{"files":[],"question":"This is question 6?","points":"1","options":[],"enumerationItems":["Item 1","Item 2","Item 3"],"torf":false,"essay":false,"enumeration":true,"attachment":false,"item_no":6}]',
            'deadline' => Carbon::now()->addDays(2),
        ];
    }
}