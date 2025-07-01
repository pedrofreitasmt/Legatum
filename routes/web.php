<?php

use App\Http\Controllers\TestamentController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        return Inertia::render('Dashboard', compact('user'));
    })->name('dashboard');

    Route::resource('testaments',TestamentController::class);
});
