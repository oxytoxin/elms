<?php

namespace App\Listeners;

use App\Models\User;
use App\Mail\PasswordMail;
use Illuminate\Support\Str;
use App\Events\UsersPasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPasswordResets implements ShouldQueue
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
     * @param  UsersPasswordReset  $event
     * @return void
     */
    public function handle(UsersPasswordReset $event)
    {
        foreach ($event->users as $user) {
            // Password::sendResetLink(['email' => $user->email]);
            Mail::to($user)->send(new PasswordMail(base64_encode(strtoupper(explode(' ', trim($user->name))[0]))));
            sleep(2);
        }
    }
}