## Atualização de clientes

Rota utilizada para atualizar o cadastro dos clientes

### Autenticação

Essa rota é autenticada

### URL

`POST /api/debtors/{id}`

### Parametro do endpoint

| Parametro | Tipo    | Descrição     | Obrigatório? |
|-----------|---------|---------------|--------------|
| id        | inteiro | Id do cliente | Sim          |

### Parametros de requisição

| Parametro | Tipo    | Descrição                      | Obrigatório? |
|-----------|---------|--------------------------------|--------------|
| user_id   | integer | ID do usuário criador          | Sim          |
| name      | string  | Nome do cliente                | Sim          |
| email     | string  | Email do cliente               | Sim          |
| cpf       | string  | CPF do cliente                 | Sim          |
| phone     | string  | Telefone do cliente            | Sim          |
| _method   | string  | O metodo que vai ser utilizado | Sim          |
| city      | string  | Cidade do cliente              | Não          |
| state     | string  | Estado do cliente              | Não          |

### Exemplo de requisição

```json
{
    "user_id": 8,
    "name": "Fulano de Tal",
    "email": "fulano@email.com",
    "cpf": "12345678900",
    "phone": "+5567999999999",
    "city": "Cidade",
    "state": "Estado",
    "_method": "PATCH"
}
```

### Possibilidade de erro

| Codígo | Resposta                                                | Motivo                                                                              |
|--------|---------------------------------------------------------|-------------------------------------------------------------------------------------|
| 422    | Esse campo é obrigatório                                | Ao tentar encaminhar o payload sem algum campo obrigatório                          |
| 422    | Esse usuário não existe                                 | Ao tentar passar um id de usuário que não exista                                    |
| 422    | O campo de nome deve ter no máximo 155 caracteres       | Ao passar o nome do cliente com mais de 155 caracteres                              |
| 422    | O email é inválido                                      | Ao passar um email inválido                                                         |
| 422    | O campo do email deve ter no máximo 155 caracteres      | Ao passar o email do cliente com mais de 155 caracteres                             |
| 422    | O campo de CPF deve ter no máximo 11 caracteres         | Ao passar o CPF com mais de 11 caracteres                                           |
| 422    | O campo de telefone deve ter no máximo 20 caracteres    | Ao passar o telefone com mais de 20 caracteres                                      |
| 422    | O campo de endereço deve ter no máximo 155 caracteres   | Ao passar o endereço com mais de 155 caracteres                                     |
| 422    | O campo de complemento deve ter no máximo 50 caracteres | Ao passar o complemento com mais de 50 caracteres                                   |
| 422    | O campo de CEP deve ter no máximo 8 caracteres          | Ao passar o CEP com mais de 8 caracteres                                            |
| 422    | O campo de bairro deve ter no máximo 50 caracteres      | Ao passar o bairro com mais de 50 caracteres                                        |
| 422    | O campo de cidade deve ter no máximo 155 caracteres     | Ao passar a cidade com mais de 155 caracteres                                       |
| 422    | O campo de UF deve ter no máximo 2 caracteres           | Ao passar o estado(UF) com mais de 2 caracteres                                     |
| 422    | O CPF inserido não é matematicamente válido             | Ao passar um CPF que é matematicamente inválido                                     |
| 404    | O cliente não existe                                    | Ao tentar atualizar um cliente que não existe                                       |
| 401    | O email já está sendo usado por outro cliente           | Ao tentar cadastrar um cliente com um email já utilizado por outro cliente          |
| 401    | O CPF já está cadastrado em outro usuário               | Ao tentar cadastrar um cliente com um CPF que já está sendo usado por outro cliente |
