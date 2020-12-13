<?php

namespace App\Jobs;

use App\Models\Task;
use App\Events\NewTask;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\CalendarEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class TaskOpening implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->task->update([
            'open' => true,
        ]);
        $code = Carbon::now()->timestamp;
        CalendarEvent::create([
            'user_id' => $this->task->teacher->user->id,
            'code' => $code,
            'title' => $this->task->name,
            'description' => $this->task->name . ' for module: ' . $this->task->module->name,
            'level' => 'students',
            'start' => $this->task->deadline,
            'end' => $this->task->deadline->addDay()->format('Y-m-d'),
            'url' => '/task/' . $this->task->id,
            'allDay' => false
        ]);
        event(new NewTask($this->task, $this->task->teacher));
    }
}
