<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function index(Request $request): Response
    {
        $this->authorize('usuario listar');

        $users = $this->userService->displayUsers($request);

        return Inertia::render('Users/Index', compact('users'));
    }

    public function show(User $user): Response
    {
        $this->authorize('usuario detalhar');

        $user->loadCount('testaments')->load('testaments');

        return Inertia::render('Users/Show', compact('user'));
    }
}
