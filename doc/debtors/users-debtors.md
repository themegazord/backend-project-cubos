## Listagem dos clientes

Essa rota irá trazer os clientes de um usuário especifico

### Autenticação

Essa rota é autenticada

### URL

`GET /api/debtors/user/{id}`

### Parametro do endpoint

| Parametro | Tipo    | Descrição     | Obrigatório? |
|-----------|---------|---------------|--------------|
| id        | inteiro | Id do usuário | Sim          |

### Parametro de requisição

Não tem parametro

### Parametro de resposta

| Parâmetro    | Tipo    | Descrição                                                          |
|--------------|---------|--------------------------------------------------------------------|
| status       | string  | Status do cliente `Payer`, `Defaulter` ou para usuários novos `New`|
| id           | integer | ID do cliente                                                      |
| user_id      | integer | ID do usuário que cadastrou o cliente                              |
| name         | string  | Nome do cliente                                                    |
| email        | string  | Email do cliente                                                   |
| cpf          | string  | CPF do cliente                                                     |
| phone        | string  | Telefone do cliente                                                |
| address      | string  | Rua do cliente                                                     |
| complement   | string  | Complemento do endereço do cliente                                 |
| cep          | string  | CEP do cliente                                                     |
| neighborhood | string  | Bairro do cliente                                                  |
| city         | string  | Cidade do cliente                                                  |
| state        | string  | Estado do cliente                                                  |

## Exemplo de resposta

```json
[
    {
        "status": "Defaulter",
        "id": 8,
        "user_id": 8,
        "name": "Gustavo de Camargo Campos",
        "email": "contato.wanjalagus@outlook.com.br",
        "cpf": "05081039160",
        "phone": "67981590619",
        "address": null,
        "complement": null,
        "cep": null,
        "neighborhood": null,
        "city": null,
        "state": null,
        "created_at": "2023-02-23T19:29:07.000000Z",
        "updated_at": "2023-02-23T19:29:07.000000Z"
    }
]
```

