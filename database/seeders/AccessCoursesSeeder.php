<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class AccessCoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->encodeCSV('csvs/courses/courses-final.csv');
    }

    public function encodeCSV($path)
    {
        $courses = [];
        $handle = fopen(storage_path($path), "r");
        while (($data = fgetcsv($handle)) !== FALSE) {
            array_push($courses, $data);
        }
        foreach ($courses as $key => $course) {
            $c = Course::where('code', trim(str_replace(' ', '', $course[0])))->first();
            if (!$c) {
                Course::create([
                    'code' => trim(str_replace(' ', '', $course[0])),
                    'name' => $course[1],
                    'units' => (int)$course[2]
                ]);
            }
        }
    }
}