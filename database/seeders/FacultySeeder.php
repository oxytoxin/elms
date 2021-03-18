<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Campus;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->encodeCSV("csvs/access.csv");
        $this->encodeCSV("csvs/isulan.csv");
        $this->encodeCSV("csvs/palimbang.csv");
        $this->encodeCSV("csvs/kalamansig.csv");
        $this->encodeCSV("csvs/bagumbayan.csv");
        $this->encodeCSV("csvs/lutayan.csv");
        $this->encodeCSV("csvs/tacurong.csv");
    }

    public function encodeCSV($path)
    {
        $teachers = [];
        $handle = fopen(storage_path($path), "r");
        while (($data = fgetcsv($handle)) !== FALSE) {
            array_push($teachers, $data);
        }
        foreach ($teachers as $key => $teacher) {
            $u = User::create([
                'campus_id' => Campus::get()->random()->id,
                'name' => ucwords($teacher[0]),
                'email' => strtolower($teacher[1]),
                'email_verified_at' => now(),
                'password' => bcrypt(explode(' ', trim($teacher[0]))[0]), // password
                'remember_token' => Str::random(10),
            ]);
            $u->roles()->attach(Role::find(3));
            $u->teacher()->create([
                'college_id' => 2,
                'department_id' => 5,
            ]);
        }
    }
}