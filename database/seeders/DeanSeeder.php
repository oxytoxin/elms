<?php

namespace Database\Seeders;

use App\Models\Dean;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DeanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = User::where('email', 'nancyespacio@sksu.edu.ph')->first();
        Dean::create([
            'user_id' => $u->id,
            'college_id' => 1
        ]);
        $u->roles()->attach(Role::find(5));
        $u = User::where('email', 'carmelacamilaurbano@sksu.edu.ph')->first();
        Dean::create([
            'user_id' => $u->id,
            'college_id' => 4
        ]);
        $u->roles()->attach(Role::find(5));
        $u = User::where('email', 'edwincortejo@sksu.edu.ph')->first();
        Dean::create([
            'user_id' => $u->id,
            'college_id' => 3
        ]);
        $u->roles()->attach(Role::find(5));
        $u = User::where('email', 'junitomarcelino@sksu.edu.ph')->first();
        Dean::create([
            'user_id' => $u->id,
            'college_id' => 2
        ]);
        $u->roles()->attach(Role::find(5));
        $u = User::where('email', 'ceciliagener@sksu.edu.ph')->first();
        Dean::create([
            'user_id' => $u->id,
            'college_id' => 7
        ]);
        $u->roles()->attach(Role::find(5));
        $u = User::where('email', 'meilaflorpaclibar@sksu.edu.ph')->first();
        Dean::create([
            'user_id' => $u->id,
            'college_id' => 6
        ]);
        $u->roles()->attach(Role::find(5));
        $u = User::where('email', 'arnelceleste@sksu.edu.ph')->first();
        Dean::create([
            'user_id' => $u->id,
            'college_id' => 8
        ]);
        $u->roles()->attach(Role::find(5));
        $u = User::where('email', 'jeanelleargonza@sksu.edu.ph')->first();
        Dean::create([
            'user_id' => $u->id,
            'college_id' => 9
        ]);
        $u->roles()->attach(Role::find(5));
        $u = User::where('email', 'jeannieromano@sksu.edu.ph')->first();
        Dean::create([
            'user_id' => $u->id,
            'college_id' => 10
        ]);
        $u->roles()->attach(Role::find(5));
        $u = User::where('email', 'reynandemafeliz@sksu.edu.ph')->first();
        Dean::create([
            'user_id' => $u->id,
            'college_id' => 14,
            'is_oic' => true
        ]);
        $u->roles()->attach(Role::find(5));
        $u = User::where('email', 'sarahjanegrande@sksu.edu.ph')->first();
        Dean::create([
            'user_id' => $u->id,
            'college_id' => 16,
            'is_oic' => true
        ]);
        $u->roles()->attach(Role::find(5));
        $u = User::where('email', 'aurelioampo@sksu.edu.ph')->first();
        Dean::create([
            'user_id' => $u->id,
            'college_id' => 18,
            'is_oic' => true
        ]);
        $u->roles()->attach(Role::find(5));
    }
}