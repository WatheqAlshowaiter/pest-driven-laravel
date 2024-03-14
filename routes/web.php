<?php

use App\Http\Controllers\PageCourseDetailsController;
use App\Http\Controllers\PageHomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', PageHomeController::class)->name('pages.home');
Route::get('courses/{course:slug}', PageCourseDetailsController::class)->name('pages.course-details');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
