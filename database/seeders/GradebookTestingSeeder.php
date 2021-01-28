<?php

namespace Database\Seeders;

use App\Models\StudentTask;
use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Database\Seeder;

class GradebookTestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $t = Task::create([
            'module_id' => 1,
            'section_id' => 1,
            'teacher_id' => 4,
            'task_type_id' => 4,
            'name' => 'First Exam',
            'max_score' => 88,
            'essay_rubric' => '{"criteria":[{"name":"Structure (Spelling, Grammar, etc.)","weight":50},{"name":"Content (Relevance to theme, coherence, etc.)","weight":50}],"performance_rating":["Excellent","Good","Satisfactory"]}',
            'matchingtype_options' => '["Option1","Option2","Option3","Option4","Option5"]',
            'content' => '[{"files":[],"question":"What is question 1?","points":"10","options":[],"enumerationItems":[],"torf":false,"essay":false,"enumeration":false,"attachment":false,"answer":"Option1","item_no":1},{"files":[],"question":"Which is question 2?","points":"5","options":["This is option 1","This is option 2","This is option 3"],"enumerationItems":[],"torf":false,"essay":false,"enumeration":false,"attachment":false,"answer":"This is option 1","item_no":2},{"files":[],"question":"This is question 3?","points":"10","options":["True","False"],"enumerationItems":[],"torf":true,"essay":false,"enumeration":false,"attachment":false,"answer":"True","item_no":3},{"files":[],"question":"This is question 4?","points":"30","options":[],"enumerationItems":[],"torf":false,"essay":true,"enumeration":false,"attachment":false,"item_no":4},{"files":[],"question":"This is question 5?","points":"30","options":[],"enumerationItems":[],"torf":false,"essay":false,"enumeration":false,"attachment":true,"item_no":5},{"files":[],"question":"This is question 6?","points":"1","options":[],"enumerationItems":["Item 1","Item 2","Item 3"],"torf":false,"essay":false,"enumeration":true,"attachment":false,"item_no":6}]',
            'deadline' => Carbon::now()->addDays(2),
        ]);
        StudentTask::create([
            'student_id' => 83,
            'section_id' => 1,
            'task_id' => $t->id,
            'isGraded' => true,
            'score' => 44,
            'answers' => '[{"answer":"Answer1"},{"answer":"This is option 1"},{"answer":"False"},{"answer":"Lorem ipsum doler siadat alsdkts."},{"answer":"My answer","files":[{"name":"qMpBEYRJzY4UI8cLC4mCogrwQc0D7gRT33nCt1Jr.txt","url":"tasks\/TpmhxA36FlVpDyEYyC96db6FOgKLB1GS7pMAUwDc.txt"},{"name":"home.html","url":"tasks\/cXIp8OmPDaLGQVvWlKxRLIhHAfOBvXMPuxEJQPnk.html"}]},{"answer":"[\"Item 1\",\"Item2\",\"Item 3\"]"}]',
            'date_submitted' => Carbon::now(),
            'assessment' => '[{"isCorrect":false,"score":0},{"isCorrect":true,"score":"5"},{"isCorrect":false,"score":0},{"isCorrect":"partial","score":15},{"isCorrect":"partial","score":"22"},{"isCorrect":"partial","score":2}]'
        ]);
    }
}
