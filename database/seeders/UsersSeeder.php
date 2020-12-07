<?php

namespace Database\Seeders;

use App\Models\College;
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
        $s = Student::factory()->create([
            'college_id' => 1,
            'department_id' => 1,
        ]);
        $s->user->roles()->attach(Role::find(2));
        Student::factory()->count(99)->create()->each(function ($s) {
            $s->user->roles()->attach(Role::find(2));
        });
        Teacher::factory()->count(100)->create()->each(function ($s) {
            $s->user->roles()->attach(Role::find(3));
        });

        $colleges = College::all();

        foreach ($colleges as $college) {
            foreach ($college->departments as  $department) {
                ProgramHead::create([
                    'user_id' => User::factory()->create()->id,
                    'college_id' => $college->id,
                    'department_id' => $department->id,
                ])->user->roles()->attach(Role::find(4));
            }
            Dean::create([
                'user_id' => User::factory()->create()->id,
                'college_id' => $college->id,
            ])->user->roles()->attach(Role::find(5));
        }
        User::find(201)->roles()->attach(Role::find(3));
        Teacher::create([
            'user_id' => 201,
            'department_id' => $s->department_id,
            'college_id' => $s->college_id
        ]);
    }
}
