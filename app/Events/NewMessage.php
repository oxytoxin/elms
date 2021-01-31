<?php

namespace App\Events;

use App\Models\User;
use Auth;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $recipient;
    /**
     * The name of the queue connection to use when broadcasting the event.
     *
     * @var string
     */
    public $connection = 'database';

    /**
     * The name of the queue on which to place the broadcasting job.
     *
     * @var string
     */
    public $queue = 'messages';
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("messages.".$this->recipient->id);
    }

        /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'new.message';
    }
}
