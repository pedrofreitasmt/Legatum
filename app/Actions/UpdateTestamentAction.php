<?php

namespace App\Actions;

use App\Http\Requests\UpdateTestamentRequest;
use App\Models\Testament;
use App\Models\TestamentAttachment;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class UpdateTestamentAction
{
    public function run(UpdateTestamentRequest $request, Testament $testament): void
    {
        $validatedData = $request->validated();

        if (!empty($validatedData['attachments_to_delete'])) {
            $this->deleteMarkedAttachments($validatedData['attachments_to_delete']);
        }

        if ($request->hasFile('attachments')) {
            $this->storeNewAttachments($testament, $request->file('attachments'));
        }

        $testament->update(Arr::except($validatedData, ['attachments', 'attachments_to_delete']));
    }

    /**
     * Exclui anexos específicos do armazenamento e do banco de dados.
     */
    private function deleteMarkedAttachments(array $attachmentIds): void
    {
        // Garante que estamos excluindo apenas anexos do testamento em questão
        $attachments = TestamentAttachment::whereIn('id', $attachmentIds)->get();

        foreach ($attachments as $attachment) {
            Storage::disk('public')->delete($attachment->path);
            $attachment->delete();
        }
    }

    /**
     * Salva os novos arquivos de anexo.
     *
     * @param Testament $testament
     * @param UploadedFile[] $files
     */
    private function storeNewAttachments(Testament $testament, array $files): void
    {
        foreach ($files as $file) {
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
