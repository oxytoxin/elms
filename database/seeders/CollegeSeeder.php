<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Seeder;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $c = College::create([
            'campus_id' => 1,
            'name' => 'College of Teacher Education'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Physical Education',
            'code' => 'BPEd'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor in Elementary Education',
            'code' => 'BEED'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor in Secondary Education',
            'code' => 'BSEd-English'
        ]);
        $c->departments()->create([
            'name' => 'Diploma in Teaching',
            'code' => 'DIT'
        ]);
        $c = College::create([
            'campus_id' => 1,
            'name' => 'College of Agriculture'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Agriculture',
            'code' => 'BA'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Agricultural Technology',
            'code' => 'BAT'
        ]);
        $c = College::create([
            'campus_id' => 1,
            'name' => 'College of Criminal Justice Education'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Criminology',
            'code' => 'BSCriminology'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Industrial Security Management',
            'code' => 'BSISM'
        ]);
        $c = College::create([
            'campus_id' => 1,
            'name' => 'College of Health Sciences'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Nursing',
            'code' => 'BSN'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Midwifery',
            'code' => 'BSM'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Medical Technology',
            'code' => ''
        ]);
        $c->departments()->create([
            'name' => 'Diploma in Midwifery',
            'code' => ''
        ]);
        $c = College::create([
            'campus_id' => 1,
            'name' => 'College of Law'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Laws',
            'code' => ''
        ]);
        $c = College::create([
            'campus_id' => 2,
            'name' => 'College of Engineering'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Civil Engineering',
            'code' => 'BSCE'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Computer Engineering',
            'code' => 'BSCpE'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Electronics Engineering',
            'code' => 'BSECE'
        ]);
        $c = College::create([
            'campus_id' => 2,
            'name' => 'College of Computer Studies'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Computer Science',
            'code' => 'BSCS'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Information Technology',
            'code' => 'BSIT'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Information Systems',
            'code' => 'BSIS'
        ]);
        $c = College::create([
            'campus_id' => 2,
            'name' => 'College of Industrial Technology'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor in Technical-Vocational Teacher Education (BTVTEd)',
            'code' => ''
        ]);
        $c = College::create([
            'campus_id' => 3,
            'name' => 'College of Arts and Sciences'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Arts in Economics',
            'code' => 'AB Econ'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Arts in Political Science',
            'code' => 'AB PolSci'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Biology',
            'code' => 'BS Bio'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Environmental Science',
            'code' => 'BS Envi.Sci.'
        ]);
        $c = College::create([
            'campus_id' => 3,
            'name' => 'College of Business Administration and Hospitality Management'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Entrepreneurship',
            'code' => 'BS Entre'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Accountancy',
            'code' => 'BSA'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Management Accounting',
            'code' => 'BSMA'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Hospitality Management',
            'code' => 'BSHM'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Accounting Information System',
            'code' => 'BSAIS'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Tourism Management',
            'code' => 'BSTM'
        ]);
        $c = College::create([
            'campus_id' => 4,
            'name' => 'College of Education'
        ]);
        $c->departments()->create([
            'name' => 'Diploma in Teaching',
            'code' => 'DIT'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Secondary Education',
            'code' => ''
        ]);

        $c->departments()->create([
            'name' => 'Bachelor in Elementary Education ',
            'code' => 'BEED'
        ]);
        $c = College::create([
            'campus_id' => 4,
            'name' => 'College of Fisheries'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor in Marine Biology',
            'code' => ''
        ]);
        $c = College::create([
            'campus_id' => 4,
            'name' => 'College of Criminal Justice Education'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Criminology',
            'code' => 'BSCriminology'
        ]);
        $c = College::create([
            'campus_id' => 4,
            'name' => 'College of Computer Studies'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Information Technology',
            'code' => 'BSIT'
        ]);
        $c = College::create([
            'campus_id' => 5,
            'name' => 'College of Agribusiness'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Agribusiness',
            'code' => ''
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Technology and Livelihood Education major in Agri-fisheries',
            'code' => ''
        ]);
        $c = College::create([
            'campus_id' => 6,
            'name' => 'College of Agriculture'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Agribusiness ',
            'code' => 'BS Agribus'
        ]);
        $c = College::create([
            'campus_id' => 6,
            'name' => 'College of Education'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor in Elementary Education',
            'code' => 'BEED'
        ]);
        $c = College::create([
            'campus_id' => 7,
            'name' => 'College of Agriculture'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor in Agricultural Technology',
            'code' => 'BAT'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor of Science in Agriculture',
            'code' => 'BSA'
        ]);
        $c = College::create([
            'campus_id' => 7,
            'name' => 'College of Education'
        ]);
        $c->departments()->create([
            'name' => 'Bachelor in Elementary Education',
            'code' => 'BEED'
        ]);
    }
}