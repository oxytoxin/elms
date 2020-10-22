<?php

use App\Http\Livewire\TaskMaker;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\StudentPagesController;
use App\Http\Controllers\TeacherPagesController;
use App\Http\Controllers\ProgramHeadPagesController;
use App\Http\Livewire\TaskTaker;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/download/{file}', [MiscController::class, 'fileDownload'])->name('file.download');
Route::get('/event/{event}', [MiscController::class, 'event_details'])->name('event.details');

Route::get('/command', function () {
    \Illuminate\Support\Facades\Artisan::call("migrate:fresh --seed");
    \Illuminate\Support\Facades\Artisan::call("view:cache");
});

Route::get('/', function () {
    return redirect('/redirectMe');
})->middleware('auth');

Route::get('/redirectMe', function () {
    return "redirecting...";
})->middleware('redirectMe');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('test', function () {
    return view('layouts.master');
});
Route::post('test', [TestController::class, 'test']);

// Student Routes
Route::prefix('student')->middleware(['auth', 'isStudent'])->group(function () {
    Route::get('/home', [StudentPagesController::class, 'home'])->name('student.home');
    Route::get('/modules', [StudentPagesController::class, 'modules'])->name('student.modules');
    Route::get('/course/{course}/modules', [StudentPagesController::class, 'course_modules'])->name('student.course_modules');
    Route::get('/course/{course}', [StudentPagesController::class, 'course'])->name('student.course');
    Route::get('/module/{module}', [StudentPagesController::class, 'module'])->name('student.module');
    Route::get('/courses', [StudentPagesController::class, 'courses'])->name('student.courses');
    Route::get('/courses/create', [StudentPagesController::class, 'create_course'])->name('student.create_course');
    Route::get('/preview/{file}', [StudentPagesController::class, 'preview'])->name('student.preview');
    Route::get('/calendar', [StudentPagesController::class, 'calendar'])->name('student.calendar');
    Route::get('/task/{task}', TaskTaker::class)->name('student.task');
    Route::get('/tasks', [StudentPagesController::class, 'tasks'])->name('student.tasks');
});


// Teacher Routes
Route::prefix('teacher')->middleware(['auth', 'isTeacher'])->group(function () {
    Route::get('/home', [TeacherPagesController::class, 'home'])->name('teacher.home');
    Route::get('/modules', [TeacherPagesController::class, 'modules'])->name('teacher.modules');
    Route::get('/course/{course}/modules', [TeacherPagesController::class, 'course_modules'])->name('teacher.course_modules');
    Route::get('/course/{course}', [TeacherPagesController::class, 'course'])->name('teacher.course');
    Route::get('/module/{module}', [TeacherPagesController::class, 'module'])->name('teacher.module');
    Route::get('/courses', [TeacherPagesController::class, 'courses'])->name('teacher.courses');
    Route::get('/courses/create', [TeacherPagesController::class, 'create_course'])->name('teacher.create_course');
    Route::get('/preview/{file}', [TeacherPagesController::class, 'preview'])->name('teacher.preview');
    Route::get('/calendar', [TeacherPagesController::class, 'calendar'])->name('teacher.calendar');
    Route::get('/taskmaker', TaskMaker::class)->name('teacher.taskmaker');
});

// Program Head Routes
Route::prefix('programhead')->middleware(['auth', 'isProgramHead'])->group(function () {
    Route::get('/home', [ProgramHeadPagesController::class, 'home'])->name('head.home');
    Route::get('/modules', [ProgramHeadPagesController::class, 'modules'])->name('head.modules');
    Route::get('/course/{course}/modules', [ProgramHeadPagesController::class, 'course_modules'])->name('head.course_modules');
    Route::get('/course/{course}', [ProgramHeadPagesController::class, 'course'])->name('head.course');
    Route::get('/module/{module}', [ProgramHeadPagesController::class, 'module'])->name('head.module');
    Route::get('/courses', [ProgramHeadPagesController::class, 'courses'])->name('head.courses');
    Route::get('/courses/create', [ProgramHeadPagesController::class, 'create_course'])->name('head.create_course');
    Route::get('/preview/{file}', [ProgramHeadPagesController::class, 'preview'])->name('head.preview');
    Route::get('/calendar', [ProgramHeadPagesController::class, 'calendar'])->name('head.calendar');
});
