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
            'name' => 'Civil Engineering',
            'college_id' => 1
        ]);
        Department::create([
            'name' => 'Computer Engineering',
            'college_id' => 1
        ]);
        Department::create([
            'name' => 'Secondary Education',
            'college_id' => 2
        ]);
        Department::create([
            'name' => 'Elementary Education',
            'college_id' => 2
        ]);
        Department::create([
            'name' => 'Accountancy',
            'college_id' => 3
        ]);
        Department::create([
            'name' => 'Financial Management',
            'college_id' => 3
        ]);
        Department::create([
            'name' => 'English',
            'college_id' => 4
        ]);
        Department::create([
            'name' => 'Political Science',
            'college_id' => 4
        ]);
    }
}
