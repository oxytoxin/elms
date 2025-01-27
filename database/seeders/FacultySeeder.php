<?php

namespace Database\Seeders;

use App\Models\Dean;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use App\Models\Campus;
use App\Models\Course;
use App\Models\Module;
use App\Models\Student;
use App\Models\StudentTask;
use Illuminate\Support\Str;
use App\Models\CalendarEvent;
use App\Models\Department;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $this->encodeCSV("csvs/access.csv", 1);
        $this->encodeCSV("csvs/isulan.csv", 2);
        $this->encodeCSV("csvs/tacurong.csv", 3);
        $this->encodeCSV("csvs/kalamansig.csv", 4);
        $this->encodeCSV("csvs/bagumbayan.csv", 5);
        $this->encodeCSV("csvs/palimbang.csv", 6);
        $this->encodeCSV("csvs/lutayan.csv", 7);
        $u = User::find(115);
        Dean::create([
            'user_id' => $u->id,
            'college_id' => 7
        ]);
        $u->roles()->attach(Role::find(5));
        if (app()->environment('local')) {
            $this->mockSeed($faker);
        }
    }

    public function encodeCSV($path, $campus_id)
    {
        $teachers = [];
        $handle = fopen(storage_path($path), "r");
        while (($data = fgetcsv($handle)) !== FALSE) {
            array_push($teachers, $data);
        }
        foreach ($teachers as $key => $teacher) {
            $u = User::create([
                'campus_id' => $campus_id,
                'name' => ucwords(trim(strtolower($teacher[0]))),
                'email' => strtolower($teacher[1]),
                'email_verified_at' => now(),
                // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'password' => bcrypt(base64_encode(explode(' ', trim(strtolower($teacher[0])))[0])), // password
                'remember_token' => Str::random(10),
            ]);
            $u->roles()->attach(Role::find(3));
            $u->teacher()->create([
                'college_id' => null,
                'department_id' => null,
            ]);
        }
    }

    public function mockSeed(Faker $faker)
    {
        $u = User::whereEmail('cyrusrael@sksu.edu.ph')->first();
        $u->program_head()->create([
            'college_id' => 7,
        ]);
        $d = Department::find(19);
        $d->program_head()->associate($u->program_head);
        $d->save();
        $u->roles()->attach(Role::find(4));
        $u->teacher->update(['department_id' => 10]);

        Student::factory()->count(99)->create()->each(function ($s) {
            $s->user->roles()->attach(Role::find(2));
        });

        $c = Course::find(144);
        $c->teachers()->attach($u->teacher);
        for ($i = 0; $i < 1; $i++) {
            $sec = $c->sections()->create([
                'code' => 'IS - 4A',
                'teacher_id' => $u->teacher->id,
                'schedule' => 'MWF 08:00am-11:00am',
                'room' => ' Rm. FIELD 7',
            ]);
            $chatroom = $sec->chatroom()->create([
                'name' => $sec->course->name . ' - (' . $sec->code . ')',
                'isGroup' => true,
            ]);
            $sec->grading_system()->create();
            // Enrol student to faculty workload
            $s = Student::find(83);
            $chatroom->members()->attach([$u->id, $s->user_id]);
            $chatroom->messages()->create([
                'sender_id' => null,
                'message' => $u->name . ' has joined the group.'
            ]);
            $chatroom->messages()->create([
                'sender_id' => null,
                'message' => $s->user->name . ' has joined the group.'
            ]);
            $ss = Student::get()->take(30);
            foreach ($ss as $key => $st) {
                if ($key == 0) {
                    $u->teacher->students()->attach($s, [
                        'course_id' => $c->id,
                        'section_id' => $sec->id,
                    ]);
                    continue;
                }
                $u->teacher->students()->attach($st, [
                    'course_id' => $c->id,
                    'section_id' => $sec->id,
                ]);
            }
            // Create module
            $mod = Module::create([
                'section_id' => $sec->id,
                'course_id' => $c->id,
                'name' => $faker->catchPhrase,
            ]);
            $mod->files()->create([
                'google_id' => '16yeYOVDrmjvoYyphDBrNjE6Bwu4gxjSM',
                'name' => 'qMpBEYRJzY4UI8cLC4mCogrwQc0D7gRT33nCt1Jr.txt',
                'url' => 'ZwR7HB9eAvshctBYJM0rqIYFkNsWx5DGxAVbRtoI.txt'
            ]);
            $rand = rand(1, 7);
            $mod->image()->create([
                'url' => "/img/bg/bg($rand).jpg"
            ]);
            // create tasks and create submissions
            $tasks = Task::factory()->count(20)->create([
                'quarter_id' => $faker->numberBetween(1, 2),
                'module_id' => $mod->id,
                'teacher_id' => $u->teacher->id,
                'section_id' => $sec->id,
            ]);
            foreach ($tasks as $task) {
                $code = Carbon::now()->timestamp;
                CalendarEvent::create([
                    'user_id' => $u->id,
                    'code' => $code,
                    'title' => $task->name,
                    'description' => $task->name . ' for module: ' . $task->module->name,
                    'level' => 'tasks',
                    'section_id' => $task->section_id,
                    'task_id' => $task->id,
                    'start' => $task->deadline,
                    'end' => Carbon::parse($task->deadline)->addDay()->format('Y-m-d'),
                    'url' => '/task/' . $task->id,
                    'allDay' => false
                ]);
                foreach ($ss as $key => $st) {
                    if ($key == 0) {
                        if (rand(0, 3)) {
                            StudentTask::create([
                                'student_id' => $s->id,
                                'section_id' => $sec->id,
                                'task_id' => $task->id,
                                'isGraded' => true,
                                'score' => 44,
                                'answers' => '[{"answer":"True","files":[],"item_no":1},{"answer":"Some things are meant to be","files":[],"item_no":2}]',
                                'date_submitted' => Carbon::now(),
                                'assessment' => null
                            ]);
                        } else {
                            if (rand(0, 3)) {
                                StudentTask::create([
                                    'student_id' => $s->id,
                                    'section_id' => $sec->id,
                                    'task_id' => $task->id,
                                    'isGraded' => false,
                                    'score' => 0,
                                    'answers' => '[{"answer":"Answer1"},{"answer":"This is option 1"},{"answer":"False"},{"answer":"Lorem ipsum doler siadat alsdkts."},{"answer":"My answer","files":[{"name":"qMpBEYRJzY4UI8cLC4mCogrwQc0D7gRT33nCt1Jr.txt","url":"tasks\/TpmhxA36FlVpDyEYyC96db6FOgKLB1GS7pMAUwDc.txt"},{"name":"home.html","url":"tasks\/cXIp8OmPDaLGQVvWlKxRLIhHAfOBvXMPuxEJQPnk.html"}]},{"answer":"[\"Item 1\",\"Item2\",\"Item 3\"]"}]',
                                    'date_submitted' => Carbon::now(),
                                    'assessment' => null,
                                ]);
                            }
                        }
                        continue;
                    }
                    if (rand(0, 7)) {
                        StudentTask::create([
                            'student_id' => $st->id,
                            'section_id' => $sec->id,
                            'task_id' => $task->id,
                            'isGraded' => true,
                            'score' => rand(60, $task->max_score),
                            'answers' => '[{"answer":"Answer1"},{"answer":"This is option 1"},{"answer":"False"},{"answer":"Lorem ipsum doler siadat alsdkts."},{"answer":"My answer","files":[{"name":"qMpBEYRJzY4UI8cLC4mCogrwQc0D7gRT33nCt1Jr.txt","url":"tasks\/TpmhxA36FlVpDyEYyC96db6FOgKLB1GS7pMAUwDc.txt"},{"name":"home.html","url":"tasks\/cXIp8OmPDaLGQVvWlKxRLIhHAfOBvXMPuxEJQPnk.html"}]},{"answer":"[\"Item 1\",\"Item2\",\"Item 3\"]"}]',
                            'date_submitted' => Carbon::now(),
                            'assessment' => '[{"isCorrect":false,"score":0},{"isCorrect":true,"score":"5"},{"isCorrect":false,"score":0},{"isCorrect":"partial","score":15},{"isCorrect":"partial","score":"22"},{"isCorrect":"partial","score":2}]'
                        ]);
                    } else {
                        if (rand(0, 1)) {
                            StudentTask::create([
                                'student_id' => $st->id,
                                'section_id' => $sec->id,
                                'task_id' => $task->id,
                                'isGraded' => false,
                                'score' => 0,
                                'answers' => '[{"answer":"Answer1"},{"answer":"This is option 1"},{"answer":"False"},{"answer":"Lorem ipsum doler siadat alsdkts."},{"answer":"My answer","files":[{"name":"qMpBEYRJzY4UI8cLC4mCogrwQc0D7gRT33nCt1Jr.txt","url":"tasks\/TpmhxA36FlVpDyEYyC96db6FOgKLB1GS7pMAUwDc.txt"},{"name":"home.html","url":"tasks\/cXIp8OmPDaLGQVvWlKxRLIhHAfOBvXMPuxEJQPnk.html"}]},{"answer":"[\"Item 1\",\"Item2\",\"Item 3\"]"}]',
                                'date_submitted' => Carbon::now(),
                                'assessment' => null,
                            ]);
                        }
                    }
                }
            }
        }
    }
}