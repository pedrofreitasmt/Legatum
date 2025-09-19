<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService extends Service
{
    public function __construct(private User $user) {
    }

    public function displayUsers(Request $request): LengthAwarePaginator
    {
        $query = $this->user->query();

        $this->filter($query, $request);

        return $query->latest()->paginate(5);
    }
}
