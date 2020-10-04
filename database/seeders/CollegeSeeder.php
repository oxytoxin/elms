<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Seeder;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        College::create([
            'name' => 'College of Engineering'
        ]);
        College::create([
            'name' => 'College of Education'
        ]);
        College::create([
            'name' => 'College of Accountancy and Business Administration'
        ]);
        College::create([
            'name' => 'College of Arts and Sciences'
        ]);
    }
}
