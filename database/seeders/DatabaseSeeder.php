<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CampusSeeder::class);
        $this->call(CollegeSeeder::class);
        $this->call(RolesSeeder::class);
        // $this->call(DepartmentSeeder::class);
        // $this->call(DeploySeeder::class);
        DB::unprepared(file_get_contents('database/seeders/subjects.sql'));
        $this->call(AccessCoursesSeeder::class);
        $this->call(CoursesSeeder::class);
        // DB::unprepared(file_get_contents('database/seeders/prospectus.sql'));
        $this->call(TaskTypeSeeder::class);
        $this->call(FacultySeeder::class);
        if (app()->environment('production')) {
            $this->call(AccessCTEStudentsSeeder::class);
            $this->call(AccessAgriStudentsSeeder::class);
            $this->call(AccessCrimStudentsSeeder::class);
            $this->call(AccessHealthSciStudentsSeeder::class);
        }
        $this->call(DeanSeeder::class);
        // $this->call(MiscSeeder::class);
        // $this->call(ChatSeeder::class);
    }
}