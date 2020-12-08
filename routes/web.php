<?php

use App\Models\Task;
use App\Models\User;
use App\Events\NewTask;
use App\Http\Controllers\DeanPagesController;
use App\Models\Teacher;
use App\Http\Livewire\TaskMaker;
use App\Http\Livewire\TaskTaker;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\TeacherTasklist;
use App\Notifications\SomeNotification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\TestController;
use App\Http\Livewire\PreviewSubmission;
use App\Http\Livewire\Teacher\AddModule;
use App\Http\Livewire\Teacher\Gradebook;
use App\Http\Livewire\Teacher\GradeTask;
use App\Http\Livewire\Teacher\TaskPreview;
use App\Notifications\AnotherNotification;
use App\Http\Controllers\StudentPagesController;
use App\Http\Controllers\TeacherPagesController;
use App\Http\Controllers\ProgramHeadPagesController;
use App\Http\Livewire\Dean\ProgramHeadManager;
use App\Http\Livewire\Head\AddSection;
use App\Http\Livewire\Head\FacultyManager;
use App\Http\Livewire\Head\WorkloadUploader;
use App\Http\Livewire\Student\EnrolViaCode;
use App\Http\Livewire\TeacherCoursesPage;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

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
    // \Illuminate\Support\Facades\Artisan::call("migrate:fresh --seed");
    // \Illuminate\Support\Facades\Artisan::call("view:cache");
    // event(new NewTask(Task::find(1), Teacher::find(101)));\
    $r = json_encode(['id' => 1, 'course' => 2]);
    $test = Crypt::encryptString($r);
    dump($test);
    try {
        dump(json_decode(Crypt::decryptString($test), true));
    } catch (DecryptException $e) {
        abort(404);
    }
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

Route::get('/task/{id}', [MiscController::class, 'taskRedirect'])->middleware(['auth']);
Route::post('test', [TestController::class, 'test']);

Route::view('/under_development', 'underdev')->name('soon_to_be_developed');

Route::get('/preview-submission/{submission}', PreviewSubmission::class)->middleware(['auth', 'submissionPreview'])->name('preview-submission');

// Student Routes
Route::prefix('student')->middleware(['auth', 'isStudent'])->group(function () {
    Route::get('/home', [StudentPagesController::class, 'home'])->name('student.home');
    Route::get('/modules', [StudentPagesController::class, 'modules'])->name('student.modules');
    Route::get('/course/{course}/modules', [StudentPagesController::class, 'course_modules'])->middleware('studentIsEnrolled')->name('student.course_modules');
    Route::get('/course/{course}', [StudentPagesController::class, 'course'])->name('student.course');
    Route::get('/module/{module}', [StudentPagesController::class, 'module'])->name('student.module');
    Route::get('/courses/create', [StudentPagesController::class, 'create_course'])->name('student.create_course');
    Route::get('/preview/{file}', [StudentPagesController::class, 'preview'])->name('student.preview');
    Route::get('/calendar', [StudentPagesController::class, 'calendar'])->name('student.calendar');
    Route::get('/task/{task}', TaskTaker::class)->name('student.task');
    Route::get('/tasks/{task_type}', [StudentPagesController::class, 'tasks'])->name('student.tasks');
    Route::get('/enrol/viacode', EnrolViaCode::class)->name('student.enrol_via_code');
});


// Teacher Routes
Route::prefix('teacher')->middleware(['auth', 'isTeacher'])->group(function () {
    Route::get('/home', [TeacherPagesController::class, 'home'])->name('teacher.home');
    Route::get('/modules', [TeacherPagesController::class, 'modules'])->name('teacher.modules');
    Route::get('/section/{section}/modules', [TeacherPagesController::class, 'course_modules'])->middleware('teacherIsEnrolled')->name('teacher.course_modules');
    Route::get('/course/{section}', TeacherCoursesPage::class)->name('teacher.course');
    Route::get('/module/{module}', [TeacherPagesController::class, 'module'])->name('teacher.module');
    Route::get('/addmodule/{section}', AddModule::class)->name('teacher.addmodule');
    // Route::get('/courses', [TeacherPagesController::class, 'courses'])->name('teacher.courses');
    // Route::get('/courses/create', [TeacherPagesController::class, 'create_course'])->name('teacher.create_course');
    Route::get('/preview/{file}', [TeacherPagesController::class, 'preview'])->name('teacher.preview');
    Route::get('/calendar', [TeacherPagesController::class, 'calendar'])->name('teacher.calendar');
    Route::get('/taskmaker', TaskMaker::class)->name('teacher.taskmaker');
    Route::get('/tasks/{task_type}', [TeacherPagesController::class, 'tasks'])->name('teacher.tasks');
    Route::get('/task/{task}', TeacherTasklist::class)->name('teacher.task');
    Route::get('/preview_task/{task}', TaskPreview::class)->name('teacher.task_preview');
    Route::get('/grade/{task}', GradeTask::class)->name('teacher.grade_task');
    Route::get('/gradebook', Gradebook::class)->name('teacher.gradebook');
});

// Program Head Routes
Route::prefix('programhead')->middleware(['auth', 'isProgramHead'])->group(function () {
    Route::get('/home', [ProgramHeadPagesController::class, 'home'])->name('head.home');
    Route::get('/modules', [ProgramHeadPagesController::class, 'modules'])->name('head.modules');
    Route::get('/course/{section}/modules', [ProgramHeadPagesController::class, 'course_modules'])->name('head.course_modules');
    Route::get('/course/{course}', [ProgramHeadPagesController::class, 'course'])->name('head.course');
    Route::get('/module/{module}', [ProgramHeadPagesController::class, 'module'])->name('head.module');
    Route::get('/courses', [ProgramHeadPagesController::class, 'courses'])->name('head.courses');
    Route::get('/courses/create', [ProgramHeadPagesController::class, 'create_course'])->name('head.create_course');
    Route::get('/preview/{file}', [ProgramHeadPagesController::class, 'preview'])->name('head.preview');
    Route::get('/calendar', [ProgramHeadPagesController::class, 'calendar'])->name('head.calendar');
    Route::get('/add-section', AddSection::class)->name('head.add_section');
    Route::get('/faculty-manager', FacultyManager::class)->name('head.faculty_manager');
    Route::get('/workload-uploader/{teacher}', WorkloadUploader::class)->name('head.workload_uploader');
});

// Dean Routes
Route::prefix('dean')->middleware(['auth', 'isDean'])->group(function () {
    Route::get('/home', [DeanPagesController::class, 'home'])->name('dean.home');
    Route::get('/manage-program-heads', ProgramHeadManager::class)->name('dean.programhead_manager');
});
