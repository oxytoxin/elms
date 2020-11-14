<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Module;
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
            'task_type_id' => rand(1, $k),
            'name' => $this->faker->catchPhrase,
            'max_score' => intdiv(rand(20, 100), 10) * 10,
            'content' => json_encode([]),
            'deadline' => Carbon::tomorrow()->format('Y-m-d H:i:s')

        ];
    }
}
