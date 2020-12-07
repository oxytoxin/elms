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
            'max_score' => intdiv(rand(20, 100), 10) * 10,
            'essay_rubric' => '{"criteria":[{"name":"Structure (Spelling, Grammar, etc.)","weight":50},{"name":"Content (Relevance to theme, coherence, etc.)","weight":50}],"performance_rating":["Excellent","Good","Satisfactory"]}',
            'content' => '[{"files":[],"question":"What is my name?","points":"10","options":[],"torf":false,"essay":false,"attachment":false,"item_no":1},{"files":[],"question":"Solve the following and submit a picture of your solutions","points":"20","options":[],"torf":false,"essay":false,"attachment":true,"item_no":2},{"files":[],"question":"Explain why I am important.","points":"30","options":[],"torf":false,"essay":true,"attachment":false,"item_no":3},{"files":[],"question":"Which of the following is correct?","points":"5","options":["This is not correct.","The others are mistakes.","None of the above."],"torf":false,"essay":false,"attachment":false,"answer":"The others are mistakes.","item_no":4},{"files":[],"question":"I am an important question.","points":"10","options":["True","False"],"torf":true,"essay":false,"attachment":false,"answer":"True","item_no":5}]',
            'deadline' => Carbon::tomorrow()->format('Y-m-d H:i:s')

        ];
    }
}
