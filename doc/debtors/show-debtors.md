## Visualização do cadastro do cliente

Rota utilizada para verificar o cadastro de um único cliente

### Autenticação

Essa rota é autenticada

### URL

`GET /api/debtors/{id}`

### Parametros do endpoint

| Parametro | Tipo    | Descrição     | Obrigatório? |
|-----------|---------|---------------|--------------|
| id        | inteiro | Id do cliente | Sim          |

### Parametros de requisição

Rota não tem requisição

### Parametro de resposta

| Parâmetro    | Tipo    | Descrição                              |
|--------------|---------|----------------------------------------|
| id           | integer | ID do cliente                          |
| user_id      | integer | ID do usuário que cadastrou o cliente  |
| name         | string  | Nome do cliente                        |
| email        | string  | Email do cliente                       |
| cpf          | string  | CPF do cliente                         |
| phone        | string  | Telefone do cliente                    |
| address      | string  | Rua do cliente                         |
| complement   | string  | Complemento do endereço do cliente     |
| cep          | string  | CEP do cliente                         |
| neighborhood | string  | Bairro do cliente                      |
| city         | string  | Cidade do cliente                      |
| state        | string  | Estado do cliente                      |

## Exemplo de resposta

```json
[
  {
    "id": 1,
    "user_id": 7,
    "name": "Estel Leffler",
    "email": "ada.gislason@example.org",
    "cpf": "19150658866",
    "phone": "13156869794",
    "address": "57679 Jerry Turnpike",
    "complement": "eius eos ut",
    "cep": "56082340",
    "neighborhood": "nesciunt rem inventore",
    "city": "Hollybury",
    "state": "vw",
    "created_at": "2023-02-13T17:53:51.000000Z",
    "updated_at": "2023-02-13T17:53:51.000000Z"
  }
]
```

### Possibilidade de erro

| Codígo | Resposta  | Motivo               |
|--------|-----------|----------------------|
| 404    | Not Found | O cliente não existe |
