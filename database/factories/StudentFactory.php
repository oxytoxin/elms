<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\College;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;




    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $college = College::find($this->faker->numberBetween(1, 4));
        return [
            'user_id' => User::factory()->create(['email' => 1000 + User::count() + 1 . '@gmail.com'])->id,
            'college_id' => $college->id,
            'department_id' => $college->departments->random()->id,
        ];
    }
}
