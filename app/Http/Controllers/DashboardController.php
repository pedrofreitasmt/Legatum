<?php

namespace App\Http\Controllers;

use App\Models\Testament;
use App\Models\User;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboardService)
    {
    }

    public function __invoke(Request $request): Response
    {
        return Inertia::render('Dashboard', $this->dashboardService->prepareDashboardData());
    }
}
