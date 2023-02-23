## Consulta único titulo

Retornará o titulo que for passado como parametro do endpoint

### Autenticação

Essa rota é autenticada

### URL

`GET /api/installments/{id}`

### Parametros do endpoint

| Parametro | Tipo    | Descrição    | Obrigatório? |
|-----------|---------|--------------|--------------|
| id        | inteiro | Id do titulo | Sim          |

### Parametros de resposta

| Parâmetro       | Tipo    | Descrição                                                    |
|-----------------|---------|--------------------------------------------------------------|
| id              | inteiro | Id do titulo                                                 |
| users_id        | inteiro | Id do criador do titulo                                      |
| id_billing      | string  | Uuid da cobrança                                             |
| status          | string  | Define o status do titulos que varia entre `Open`, `Pending` |
| description     | string  | Descrição do titulo                                          |
| debtor_id       | int     | Id do cliente                                                |
| emission_date   | string  | Data de emissão do titulo                                    |
| due_date        | string  | Data do vencimento do titulo                                 |
| overdue_payment | bool    | Define se o titulo está vencido ou não                       |
| amount          | float   | Valor do titulo                                              |

### Exemplo de resposta
```json
{
    "id": 10,
    "users_id": 8,
    "id_billing": "bd29dd7e-4a5a-4d6e-a6ff-43b30e0558d2",
    "status": "Open",
    "description": "Descrição 1 teste 2 3 4 5 6",
    "debtor_id": 8,
    "emission_date": "2023-02-23",
    "due_date": "2023-02-25",
    "overdue_payment": 0,
    "amount": 299.9,
    "created_at": "2023-02-23T20:03:45.000000Z",
    "updated_at": "2023-02-23T20:03:45.000000Z"
}
```

### Possibilidade de erro

| Codígo | Resposta  | Motivo                                 |
|--------|-----------|----------------------------------------|
| 404    | Not Found | Tentou consultar um titulo inexistente |
