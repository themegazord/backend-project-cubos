<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DebtorDestroyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }


    public function rules(): array
    {
        return [
            'password' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo é obrigatório',
        ];
    }
}
