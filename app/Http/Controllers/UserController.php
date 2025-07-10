<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(): Response
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Acesso negado');
        }

        return Inertia::render('Users/Index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user): Response
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Acesso negado');
        }

        return Inertia::render('Users/Show', compact('user'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
