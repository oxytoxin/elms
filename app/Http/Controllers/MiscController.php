<?php

namespace App\Http\Controllers;

use Hash;
use Mail;
use Exception;
use App\Models\Dean;
use App\Models\File;
use App\Models\Role;
use App\Models\User;
use App\Models\Campus;
use App\Models\Course;
use App\Models\Support;
use App\Models\Teacher;
use App\Mail\PasswordMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CalendarEvent;
use App\Events\UsersPasswordReset;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\Misc\SendSurvey;
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
        // User::where('name', 'not like', '%,%')->get()->map(function ($u) {
        //     $names = explode(' ', $u->name);
        //     $name = array_pop($names) . ', ' . implode(' ', $names);
        //     $u->update([
        //         'name' => $name
        //     ]);
        // });
        // return phpinfo();
        // User::query()->update([
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        // ]);
        // $user = Auth::login(User::find(26));
        // return redirect('/');
        // $users = Teacher::get()->map(function ($teacher) {
        //     return $teacher->user;
        // });
        // foreach ($users as  $user) {
        //     Mail::to($user)->send(new SendSurvey);
        // }
        return 'sent';
        // Auth::logout();
        // dd(Course::find(313)->name);
    }

    public function phpinfo()
    {
        return phpinfo();
    }

    public function debugSentry()
    {
        throw new Exception('My first Sentry error!');
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
        try {
            $download = Storage::disk('google')->download($file->google_id, $file->name);
            return $download;
        } catch (\Throwable $th) {
            abort(404);
        }
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
            return $events->toArray();
        }
        if (auth()->user()->isTeacher()) {
            $events = $events->merge(CalendarEvent::where('level', 'faculty')->get());
            return $events->toArray();
        }
        if (auth()->user()->isStudent()) {
            $sections = auth()->user()->student->sections->pluck('id')->all();
            $events = $events->merge(CalendarEvent::where('level', 'section')->whereIn('section_id', $sections)->get());
            $events = $events->merge(CalendarEvent::where('level', 'tasks')->whereIn('section_id', $sections)->get());
            $events = $events->merge(auth()->user()->student->teachers->map(function ($t) {
                return $t->user->calendar_events->where('level', 'students');
            })->flatten());
            return $events->toArray();
        }
        return [];
    }
}
