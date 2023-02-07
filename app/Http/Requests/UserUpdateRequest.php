<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array|JsonResponse
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'cpf' => 'max:14',
            'password' => 'required',
            'phone' => 'max:20'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatorio',
            'email.required' => 'O campo email é obrigatório',
            'password.required' => 'O campo de senha é obrigatório',

            'name.max' => 'O nome deve conter no máximo 255 caracteres',
            'email.max' => 'O email deve conter no máximo 255 caracteres',
            'cpf:max' => 'O CPF deve conter no máximo 11 digitos',
            'phone:max' => 'O telefone deve conter no máximo 20 digitos',

            'email.email' => 'O email é inválido',

        ];
    }
}
