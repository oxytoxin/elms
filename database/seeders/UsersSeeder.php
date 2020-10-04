<?php

namespace Database\Seeders;

use App\Models\Dean;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ProgramHead;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::factory()->count(100)->create();
        Teacher::factory()->count(100)->create();
        ProgramHead::create([
            'user_id' => User::factory()->create(['role_id' => 4])->id,
            'college_id' => 1,
            'department_id' => 1,
        ]);
        ProgramHead::create([
            'user_id' => User::factory()->create(['role_id' => 4])->id,
            'college_id' => 1,
            'department_id' => 2,
        ]);
        ProgramHead::create([
            'user_id' => User::factory()->create(['role_id' => 4])->id,
            'college_id' => 2,
            'department_id' => 3,
        ]);
        ProgramHead::create([
            'user_id' => User::factory()->create(['role_id' => 4])->id,
            'college_id' => 2,
            'department_id' => 4,
        ]);
        ProgramHead::create([
            'user_id' => User::factory()->create(['role_id' => 4])->id,
            'college_id' => 3,
            'department_id' => 5,
        ]);
        ProgramHead::create([
            'user_id' => User::factory()->create(['role_id' => 4])->id,
            'college_id' => 3,
            'department_id' => 6,
        ]);
        ProgramHead::create([
            'user_id' => User::factory()->create(['role_id' => 4])->id,
            'college_id' => 4,
            'department_id' => 7,
        ]);
        ProgramHead::create([
            'user_id' => User::factory()->create(['role_id' => 4])->id,
            'college_id' => 4,
            'department_id' => 8,
        ]);
        Dean::create([
            'user_id' => User::factory()->create(['role_id' => 5])->id,
            'college_id' => 1,
        ]);
        Dean::create([
            'user_id' => User::factory()->create(['role_id' => 5])->id,
            'college_id' => 2,
        ]);
        Dean::create([
            'user_id' => User::factory()->create(['role_id' => 5])->id,
            'college_id' => 3,
        ]);
        Dean::create([
            'user_id' => User::factory()->create(['role_id' => 5])->id,
            'college_id' => 4,
        ]);
    }
}
