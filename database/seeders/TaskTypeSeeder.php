<?php

namespace Database\Seeders;

use App\Models\TaskType;
use Illuminate\Database\Seeder;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaskType::create([
            'name' => 'assignment'
        ]);
        TaskType::create([
            'name' => 'quiz'
        ]);
        TaskType::create([
            'name' => 'activity'
        ]);
        TaskType::create([
            'name' => 'exam'
        ]);
    }
}
