<?php

namespace Database\Seeders;

use App\Models\Dean;
use App\Models\Role;
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
        Student::factory()->count(100)->create()->each(function ($s) {
            $s->user->roles()->attach(Role::find(2));
        });
        Teacher::factory()->count(100)->create()->each(function ($s) {
            $s->user->roles()->attach(Role::find(3));
        });
        ProgramHead::create([
            'user_id' => User::factory()->create()->id,
            'college_id' => 1,
            'department_id' => 1,
        ])->user->roles()->attach(Role::find(4));
        ProgramHead::create([
            'user_id' => User::factory()->create()->id,
            'college_id' => 1,
            'department_id' => 2,
        ])->user->roles()->attach(Role::find(4));
        ProgramHead::create([
            'user_id' => User::factory()->create()->id,
            'college_id' => 2,
            'department_id' => 3,
        ])->user->roles()->attach(Role::find(4));
        ProgramHead::create([
            'user_id' => User::factory()->create()->id,
            'college_id' => 2,
            'department_id' => 4,
        ])->user->roles()->attach(Role::find(4));
        ProgramHead::create([
            'user_id' => User::factory()->create()->id,
            'college_id' => 3,
            'department_id' => 5,
        ])->user->roles()->attach(Role::find(4));
        ProgramHead::create([
            'user_id' => User::factory()->create()->id,
            'college_id' => 3,
            'department_id' => 6,
        ])->user->roles()->attach(Role::find(4));
        ProgramHead::create([
            'user_id' => User::factory()->create()->id,
            'college_id' => 4,
            'department_id' => 7,
        ])->user->roles()->attach(Role::find(4));
        ProgramHead::create([
            'user_id' => User::factory()->create()->id,
            'college_id' => 4,
            'department_id' => 8,
        ])->user->roles()->attach(Role::find(4));
        Dean::create([
            'user_id' => User::factory()->create()->id,
            'college_id' => 1,
        ])->user->roles()->attach(Role::find(5));
        Dean::create([
            'user_id' => User::factory()->create()->id,
            'college_id' => 2,
        ])->user->roles()->attach(Role::find(5));
        Dean::create([
            'user_id' => User::factory()->create()->id,
            'college_id' => 3,
        ])->user->roles()->attach(Role::find(5));
        Dean::create([
            'user_id' => User::factory()->create()->id,
            'college_id' => 4,
        ])->user->roles()->attach(Role::find(5));
        User::find(201)->roles()->attach(Role::find(3));
        $s = Student::find(1);
        Teacher::create([
            'user_id' => 201,
            'department_id' => $s->department_id,
            'college_id' => $s->college_id
        ]);
    }
}
