<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use Illuminate\Support\Facades\Storage;

class MiscController extends Controller
{
    public function fileDownload(File $file)
    {
        // if ($file->google_id)
        //     return Storage::download($file->google_id);
        return Storage::disk('google')->download($file->google_id, $file->url);
    }
    public function event_details($event)
    {
        $event = CalendarEvent::where('code', $event)->firstOrFail();
        return view('pages.event', compact('event'));
    }

    public function taskRedirect($id)
    {
        if (auth()->user()->student) return redirect("/student/task/$id");
        else if (auth()->user()->teacher) return redirect("/teacher/task/$id");
    }
}
