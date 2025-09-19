<?php

namespace App\Http\Controllers;

use App\Models\Testament;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $user = auth()->user();

        $userCount = User::count();

        $testamentCount = Testament::count();

        return Inertia::render('Dashboard', compact('user', 'userCount', 'testamentCount'));
    }
}
