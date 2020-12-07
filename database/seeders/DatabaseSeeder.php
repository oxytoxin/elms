<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Database\Seeders\MiscSeeder;
use Database\Seeders\RolesSeeder;
use Database\Seeders\UsersSeeder;
use Database\Seeders\Bootstrapper;
use Database\Seeders\CollegeSeeder;
use Database\Seeders\CoursesSeeder;
use Database\Seeders\TaskTypeSeeder;
use Database\Seeders\DepartmentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CollegeSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        DB::unprepared(file_get_contents('database/seeders/subjects.sql'));
        $this->call(CoursesSeeder::class);
        DB::unprepared(file_get_contents('database/seeders/prospectus.sql'));
        $this->call(TaskTypeSeeder::class);
        $this->call(MiscSeeder::class);
        $this->call(Bootstrapper::class);
    }
}
