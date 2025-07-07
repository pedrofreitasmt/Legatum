<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestamentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'content' => ['required', 'string', 'max:10000'],
            'recipient_email' => ['required', 'email'],
            'attachments' => ['nullable','array'],
            'attachments.*' => ['required','file', 'mimes:pdf,png,jpg', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título do assunto é obrigatório.',
            'title.max' => 'O título do assunto deve ter no máximo 100 caracteres.',
            'content.required' => 'O conteúdo do assunto é obrigatório.',
            'content.max' => 'O conteúdo do assunto deve ter no máximo 10000 caracteres.',
            'recipient_email.required' => 'O email do destinatário é obrigatório.',
            'recipient_email.email' => 'O email do destinatário deve ser um email válido.',
            'attachments.*.required' => 'É necessário enviar pelo menos um arquivo de anexo.',
            'attachments.*.file' => 'Houve um erro ao carregar o arquivo. Verifique se o arquivo não está corrompido.',
            'attachments.*.mimes' => 'O arquivo de anexo deve ser do tipo: pdf, png ou jpg.',
            'attachments.*.max' => 'Cada anexo não pode exceder 5MB.',
        ];
    }
}
