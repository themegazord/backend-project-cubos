## Cadastro de Titulos

Utilizada para cadastrar titulos no sistema

### Autenticação

Essa rota é autenticada

### URL

`POST /api/installments`

### Parametros de requisição

| Parametro     | Tipo    | Descrição                                         | Obrigatório? |
|---------------|---------|---------------------------------------------------|--------------|
| users_id      | inteiro | Id do criador do titulo                           | Sim          |
| debtor_id     | inteiro | Id do cliente                                     | Sim          |
| emission_date | string  | Data de emissão do titulo                         | Sim          |
| due_date      | string  | Data do vencimento do titulo                      | Sim          |
| amount        | float   | Valor do titulo                                   | Sim          |
| status        | string  | Status do Titulo que pode ser `Open` ou `Pending` | Sim          |
| description   | string  | Descrição do titulo                               | Sim          |

### Exemplo de requisição

```json
{
    "users_id": 5,
    "debtor_id": 5,
    "emission_date": "2022-12-29",
    "due_date": "2023-02-03",
    "amount": 94.96,
    "status": "Open",
    "description": "teste"
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

| Codígo | Resposta                                                      | Motivo                                                           |
|--------|---------------------------------------------------------------|------------------------------------------------------------------|
| 422    | Esse campo é obrigatório                                      | Quando não passar o devido campo                                 |
| 422    | Esse campo é apenas númerico                                  | Ao tentar encaminhar algo que não seja númerico no campo         |
| 422    | Esse campo é apenas data                                      | Ao tentar encaminhar algo que não seja data no campo             |
| 422    | Insira apenas um usuário válido                               | Ao tentar passar um código de usuário inexistente no `users_id`  |
| 422    | Formato inválido, formato correto -> YYYY-mm-dd               | Ao inserir um padrão de data diferente de `YYYY-mm-dd`           |
| 422    | A data de vencimento não pode ser menor que a data de emissão | Ao passar a data de vencimento menor que a data de emissão       |
| 422    | O campo de client aceita apenas inteiros                      | Ao passar um dado que seja diferente de inteiro no devido campo  |
| 422    | Insira um cliente que exista.                                 | Ao passar um cliente que não existe                              |
| 422    | O valor do titulo deve ser maior que 0                        | Ao passar um valor menor ou igual a 0 como valor do titulo       |
| 422    | Foi inserido caracteres inválidos                             | Ao passar um valor que seja diferente que string para esse campo |
| 422    | O campo de descrição aceita no máximo 255 caracteres          | Ao passar uma quantidade maior que 255 caracteres                |
