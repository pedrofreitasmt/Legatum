<?php

namespace App\Services;

use App\Models\Testament;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TestamentService extends Service
{
    public function __construct(private Testament $testament)
    {
    }

    public function displayTestaments(Request $request): LengthAwarePaginator
    {
        $query = $this->testament->newQuery()->with('testamentAttachments');

        $this->filter($query, $request);

        return $query->orderByDesc('id')->paginate(5)->withQueryString();
    }
}
