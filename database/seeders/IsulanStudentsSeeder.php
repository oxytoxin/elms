<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class IsulanStudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->encodeCSV('csvs/masterlist/isulan.csv', 2);
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
                'name' => ucwords(trim(strtolower($student[1] . ' ' . $student[0]))),
                'email' => str_replace('ñ', 'n', str_replace(' ', '', strtolower(str_replace(['JR.', 'III', 'IV', 'II'], '', $student[1]) . $student[0] . '@sksu.edu.ph'))),
                'email_verified_at' => now(),
                // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'password' => bcrypt(base64_encode(explode(' ', trim(strtolower($student[1])))[0])), // password
                'remember_token' => Str::random(10),
            ]);
            $u->roles()->attach(Role::find(2));
            $u->student()->create([
                'college_id' => $this->getCollege($student[9]),
                'department_id' => $this->getDepartment($student[9]),
            ]);
        }
    }

    public function getDepartment($dep)
    {
        if (str_contains($dep, 'Civil Engineering')) return 14;
        if (str_contains($dep, 'Computer Engineering')) return 15;
        if (str_contains($dep, 'Electronics Engineering')) return 16;
        if (str_contains($dep, 'Computer Science')) return 17;
        if (str_contains($dep, 'Information Technology')) return 18;
        if (str_contains($dep, 'Information Systems')) return 19;
        if (str_contains($dep, 'BTVTE')) return 20;
        if (str_contains($dep, 'BIT-')) return 45;
        if (str_contains($dep, 'BSIT-')) return 45;
    }

    public function getCollege($dep)
    {
        if (str_contains($dep, 'Civil Engineering')) return 6;
        if (str_contains($dep, 'Computer Engineering')) return 6;
        if (str_contains($dep, 'Electronics Engineering')) return 6;
        if (str_contains($dep, 'Computer Science')) return 7;
        if (str_contains($dep, 'Information Technology')) return 7;
        if (str_contains($dep, 'Information Systems')) return 7;
        if (str_contains($dep, 'BTVTE')) return 8;
        if (str_contains($dep, 'BIT-')) return 8;
        if (str_contains($dep, 'BSIT-')) return 8;
    }
}
