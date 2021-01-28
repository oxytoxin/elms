<?php

namespace App\Events;

use App\Models\Task;
use App\Models\Teacher;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewTask
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;
    public $teacher;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Task $task, Teacher $teacher)
    {
        $this->task = $task;
        $this->teacher = $teacher;
    }

    // /**
    //  * Get the channels the event should broadcast on.
    //  *
    //  * @return \Illuminate\Broadcasting\Channel|array
    //  */
    // public function broadcastOn()
    // {
    //     return new PrivateChannel('channel-name');
    // }
}
