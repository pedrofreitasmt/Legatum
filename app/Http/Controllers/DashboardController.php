<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboardService)
    {
    }

    public function __invoke(): Response
    {
        return Inertia::render('Dashboard', $this->dashboardService->prepareDashboardData());
    }
}
