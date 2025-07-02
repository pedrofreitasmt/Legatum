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
            'send_at' => ['required', 'date', 'after:today'],
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
            'send_at.required' => 'A data de envio é obrigatória.',
            'send_at.date' => 'A data de envio deve ser uma data válida.',
            'send_at.after' => 'A data de envio deve ser posterior ao dia de hoje.'
        ];
    }
}
