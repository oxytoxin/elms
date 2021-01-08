<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Models\CalendarEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function test()
    {
        dump(auth()->user()->messages->filter(fn($m)=>$m->complement_owner->id == 4));
    }

    public function fileDownload(File $file)
    {
        // if ($file->google_id)
        //     return Storage::download($file->google_id);
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
        if(!auth()->user()->isTeacher() && auth()->user()->isProgramHead()) {
            return json_encode($events->toArray());
        }
        if(auth()->user()->isTeacher()) {
            $events = $events->merge(CalendarEvent::where('level', 'faculty')->get());
            return json_encode($events->toArray());
        }
        if(auth()->user()->isStudent()) {
            $events = $events->merge(auth()->user()->student->teachers->map(function ($t) {
                return $t->user->calendar_events->where('level', 'students');
            })->flatten());
            return json_encode($events->toArray());
        }
        return json_encode([]);
    }
}
