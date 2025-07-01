<?php

namespace App\Actions;

use App\Http\Requests\StoreTestamentRequest;
use App\Models\Testament;

class StoreTestamentAction
{
    public function run(StoreTestamentRequest $request): void
    {
        $validatedData = $request->validated();

        $encryptedContent = encrypt($validatedData['content']);

        $validatedData['content'] = $encryptedContent;

        $validatedData['user_id'] = auth()->id();

        Testament::create($validatedData);
    }
}
