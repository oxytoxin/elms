<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\College;
use App\Models\Teacher;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $college = College::find($this->faker->numberBetween(1, 4));
        return [
            'user_id' => User::factory()->create(['role_id' => 3])->id,
            'college_id' => $college->id,
            'department_id' => $college->departments->random()->id,
        ];
    }
}
