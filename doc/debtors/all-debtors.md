## Listagem dos clientes

Essa rota irá lhe trazer, sem filtro de usuário, todos os clientes do sistema. A mesma deve ser usada apenas em modo de desenvolvimento para analises internas

### Autenticação

Essa rota é autenticada

### URL

`GET /api/debtors`

### Parametro de requisição

Não tem parametro

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
| user         | objeto  | Objeto com os dados do usuário criador |
| user.id      | integer | ID do usuário criador                  |
| user.name    | string  | Nome do usuário criador                |

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
    "updated_at": "2023-02-13T17:53:51.000000Z",
    "user": {
      "id": 7,
      "name": "Marina Emmerich"
    }
  }
]
```
