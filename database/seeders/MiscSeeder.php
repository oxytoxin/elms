<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Course;
use App\Models\Module;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\CalendarEvent;
use App\Models\Section;
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
        // Enroll student with id 1 and teacher with id 101
        // $s = Student::find(1);
        $t = Teacher::find(101);
        $students = Student::where('department_id', $t->department_id)->get();
        // $courses = Course::where('department_id', $t->department_id)->get();
        $courses = Course::get()->take(100);
        foreach ($courses as  $c) {
            $section1 = Section::create(['code' => strtoupper($faker->bothify('??-#?')), 'teacher_id' => 101, 'course_id' => $c->id, 'room' => strtoupper($faker->bothify('??? Bldg. Rm. ??#')), 'schedule' => $faker->randomElement(['MWF', 'TTH']) . ' 0' . $faker->numberBetween(7, 9) . ' AM- 0' . $faker->numberBetween(1, 5) . ' PM']);
            $section2 = Section::create(['code' => strtoupper($faker->bothify('??-#?')), 'teacher_id' => 101, 'course_id' => $c->id, 'room' => strtoupper($faker->bothify('??? Bldg. Rm. ??#')), 'schedule' => $faker->randomElement(['MWF', 'TTH']) . ' 0' . $faker->numberBetween(7, 9) . ' AM- 0' . $faker->numberBetween(1, 5) . ' PM']);
            $c->teachers()->attach(101);
            foreach ($students as  $s) {
                if ($faker->numberBetween(0, 1))
                    $t->students()->attach($s->id, ['course_id' => $c->id, 'section_id' => $section1->id]);
                else $t->students()->attach($s->id, ['course_id' => $c->id, 'section_id' => $section2->id]);
            }
            for ($i = 0; $i < 4; $i++) {
                $mod = Module::create([
                    'course_id' => $c->id,
                    'section_id' => $section1->id,
                    'name' => $faker->catchPhrase,
                ]);
                $r = rand(1, 7);
                $mod->image()->create([
                    'url' => "/img/bg/bg($r).jpg"
                ]);
            }
            for ($i = 0; $i < 4; $i++) {
                $mod = Module::create([
                    'course_id' => $c->id,
                    'section_id' => $section2->id,
                    'name' => $faker->catchPhrase,
                ]);
                $r = rand(1, 7);
                $mod->image()->create([
                    'url' => "/img/bg/bg($r).jpg"
                ]);
            }
        }
        Task::factory()->count(200)->create(['teacher_id' => 101]);
        $tasks = Task::get();
        foreach ($tasks as $task) {
            $code = Carbon::now()->timestamp;
            CalendarEvent::create([
                'user_id' => $t->user->id,
                'code' => $code,
                'title' => $task->name,
                'description' => $task->name . ' for module: ' . $task->module->name,
                'level' => 'students',
                'start' => $task->deadline,
                'end' => Carbon::parse($task->deadline)->addDay()->format('Y-m-d'),
                'url' => '/task/' . $task->id,
                'allDay' => false
            ]);
        }
        foreach ($students as  $s) {
            foreach ($s->sections as  $sec) {
                foreach ($sec->tasks as  $task) {
                    if (rand(0, 1)) {
                        $graded = rand(0, 1);
                        $s->tasks()->attach(
                            $task->id,
                            [
                                'section_id' => $sec->id,
                                'isGraded' => $graded,
                                'answers' => '[{"answer":"I have no idea."},{"files":[{"name":"signature.png","url":"tasks\/test_attachment.png"}]},{"answer":"I do not know."},{"answer":"The others are mistakes."},{"answer":"True"}]',
                                'score' => $graded ? rand(10, $task->max_score) : 0,
                                'date_submitted' => Carbon::now()->format('Y-m-d h:i:s')
                            ]
                        );
                    }
                }
            }
        }
    }
}
