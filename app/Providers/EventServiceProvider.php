<?php

namespace App\Providers;

use App\Events\NewSubmission;
use App\Events\NewTask;
use App\Listeners\CheckSubmission;
use App\Listeners\NotifyTaskStudents;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewSubmission::class => [
            CheckSubmission::class,
        ],
        NewTask::class => [
            NotifyTaskStudents::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
