<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Prospectus;
use App\Models\Role;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class Bootstrapper extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = User::create([
            'name' => 'Mary Grace L. Perocho',
            'email' => 'marygrace.perocho@sksu.edu.ph',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);
        $u->roles()->attach(Role::find(3));
        $u->teacher()->create(['college_id' => 2, 'department_id' => random_int(4, 6)]);
        $u = User::create([
            'name' => 'Cyrus B. Rael',
            'email' => 'cyrus.rael@sksu.edu.ph',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);
        $u->roles()->attach(Role::find(3));
        $u->teacher()->create(['college_id' => 2, 'department_id' => random_int(4, 6)]);
        $u = User::create([
            'name' => 'Cecilia E. Gener',
            'email' => 'cecilia.gener@sksu.edu.ph',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);
        $u->roles()->attach(Role::find(3));
        $u->teacher()->create(['college_id' => 2, 'department_id' => random_int(4, 6)]);
        $u = User::create([
            'name' => 'Florlyn Remegio',
            'email' => 'florlyn.remegio@sksu.edu.ph',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);
        $u->roles()->attach(Role::find(3));
        $u->teacher()->create(['college_id' => 2, 'department_id' => random_int(4, 6)]);
        $u = User::create([
            'name' => 'Mark Ian Orcajada',
            'email' => 'markian.orcajada@sksu.edu.ph',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);
        $u->roles()->attach(Role::find(3));
        $u->teacher()->create(['college_id' => 2, 'department_id' => random_int(4, 6)]);
    }
}
