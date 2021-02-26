<?php

namespace Database\Seeders;

use App\Models\Dean;
use App\Models\Role;
use App\Models\User;
use App\Models\Campus;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ProgramHead;
use Illuminate\Support\Str;
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
        $c = Campus::create([
            'name' => 'Isulan Campus',
        ]);
        $u = User::create([
            'campus_id' => $c->id,
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
            'campus_id' => $c->id,
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
            'campus_id' => $c->id,
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
            'campus_id' => $c->id,
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
            'campus_id' => $c->id,
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
            'campus_id' => $c->id,
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
            'campus_id' => $c->id,
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
            'campus_id' => $c->id,
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
            'campus_id' => $c->id,
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
            'campus_id' => $c->id,
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
            'campus_id' => $c->id,
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
            'campus_id' => $c->id,
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
            'campus_id' => $c->id,
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
            'campus_id' => $c->id,
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
            'campus_id' => $c->id,
            'name' => 'Kristine Mae Ampas',
            'email' => 'kristinemaeampas@sksu.edu.ph',
            'password' => bcrypt('password'),
        ]);
        Teacher::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(3));
        $u = User::create([
            'campus_id' => $c->id,
            'name' => 'Edmarlyn Porras',
            'email' => 'edmarlyn.porras@sksu.edu.ph',
            'password' => bcrypt('password'),
        ]);
        Teacher::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(3));
        $u = User::create([
            'campus_id' => $c->id,
            'name' => 'Cerilo Rubin',
            'email' => 'cerilorubin@sksu.edu.ph',
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
        $students = [];
        $handle = fopen(storage_path("app/emails.csv"), "r");
        while (($data = fgetcsv($handle)) !== FALSE) {
            array_push($students, $data);
        }
        foreach ($students as $key => $student) {
            $u = User::create([
                'campus_id' => Campus::get()->random()->id,
                'name' => ucwords($student[0]),
                'email' => strtolower($student[1]),
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);
            $u->roles()->attach(Role::find(2));
            $u->student()->create([
                'college_id' => 2,
                'department_id' => 5,
            ]);
        }
    }
}