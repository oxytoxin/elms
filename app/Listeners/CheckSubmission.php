<?php

namespace App\Listeners;

use DB;
use App\Events\NewSubmission;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\GeneralNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckSubmission implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewSubmission  $event
     * @return void
     */
    public function handle(NewSubmission $event)
    {
        $studentName = $event->studentName;
        if ($event->task->autocorrect) {
            $items = [];
            $answers = json_decode($event->submission->answers, true);
            $task_content = json_decode($event->task->content, true);
            foreach ($task_content as $key => $content) {
                if (array_key_exists('answer', $content)) {
                    if (strcasecmp(sanitizeString($answers[$key]['answer']), $content['answer'])  == 0) {
                        array_push($items, $key = ['isCorrect' => true, 'score' => $content['points']]);
                    } else array_push($items, $key = ['isCorrect' => false, 'score' => 0]);
                } else if ($content['enumeration']) {
                    $correctItems = 0;
                    $studentEnums = array_map('strtolower', json_decode($answers[$key]['answer']));
                    $correctEnums = array_map('strtolower', $content['enumerationItems']);
                    foreach ($correctEnums as $key => $enumItem) {
                        if (in_array(sanitizeString($studentEnums[$key]), $correctEnums)) $correctItems++;
                    }
                    if (count($correctEnums) == $correctItems)
                        array_push($items, $key = ['isCorrect' => true, 'score' => $content['points'] * $correctItems]);
                    else if ($correctItems) array_push($items, $key = ['isCorrect' => 'partial', 'score' => $content['points'] * $correctItems]);
                    else array_push($items, $key = ['isCorrect' => false, 'score' => 0]);
                } else array_push($items, $key = null);
            }
            $score = collect($items)->map(function ($i) {
                return $i ? $i['score'] : 0;
            })->sum();
            DB::transaction(function () use ($event, $items, $score) {
                $event->submission->update([
                    'score' => $score,
                    'isGraded' => true,
                    'assessment' => json_encode($items),
                ]);
            });
            $event->submission->student->user->notify(new GeneralNotification('A task has been graded.', route('preview-submission', ['submission' => $event->submission->id])));
        }
    }
}
