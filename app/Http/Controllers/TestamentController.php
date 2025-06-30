<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTestamentRequest;
use App\Models\Testament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class TestamentController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user();

        return Inertia::render('Testament/Index', compact('user'));
    }

    public function create(): Response
    {
        return Inertia::render('Testament/Create');
    }

    public function store(StoreTestamentRequest $request)
    {
        $validatedData = $request->validated();

        $encryptedContent = encrypt($validatedData['content']);

        $validatedData['content'] = $encryptedContent;

        $validatedData['user_id'] = auth()->id();

        Testament::create($validatedData);

        return redirect()->route('dashboard');
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
