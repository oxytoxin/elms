<?php

namespace Database\Seeders;

use App\Models\Dean;
use App\Models\ProgramHead;
use App\Models\Role;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DeploySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = User::create([
            'name' => 'Cecilia E. Gener',
            'email' => 'cecilia.gener@sksu.edu.ph',
            'password' => bcrypt('password'),
        ]);

        Dean::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        // ProgramHead::create([
        //     'user_id' => $u->id,
        //     'college_id' => 2
        // ]);
        $u->roles()->attach(Role::find(5));
        // $u->roles()->attach(Role::find(4));
        Teacher::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(3));
        $u = User::create([
            'name' => 'Elmer C. Buenavides',
            'email' => 'elmer.buenavides@sksu.edu.ph',
            'password' => bcrypt('password'),
        ]);
        Teacher::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(3));

        $u = User::create([
            'name' => 'Mary Grace L. Perocho',
            'email' => 'marygrace.perocho@sksu.edu.ph',
            'password' => bcrypt('password'),
        ]);
        Teacher::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(3));
        $u = User::create([
            'name' => 'Cyrus B. Rael',
            'email' => 'cyrus.rael@sksu.edu.ph',
            'password' => bcrypt('password'),
        ]);
        Teacher::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(3));
        $u = User::create([
            'name' => 'Roma Amor C. Castromayor',
            'email' => 'romaamor.castromayor@sksu.edu.ph',
            'password' => bcrypt('password'),
        ]);
        Teacher::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(3));
        $u = User::create([
            'name' => 'Elbren O. Antonio',
            'email' => 'elbren.antonio@sksu.edu.ph',
            'password' => bcrypt('password'),
        ]);
        Teacher::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(3));
        $u = User::create([
            'name' => 'Velessa Dulin',
            'email' => 'velessa.dulin@sksu.edu.ph',
            'password' => bcrypt('password'),
        ]);
        Teacher::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(3));
        $u = User::create([
            'name' => 'Kyrene L. Dizon',
            'email' => 'kyrene.dizon@sksu.edu.ph',
            'password' => bcrypt('password'),
        ]);
        Teacher::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(3));
        $u = User::create([
            'name' => 'Joe H. Selayro',
            'email' => 'joe.selayro@sksu.edu.ph',
            'password' => bcrypt('password'),
        ]);
        Teacher::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(3));
        $u = User::create([
            'name' => 'Mark Ian Orcajada',
            'email' => 'markian.orcajada@sksu.edu.ph',
            'password' => bcrypt('password'),
        ]);
        Teacher::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(3));
        $u = User::create([
            'name' => 'Alexis D. Apresto',
            'email' => 'alexis.apresto@sksu.edu.ph',
            'password' => bcrypt('password'),
        ]);
        Teacher::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(3));
        $u = User::create([
            'name' => 'Florlyn Remegio',
            'email' => 'florlyn.remegio@sksu.edu.ph',
            'password' => bcrypt('password'),
        ]);
        Teacher::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(3));
        $u = User::create([
            'name' => 'Ivy Lynn Madriaga',
            'email' => 'ivylynn.madriaga@sksu.edu.ph',
            'password' => bcrypt('password'),
        ]);
        Teacher::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(3));
        $u = User::create([
            'name' => 'Esnehara Bagundang',
            'email' => 'esnehara.bagundang@sksu.edu.ph',
            'password' => bcrypt('password'),
        ]);
        Teacher::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(3));
        $u = User::create([
            'name' => 'Kristine Mae Ampas',
            'email' => 'kristinemae.ampas@sksu.edu.ph',
            'password' => bcrypt('password'),
        ]);
        Teacher::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(3));
        $u = User::create([
            'name' => 'Edmarlyn Porras',
            'email' => 'edmarlyn.porras@sksu.edu.ph',
            'password' => bcrypt('password'),
        ]);
        Teacher::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(3));
        Student::factory()->count(99)->create()->each(function ($s) {
            $s->user->roles()->attach(Role::find(2));
        });
    }
}
