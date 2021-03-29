<?php

namespace App\Http\Controllers;

use Hash;
use Mail;
use App\Models\Dean;
use App\Models\File;
use App\Models\Role;
use App\Models\User;
use App\Models\Campus;
use App\Models\Support;
use App\Models\Teacher;
use App\Mail\PasswordMail;
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
        $u = User::create([
            'campus_id' => 2,
            'name' => 'Charmagne Lavilles',
            'email' => 'charmagnelavilles@sksu.edu.ph',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            // 'password' => bcrypt(base64_encode(explode(' ', trim(strtolower($teacher[0])))[0])), // password
            'remember_token' => Str::random(10),
        ]);
        $u->roles()->attach(Role::find(3));
        $u->teacher()->create([
            'college_id' => null,
            'department_id' => null,
        ]);

        return 'enrolled ' . $u->name;
        // $users = Teacher::get()->map(fn ($t) => $t->user);
        // foreach ($users->chunk(10) as  $userschunk) {
        //     UsersPasswordReset::dispatch($userschunk);
        // }
        // return "mailed to {$users->count()} users...";
        // for ($i = 0; $i < 10; $i++) {
        //     $r = rand(0, 1);
        //     User::find(1)->supports()->create([
        //         'message' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sit, deserunt?.',
        //         'isQuery' => $r ? true : false,
        //     ]);
        // }
        // User::find(1)->readSupports();
        // Mail::to('mjlac.kali@gmail.com')->send(new PasswordMail(base64_encode(explode(' ', trim(strtoupper('oxytoxinsgrace')))[0])));
    }
    public function sendPasswordResets()
    {
        foreach (User::get()->chunk(10) as $users) {
            event(new UsersPasswordReset($users));
        };
        return 'passwords sent';
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
            $sections = auth()->user()->student->sections->pluck('id')->all();
            $events = $events->merge(CalendarEvent::where('level', 'section')->whereIn('section_id', $sections)->get());
            $events = $events->merge(CalendarEvent::where('level', 'tasks')->whereIn('section_id', $sections)->get());
            $events = $events->merge(auth()->user()->student->teachers->map(function ($t) {
                return $t->user->calendar_events->where('level', 'students');
            })->flatten());
            return json_encode($events->toArray());
        }
        return json_encode([]);
    }
}