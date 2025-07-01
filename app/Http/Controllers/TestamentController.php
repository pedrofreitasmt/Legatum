<?php

namespace App\Http\Controllers;

use App\Actions\StoreTestamentAction;
use App\Http\Requests\StoreTestamentRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TestamentController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user()->getTestamentsByDate();

        return Inertia::render('Testament/Index', compact('user'));
    }

    public function create(): Response
    {
        return Inertia::render('Testament/Create');
    }

    public function store(StoreTestamentRequest $request, StoreTestamentAction $storeTestamentAction): RedirectResponse
    {
        $storeTestamentAction->run($request);

        return redirect()->route('testaments.index');
    }

    public function show(string $id)
    {
        //
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
