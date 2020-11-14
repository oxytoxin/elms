<?php

namespace App\Listeners;

use App\Events\NewSubmission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckSubmission
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
        //
    }
}
