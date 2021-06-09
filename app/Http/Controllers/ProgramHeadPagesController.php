<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Course;
use App\Models\Module;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\CalendarEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProgramHeadPagesController extends Controller
{
    public function home()
    {
        session(['whereami' => 'programhead']);
        $sections = auth()->user()->program_head->departments->flatMap(function ($department) {
            return $department->teachers;
        })->flatMap(function ($teacher) {
            return $teacher->sections;
        });
        return view('pages.head.index', compact('sections'));
    }
    public function modules()
    {
        $modules = auth()->user()->program_head->departments->flatMap(function ($department) {
            return $department->teachers;
        })->flatMap(function ($teacher) {
            return $teacher->sections;
        })->flatMap(function ($section) {
            return $section->modules;
        });
        $modules = $modules->count() ? Collection::make($modules)->toQuery()->paginate(20) : collect();

        return view('pages.head.modules.index', compact('modules'));
    }
    public function course_modules(Section $section)
    {
        $sections = auth()->user()->program_head->departments->flatMap(function ($department) {
            return $department->teachers;
        })->flatMap(function ($teacher) {
            return $teacher->sections;
        });
        $isAllowed = (bool) $sections->where('id', $section->id)->first();
        if (!$isAllowed) abort(403);
        $modules = $section->modules;
        return view('pages.head.modules.course_modules', compact('modules', 'section'));
    }
    public function module(Module $module)
    {
        $sections = auth()->user()->program_head->departments->flatMap(function ($department) {
            return $department->teachers;
        })->flatMap(function ($teacher) {
            return $teacher->sections;
        });
        $isAllowed = (bool) $sections->where('course_id', $module->course_id)->first();
        if (!$isAllowed) abort(403);
        $resources = $module->resources()->get();
        return view('pages.head.modules.module', compact('module', 'resources'));
    }
    public function courses()
    {
        $courses = auth()->user()->program_head->departments->flatMap(function ($department) {
            return $department->courses;
        });
        return view('pages.head.courses.index', compact('courses'));
    }
    public function course(Course $course)
    {
        $courses = auth()->user()->program_head->departments->flatMap(function ($department) {
            return $department->courses;
        });
        $isAllowed = (bool) $courses->where('id', $course->id)->first();
        if (!$isAllowed) abort(403);
        return view('pages.head.courses.course', compact('course'));
    }
    public function create_course()
    {
        return view('pages.head.courses.create');
    }
    public function preview(File $file)
    {
        $sections = auth()->user()->program_head->departments->flatMap(function ($department) {
            return $department->teachers;
        })->flatMap(function ($teacher) {
            return $teacher->sections;
        });
        $isAllowed = (bool)$sections->where('id', $file->fileable->section_id)->first();
        if (!$isAllowed) abort(403);
        return view('pages.head.preview', compact('file'));
    }
    public function calendar()
    {
        $events = auth()->user()->calendar_events;
        $events = $events->merge(CalendarEvent::where('level', 'all')->get());
        return view('pages.head.calendar', compact('events'));
    }
}
