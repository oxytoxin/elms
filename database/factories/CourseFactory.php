<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\College;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $college = College::find($this->faker->numberBetween(1, 4));
        $name = strtoupper($this->faker->catchPhrase);
        $code = explode(' ', $name);
        $coursecode = '';
        foreach ($code as $c) {
            $coursecode .= $c[0];
        }
        return [
            'code' => $coursecode . $this->faker->numerify('###'),
            'name' => $name,
            'units' => 3.00,
            // 'college_id' => $college->id,
            // 'department_id' => $college->departments->random()->id,
        ];
    }
}
