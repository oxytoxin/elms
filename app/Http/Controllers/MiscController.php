<?php

namespace App\Http\Controllers;

use Hash;
use App\Models\File;
use App\Models\Role;
use App\Models\User;
use App\Models\Campus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CalendarEvent;
use App\Events\UsersPasswordReset;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;

class MiscController extends Controller
{

    public function homeRedirect()
    {
        return redirect('/redirectMe');
    }

    public function redirect()
    {
        return "redirecting...";
    }

    public function test(Request $request)
    {
        // if ($request['email']) {
        //     $email = $request['email'];
        // } else $email = 'mjlac.kali@gmail.com';
        // Password::sendResetLink(['email' => $email]);
        // return "email sent to $email";
        $students = [];
        $handle = fopen(storage_path("app/emails6.csv"), "r");
        while (($data = fgetcsv($handle)) !== FALSE) {
            array_push($students, $data);
        }
        foreach ($students as $key => $student) {
            $u = User::create([
                'campus_id' => Campus::get()->random()->id,
                'name' => ucwords($student[0]),
                'email' => strtolower($student[1]),
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);
            $u->roles()->attach(Role::find(2));
            $u->student()->create([
                'college_id' => 2,
                'department_id' => 5,
            ]);
        }
    }
    public function sendPasswordResets()
    {
        foreach (User::get()->random(30)->chunk(10) as $users) {
            event(new UsersPasswordReset($users));
        };
        return 'password reset';
    }

    public function fileDownload(File $file)
    {
        return Storage::disk('google')->download($file->google_id, $file->url);
    }
    public function event_details($event, Request $request)
    {
        $event = CalendarEvent::where('code', $event)->firstOrFail();
        return view('pages.event', compact('event'));
    }

    public function taskRedirect($id)
    {
        if (auth()->user()->student) return redirect("/student/task/$id");
        else if (auth()->user()->teacher) return redirect("/teacher/task/$id");
    }

    public function fetchEvents()
    {
        $events = auth()->user()->calendar_events;
        $events = $events->merge(CalendarEvent::where('level', 'all')->get());
        if (!auth()->user()->isTeacher() && auth()->user()->isProgramHead()) {
            return json_encode($events->toArray());
        }
        if (auth()->user()->isTeacher()) {
            $events = $events->merge(CalendarEvent::where('level', 'faculty')->get());
            return json_encode($events->toArray());
        }
        if (auth()->user()->isStudent()) {
            $events = $events->merge(auth()->user()->student->teachers->map(function ($t) {
                return $t->user->calendar_events->where('level', 'students');
            })->flatten());
            return json_encode($events->toArray());
        }
        return json_encode([]);
    }
}