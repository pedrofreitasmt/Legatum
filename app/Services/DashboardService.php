<?php

namespace App\Services;

use App\Models\Testament;
use App\Models\User;

class DashboardService
{
    public function prepareDashboardData(): array
    {
        return [
            'user' => auth()->user(),
            'userCount' => User::count(),
            'testamentCount' => Testament::count(),
        ];
    }
}
