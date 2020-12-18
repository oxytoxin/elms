<?php

namespace App\Events;

use App\Models\Student;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewSubmission
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $submission;
    public $task;
    public $studentName;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Student $student, $task_id)
    {
        $this->studentName = $student->user->name;
        $this->task = $student->tasks()->where('task_id', $task_id)->first();
        $this->submission = $this->task->pivot;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
