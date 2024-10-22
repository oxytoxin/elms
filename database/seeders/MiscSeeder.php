<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use App\Models\Course;
use App\Models\Module;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ProgramHead;
use App\Models\StudentTask;
use App\Models\CalendarEvent;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class MiscSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // Add the programhead to corresponding department
        $d = User::find(1)->dean;
        $u = User::find(4);
        // Add faculty members to program head
        $p = ProgramHead::create([
            'user_id' => $u->id,
            'department_id' => 4,
            'college_id' => $d->college_id,
        ]);
        $u->roles()->attach(Role::find(4));
        $u->teacher->update([
            'department_id' => $p->department_id,
        ]);
        // Edit faculty member workload
        $c = Course::find(144);
        $c->teachers()->attach($u->teacher);
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
                'level' => 'students',
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
                            'answers' => '[{"answer":"Answer1"},{"answer":"This is option 1"},{"answer":"False"},{"answer":"Lorem ipsum doler siadat alsdkts."},{"answer":"My answer","files":[{"name":"qMpBEYRJzY4UI8cLC4mCogrwQc0D7gRT33nCt1Jr.txt","url":"tasks\/TpmhxA36FlVpDyEYyC96db6FOgKLB1GS7pMAUwDc.txt"},{"name":"home.html","url":"tasks\/cXIp8OmPDaLGQVvWlKxRLIhHAfOBvXMPuxEJQPnk.html"}]},{"answer":"[\"Item 1\",\"Item2\",\"Item 3\"]"}]',
                            'date_submitted' => Carbon::now(),
                            'assessment' => '[{"isCorrect":false,"score":0},{"isCorrect":true,"score":"5"},{"isCorrect":false,"score":0},{"isCorrect":"partial","score":15},{"isCorrect":"partial","score":"22"},{"isCorrect":"partial","score":2}]'
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