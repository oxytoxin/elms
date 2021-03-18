<?php

namespace Database\Seeders;

use App\Models\Campus;
use Illuminate\Database\Seeder;

class CampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Campus::create([
            'name' => 'Access Campus',
        ]);
        Campus::create([
            'name' => 'Isulan Campus',
        ]);
        Campus::create([
            'name' => 'Tacurong Campus',
        ]);
        Campus::create([
            'name' => 'Kalamansig Campus',
        ]);
        Campus::create([
            'name' => 'Bagumbayan Campus',
        ]);
        Campus::create([
            'name' => 'Palimbang Campus',
        ]);
        Campus::create([
            'name' => 'Lutayan Campus',
        ]);
    }
}