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

| Parâmetro       | Tipo    | Descrição                                                                   |
|-----------------|---------|-----------------------------------------------------------------------------|
| id              | inteiro | Id do titulo                                                                |
| users_id        | inteiro | Id do criador do titulo                                                     |
| id_billing      | inteiro | Id da cobrança                                                              |
| status          | string  | Define o status do titulos que varia entre `Open`, `Partially Paid`, `Paid` |
| debtor          | string  | Nome do devedor                                                             |
| emission_date   | string  | Data de emissão do titulo                                                   |
| due_date        | string  | Data do vencimento do titulo                                                |
| overdue_payment | bool    | Define se o titulo está vencido ou não                                      |
| amount          | float   | Valor do titulo                                                             |
| paid_amount     | float   | Valor pago do titulo                                                        |

### Exemplo de resposta
```json
{
    "id": 5,
    "users_id": 7,
    "id_billing": 12704,
    "status": "P",
    "debtor": "Samantha Kshlerin",
    "emission_date": "2023-01-14",
    "due_date": "2023-02-15",
    "overdue_payment": 1,
    "amount": 81.16,
    "paid_amount": 99.11
}
```

### Possibilidade de erro

| Codígo | Resposta  | Motivo                                 |
|--------|-----------|----------------------------------------|
| 404    | Not Found | Tentou consultar um titulo inexistente |
