<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestamentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function (): void {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('testaments', TestamentController::class);

    Route::resource('users', UserController::class)->only(['index', 'show']);
});
