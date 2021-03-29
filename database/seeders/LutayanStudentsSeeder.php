<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class LutayanStudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->encodeCSV('csvs/masterlist/lutayan.csv', 18);
    }
    public function encodeCSV($path, $college_id)
    {
        $students = [];
        $handle = fopen(storage_path($path), "r");
        while (($data = fgetcsv($handle)) !== FALSE) {
            array_push($students, $data);
        }
        foreach ($students as $key => $student) {
            $u = User::create([
                'campus_id' => 7,
                'name' => ucwords(trim(strtolower($student[1] . ' ' . $student[0]))),
                'email' => str_replace('ñ', 'n', str_replace(' ', '', strtolower(str_replace(['JR.', 'III', 'IV', 'II'], '', $student[1]) . $student[0] . '@sksu.edu.ph'))),
                'email_verified_at' => now(),
                // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'password' => bcrypt(base64_encode(explode(' ', trim(strtolower($student[1])))[0])), // password
                'remember_token' => Str::random(10),
            ]);
            $u->roles()->attach(Role::find(2));
            $u->student()->create([
                'college_id' => $college_id,
                'department_id' => $this->getDepartment($student[2]),
            ]);
        }
    }

    public function getDepartment($dep)
    {
        if (str_contains($dep, 'BAT')) return 42;
    }
}