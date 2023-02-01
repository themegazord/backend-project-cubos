<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required'
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

            'email.email' => 'O email é inválido',
        ];
    }
}
