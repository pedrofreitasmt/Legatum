<?php

namespace App\Http\Controllers;

use App\Actions\StoreTestamentAction;
use App\Actions\UpdateTestamentAction;
use App\Http\Requests\StoreTestamentRequest;
use App\Http\Requests\UpdateTestamentRequest;
use App\Models\Testament;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TestamentController extends Controller
{
    public function index(Request $request): Response
    {
        $testaments = Testament::query()->filterTestaments($request)
            ->with('testamentAttachments')
            ->orderByDesc('id')
            ->paginate(5)
            ->withQueryString();

        return Inertia::render('Testaments/Index', compact('testaments'));
    }

    public function create(): Response
    {
        return Inertia::render('Testaments/Create');
    }

    public function store(StoreTestamentRequest $request, StoreTestamentAction $storeTestamentAction): RedirectResponse
    {
        $storeTestamentAction->run($request);

        return redirect()->route('testaments.index')->withSuccess('Testamento criado com sucesso!');
    }

    public function show(Testament $testament): Response
    {
        return Inertia::render('Testaments/Show', compact('testament'));
    }

    public function edit(Testament $testament): Response
    {
        if ($testament->user_id !== auth()->id()) {
            abort(403, 'Acesso negado');
        }

        $testament->load('testamentAttachments');

        return Inertia::render('Testaments/Edit', compact('testament'));
    }

    public function update(UpdateTestamentRequest $request, UpdateTestamentAction $updateTestamentAction, Testament $testament): RedirectResponse
    {
        $updateTestamentAction->run($request, $testament);

        return redirect()->route('testaments.index', ['page' => $request->query('page')])->withSuccess('Testamento atualizado com sucesso!');
    }

    public function destroy(Testament $testament): RedirectResponse
    {
        $testament->delete();

        return redirect()->route('testaments.index')->withSuccess('Testamento excluído com sucesso!');
    }
}
