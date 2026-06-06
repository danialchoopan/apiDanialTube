<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\CourseController;
use App\Http\Controllers\Web\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('web.home');
Route::get('/courses/{id}', [CourseController::class, 'show'])->name('web.courses.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('web.profile');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [\App\Http\Controllers\Voyager\DashboardController::class, 'index'])->name('voyager.dashboard');
    Voyager::routes();
});
