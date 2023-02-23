<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class InstallmentStoreUpdateRequest extends FormRequest
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

    public function rules(): array
    {
        Validator::extend('due_date', function ($attribute, $value, $parameters, $validator) {
            $emission_date = $validator->getData()[$parameters[0]];
            return $emission_date <= $value; //verifica se a data de vencimento é menor ou igual a data de emissão
        });

        return [
            'users_id' => 'exists:users,id|numeric|required',
            'debtor_id'=> 'integer|exists:debtors,id|required',
            'emission_date' => 'date|date_format:"Y-m-d"|required',
            'due_date' => 'date|date_format:"Y-m-d"|due_date:emission_date|required',
            'amount' => 'numeric|min:1|required',
            'description' => 'string|required|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'numeric' => 'Esse campo é apenas númerico',
            'date' => 'Esse campo é apenas para data',
            'required' => 'Esse campo é obrigatório',

            'users_id.exists' => 'Insira apenas um usuário válido',

            'debtor_id.integer' => 'O campo de client aceita apenas inteiros',
            'debtor_id.exists' => 'Insira um cliente que exista.',

            'emission_date.date_format' => 'Formato inválido, formato correto -> YYYY-mm-dd',

            'due_date.date_format' => 'Formato inválido, formato correto -> YYYY-mm-dd',
            'due_date.due_date' => 'A data de vencimento não pode ser menor que a data de emissão',

            'amount.min' => 'O valor do titulo deve ser maior que 0',

            'description.string' => 'Foi inserido caracteres inválidos',
            'description.max' => 'O campo de descrição aceita no máximo 255 caracteres',
        ];
    }
}
