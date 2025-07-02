<?php

namespace App\Http\Controllers;

use App\Actions\StoreTestamentAction;
use App\Http\Requests\StoreTestamentRequest;
use App\Http\Requests\UpdateTestamentRequest;
use App\Models\Testament;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TestamentController extends Controller
{
    public function index(): Response
    {
        $testaments = Testament::paginateTestaments(5);

        return Inertia::render('Testaments/Index', compact('testaments'));
    }

    public function create(): Response
    {
        return Inertia::render('Testaments/Create');
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

    public function edit(Testament $testament): Response
    {
        if ($testament->user_id !== auth()->id()) {
            abort(403, 'Acesso negado');
        }

        return Inertia::render('Testaments/Edit', compact('testament'));
    }

    public function update(UpdateTestamentRequest $request, Testament $testament): RedirectResponse
    {
        $testament->update($request->validated());

        return redirect()->route('testaments.index', ['page' => $request->query('page')]);
    }

    public function destroy(string $id)
    {
        //
    }
}
