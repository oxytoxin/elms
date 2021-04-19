<?php

namespace Database\Seeders;

use App\Models\Course;
use DB;
use Illuminate\Database\Seeder;

class CourseNameConflictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $c = Course::where('code', 'GE714')->first();
            $names = $c->name_conflict;
            if (!$names) $names = collect();
            if (!$names->contains('SOSYEDAD AT LITERATURA/PANITIKANG PANLIPUNAN'))
                $names->put(4, 'SOSYEDAD AT LITERATURA/PANITIKANG PANLIPUNAN');
            if (!$names->contains('SOSLIT'))
                $names->put(2, 'SOSLIT');
            $c->update([
                'name_conflict' => $names,
            ]);
            $c = Course::where('code', 'GE703')->first();
            $names = $c->name_conflict;
            if (!$names) $names = collect();
            if (!$names->contains('ETHICS'))
                $names->put(2, 'ETHICS');
            $c->update([
                'name_conflict' => $names,
            ]);
        });
    }
}