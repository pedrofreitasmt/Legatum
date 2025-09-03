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

        encrypt($validatedData['content']);

        $testament = auth()->user()->testaments()->create(Arr::except($validatedData, ['attachments']));

        if ($request->hasFile('attachments')) {
            $this->storeAttachments($testament, $request);
        }
    }

    private function storeAttachments(Testament $testament, StoreTestamentRequest $request): void
    {
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
