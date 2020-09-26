<?php

use App\Http\Controllers\StudentPagesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

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

Route::get('/', function () {
    return view('pages.teacher.courses.course');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('test', function () {
    return view('test');
});
Route::post('test', [TestController::class, 'test']);

// Student Routes
Route::prefix('student')->group(function () {
    Route::get('/home', [StudentPagesController::class, 'home'])->name('student.home');
    Route::get('/modules', [StudentPagesController::class, 'modules'])->name('student.modules');
    Route::get('/module/{id}', [StudentPagesController::class, 'module'])->name('student.module');
});
