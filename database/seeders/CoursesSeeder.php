<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::factory()->count(100)->create()->each(function ($c) {
            $rand = rand(1, 7);
            $c->image()->create([
                'url' => "/img/bg/bg($rand).jpg"
            ]);
        });
    }
}
