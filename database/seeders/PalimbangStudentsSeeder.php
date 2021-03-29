<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PalimbangStudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->encodeCSV('csvs/masterlist/palimbang.csv', 6);
    }
    public function encodeCSV($path, $campus_id)
    {
        $students = [];
        $handle = fopen(storage_path($path), "r");
        while (($data = fgetcsv($handle)) !== FALSE) {
            array_push($students, $data);
        }
        array_splice($students, 0, 1);

        foreach ($students as $key => $student) {
            $u = User::create([
                'campus_id' => $campus_id,
                'name' => ucwords(trim(strtolower($student[0] . ' ' . $student[1]))),
                'email' => trim($student[2]),
                'email_verified_at' => now(),
                // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'password' => bcrypt(base64_encode(explode(' ', trim(strtolower($student[0])))[0])), // password
                'remember_token' => Str::random(10),
            ]);
            $u->roles()->attach(Role::find(2));
            $u->student()->create([
                'college_id' => 1,
                'department_id' => $this->getDepartment($student[16]),
            ]);
        }
    }
    public function getDepartment($dep)
    {
        if (str_contains($dep, 'AGRI-BUSINESS')) return 40;
        if (str_contains($dep, 'BEED')) return 41;
    }
}