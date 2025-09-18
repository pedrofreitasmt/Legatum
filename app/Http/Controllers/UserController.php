<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(): Response
    {
        $this->authorize('usuario listar');

        $users = User::paginate(5);

        return Inertia::render('Users/Index', compact('users'));
    }

    public function show(User $user): Response
    {
        $this->authorize('usuario detalhar');

        $user->loadCount('testaments')->load('testaments');

        return Inertia::render('Users/Show', compact('user'));
    }
}
