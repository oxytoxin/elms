<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'name' => 'Bachelor of Science in Civil Engineering (BSCE)',
            'college_id' => 1
        ]);
        Department::create([
            'name' => 'Bachelor of Science in Computer Engineering (BSCpE)',
            'college_id' => 1
        ]);
        Department::create([
            'name' => 'Bachelor of Science in Electronics Engineering (BSECE)',
            'college_id' => 1
        ]);
        Department::create([
            'name' => 'Bachelor of Science in Computer Science (BSCS)',
            'college_id' => 2
        ]);
        Department::create([
            'name' => 'Bachelor of Science in Information Technology (BSIT)',
            'college_id' => 2
        ]);
        Department::create([
            'name' => 'Bachelor of Science in Information Systems (BSIS)',
            'college_id' => 2
        ]);
        Department::create([
            'name' => 'Bachelor in Technical-Vocational Teacher Education (BTVTEd) - Food Service Management',
            'college_id' => 3
        ]);
        Department::create([
            'name' => 'Bachelor in Technical-Vocational Teacher Education (BTVTEd) - Drafting Technology',
            'college_id' => 3
        ]);
        Department::create([
            'name' => 'Bachelor in Technical-Vocational Teacher Education (BTVTEd) - Automotive Technology',
            'college_id' => 3
        ]);
        Department::create([
            'name' => 'Bachelor in Technical-Vocational Teacher Education (BTVTEd) - Electrical Technology',
            'college_id' => 3
        ]);
        Department::create([
            'name' => 'Bachelor in Technical-Vocational Teacher Education (BTVTEd) - Electronic Technology',
            'college_id' => 3
        ]);
        Department::create([
            'name' => 'Bachelor in Technical-Vocational Teacher Education (BTVTEd) - Civil Technology',
            'college_id' => 3
        ]);
    }
}
