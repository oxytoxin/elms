<?php

namespace App\Providers;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $recipients;
    public $uid;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($recipients, $uid)
    {
        $this->recipients = $recipients;
        $this->uid = $uid;
    }
}