<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Installment extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'id_billing',
        'status',
        'debtor',
        'emission_date',
        'due_date',
        'overdue_payment',
        'amount',
        'paid_amount'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function rules() {
        Validator::extend('due_date', function ($attribute, $value, $parameters, $validator) {
            $emission_date = $validator->getData()[$parameters[0]];
            return $emission_date <= $value; //verifica se a data de vencimento é menor ou igual a data de emissão
        });
        $rules = [
            'users_id' => 'exists:users,id|numeric',
            'id_billing' => 'numeric|unique:installments',
            'debtor'=> 'string|max_digits:155',
            'emission_date' => 'date|date_format:"Y-m-d"',
            'due_date' => 'date|date_format:"Y-m-d"|due_date:emission_date',
            'amount' => 'numeric|min:1',
            'paid_amount' => 'numeric|min:0|lte:amount'
        ];

        if ($this->exists) {
            $rules['id_billing'] .= ',id_billing,' . $this->id;
        }

        return $rules;
    }

    public function feedback() {
        return [
            'numeric' => 'Esse campo é apenas númerico',
            'date' => 'Esse campo é apenas para data',

            'users_id.exists' => 'Insira apenas um usuário válido',

            'id_billing.unique' => 'Já existe essa cobrança',

            'debtor.string' => 'O nome do devedor deve ser um texto',
            'debtor.max_digits' => 'O nome do devedor deve conter no máximo 155 caracteres',

            'emission_date.date_format' => 'Formato inválido, formato correto -> YYYY-mm-dd',

            'due_date.date_format' => 'Formato inválido, formato correto -> YYYY-mm-dd',
            'due_date.due_date' => 'A data de vencimento não pode ser menor que a data de emissão',

            'amount.min' => 'O valor do titulo deve ser maior que 0',

            'paid_amount.min' => 'O valor do pagamento deve ser maior que 0',
            'paid_amount.lte' => 'O valor do pagamento deve ser menor que o valor do titulo'
        ];
    }
}
