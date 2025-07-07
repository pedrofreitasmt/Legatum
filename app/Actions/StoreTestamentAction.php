<?php

namespace App\Actions;

use App\Http\Requests\StoreTestamentRequest;
use App\Models\Testament;
use Illuminate\Support\Arr;


class StoreTestamentAction
{
    public function run(StoreTestamentRequest $request): void
    {
        $validatedData = $request->validated();

        $encryptedContent = encrypt($validatedData['content']);

        $validatedData['content'] = $encryptedContent;

        $validatedData['user_id'] = auth()->id();

        $testament = Testament::create(Arr::except($validatedData, ['attachments']));

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');

                $testament->testamentAttachments()->create([
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ]);
            }
        }
    }
}
