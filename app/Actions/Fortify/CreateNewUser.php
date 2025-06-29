<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:11'],
            'cpf' => ['required', 'cpf', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            [
                'name.required' => 'O campo Nome Completo é obrigatório.',
                'name.max' => 'O campo Nome Completo deve ter no máximo 100 caracteres.',
                'email.required' => 'O campo Email é obrigatório.',
                'email.email' => 'O campo Email deve ser um endereço de email válido',
                'email.max' => 'O campo Email deve ter no máximo 255 caracteres.',
                'email.unique' => 'O Email informado já está em uso.',
                'phone.max' => 'O campo Telefone deve ter no máximo 11 caracteres.',
                'cpf.required' => 'O campo CPF é obrigatório.',
                'cpf.unique' => 'O CPF informado já está em uso.',
            ]
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'cpf' => $input['cpf'],
            'phone' => $input['phone'] ?? null,
            'password' => Hash::make($input['password']),
        ]);
    }
}
