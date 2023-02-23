## Atualizar titulos

Utilizado para atualizar o titulo passado.

### Autenticação

Essa rota é autenticada

### URL

`POST /api/installments/{id}`

### Parametro do endpoint

| Parametro | Tipo    | Descrição    | Obrigatório? |
|-----------|---------|--------------|--------------|
| id        | inteiro | Id do titulo | Sim          |

### Parametros da requisição

| Parametro     | Tipo    | Descrição                                                    | Obrigatório? |
|---------------|---------|--------------------------------------------------------------|--------------|
| users_id      | inteiro | Id do criador do titulo                                      | Sim          |
| debtor_id     | int     | Id do cliente                                                | Sim          |
| emission_date | string  | Data de emissão do titulo                                    | Sim          |
| due_date      | string  | Data do vencimento do titulo                                 | Sim          |
| amount        | float   | Valor do titulo                                              | Sim          |
| status        | string  | Define o status do titulos que varia entre `Open`, `Pending` | Sim          |
| decription    | string  | Descrição do titulo                                          | Sim          |
| _method       | string  | Método utilizado para a rota `PUT` ou `PATCH`                | Sim          |

### Exemplo de requisição

```json
{
    "users_id": 7,
    "id_billing": 12704,
    "emission_date": "2023-01-14",
    "due_date": "2023-02-15",
    "amount": 81.16,
    "paid_amount": 81.16,
    "_method": "PUT|PATCH"
}
```
| Parâmetro       | Tipo    | Descrição                                                    |
|-----------------|---------|--------------------------------------------------------------|
| users_id        | inteiro | Id do criador do titulo                                      |
| status          | string  | Define o status do titulos que varia entre `Open`, `Pending` |
| debtor_id       | int     | Id do cliente                                                |
| emission_date   | string  | Data de emissão do titulo                                    |
| due_date        | string  | Data do vencimento do titulo                                 |
| overdue_payment | bool    | Define se o titulo está vencido ou não                       |
| amount          | float   | Valor do titulo                                              |
| _method         | string  | Método usado na requisição                                   |

### Exemplo de resposta

```json
{
    "users_id": "8",
    "description": "Teste",
    "debtor_id": "8",
    "emission_date": "2023-02-23",
    "due_date": "2023-02-28",
    "amount": "501",
    "status": "Open",
    "_method": "PATCH"
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
