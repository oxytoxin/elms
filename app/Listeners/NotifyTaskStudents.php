<?php

namespace App\Listeners;

use App\Events\NewTask;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notification;
use App\Notifications\NewTask as NewTaskNotification;

class NotifyTaskStudents implements ShouldQueue
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
     * @param  NewTask  $event
     * @return void
     */
    public function handle(NewTask $event)
    {
        $students = $event->teacher->courseStudents($event->task->course->id)->get()->map(function ($s) {
            return $s->user;
        });
        Notification::send($students, new NewTaskNotification($event->teacher->user, route('student.task', ['task' => $event->task->id])));
    }
}
