<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class Lutayan2StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->encodeCSV('csvs/masterlist/lutayan2.csv', 18);
    }
    public function encodeCSV($path, $college_id)
    {
        $students = [];
        $handle = fopen(storage_path($path), "r");
        while (($data = fgetcsv($handle)) !== FALSE) {
            array_push($students, $data);
        }
        array_splice($students, 0, 1);
        foreach ($students as $key => $student) {
            $name = explode(', ', $student[0]);
            $u = User::create([
                'campus_id' => 7,
                'name' => ucwords(trim(strtolower($name[1] . ' ' . $name[0]))),
                'email' => str_replace('ñ', 'n', str_replace(' ', '', strtolower(str_replace(['JR.', 'III', 'IV', 'II'], '', $name[1]) . $name[0] . '@sksu.edu.ph'))),
                'email_verified_at' => now(),
                // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'password' => bcrypt(base64_encode(explode(' ', trim(strtolower($name[1])))[0])), // password
                'remember_token' => Str::random(10),
            ]);
            $u->roles()->attach(Role::find(2));
            $u->student()->create([
                'college_id' => $this->getCollege($student[4]),
                'department_id' => $this->getDepartment($student[4]),
            ]);
        }
    }

    public function getDepartment($dep)
    {
        if (str_contains($dep, 'Agricultural Technology')) return 42;
        if (str_contains($dep, 'Elementary Education')) return 44;
        if (str_contains($dep, 'Agriculture')) return 43;
    }
    public function getCollege($dep)
    {
        if (str_contains($dep, 'Agricultural Technology')) return 18;
        if (str_contains($dep, 'Elementary Education')) return 19;
        if (str_contains($dep, 'Agriculture')) return 18;
    }
}