## Cadastro de Titulos

Utilizada para cadastrar titulos no sistema

### Autenticação

Essa rota é autenticada

### URL

`POST /api/installments`

### Parametros de requisição

| Parametro     | Tipo    | Descrição                    | Obrigatório? |
|---------------|---------|------------------------------|--------------|
| users_id      | inteiro | Id do criador do titulo      | Sim          |
| id_billing    | inteiro | Id da cobrança               | Sim          |
| debtor        | string  | Nome do devedor              | Sim          |
| emission_date | string  | Data de emissão do titulo    | Sim          |
| due_date      | string  | Data do vencimento do titulo | Sim          |
| amount        | float   | Valor do titulo              | Sim          |
| paid_amount   | float   | Valor pago do titulo         | Sim          |

### Exemplo de requisição

```json
{
    "users_id": 5,
    "id_billing": 14496,
    "debtor": "Samantha Kshlerin",
    "emission_date": "2022-12-29",
    "due_date": "2023-02-03",
    "amount": 94.96,
    "paid_amount": 73.9
}
```

### Parametros de resposta

| Parâmetro | Tipo   | Descrição                    |
|-----------|--------|------------------------------|
| msg       | string | Installment has been created |

### Exemplo de resposta

```json
{
    "msg": "Installment has been created"
}
```

### Possibilidade de erro

| Codígo | Resposta                                                           | Motivo                                                                  |
|--------|--------------------------------------------------------------------|-------------------------------------------------------------------------|
| 422    | Esse campo é apenas númerico                                       | Ao tentar encaminhar algo que não seja númerico no campo                |
| 422    | Esse campo é apenas data                                           | Ao tentar encaminhar algo que não seja data no campo                    |
| 422    | Insira apenas um usuário válido                                    | Ao tentar passar um código de usuário inexistente no `users_id`         |
| 422    | O nome do devedor deve ser um texto                                | Ao tentar passar algo diferente de `string` no campo `debtor`           |
| 422    | O nome do devedor deve conter no máximo 155 caracteres             | Ao tentar encaminhar um nome do `debtor` maior que 155 caracteres       |
| 422    | Formato inválido, formato correto -> YYYY-mm-dd                    | Ao inserir um padrão de data diferente de `YYYY-mm-dd`                  |
| 422    | A data de vencimento não pode ser menor que a data de emissão      | Ao passar a data de vencimento menor que a data de emissão              |
| 422    | O valor do titulo deve ser maior que 0                             | Ao passar um valor menor ou igual a 0 como valor do titulo              |
| 422    | O valor do pagamento deve ser maior que 0                          | Ao passar um valor menor ou igual a 0 como valor do pagamento           |
| 422    | O valor do pagamento deve ser menor ou igual que o valor do titulo | Ao passar um valor pago maior que o valor do titulo                     |
| 400    | A cobrança já existe                                               | Ao tentar criar ou mudar um titulo inserindo uma cobrança que já existe |
