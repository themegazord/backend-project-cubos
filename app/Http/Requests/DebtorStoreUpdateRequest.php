<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DebtorStoreUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'user_id' => 'exists:users,id|required',
            'name' => 'max:155|required',
            'email' => 'email|max:155|required',
            'cpf' => 'max:11|required',
            'phone' => 'max:20|required',
            'address' => 'max:155',
            'complement' => 'max:50',
            'cep' => 'max:8',
            'neighborhood' => 'max:50',
            'city' => 'max:155',
            'state' => 'max:2'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Esse campo é obrigatório',

            'user_id.exists' => 'Esse usuário não existe',

            'name.max' => 'O campo de nome deve ter no máximo 155 caracteres',

            'email.email' => 'O email é inválido',
            'email.max' => 'O campo do email deve ter no máximo 155 caracteres',

            'cpf.max' => 'O campo de CPF deve ter no máximo 11 caracteres',

            'phone.max' => 'O campo de telefone deve ter no máximo 20 caracteres',

            'address.max' => 'O campo de endereço deve ter no máximo 155 caracteres',

            'complement.max' => 'O campo de complemento deve ter no máximo 50 caracteres',

            'cep.max' => 'O campo de CEP deve ter no máximo 8 caracteres',

            'neighborhood.max' => 'O campo de bairro deve ter no máximo 50 caracteres',

            'city.max' => 'O campo de cidade deve ter no máximo 155 caracteres',

            'state.max' => 'O campo de UF deve ter no máximo 2 caracteres',
        ];
    }
}
