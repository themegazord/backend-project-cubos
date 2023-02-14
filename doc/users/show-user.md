## Consulta dados do usuário

Retorna os dados do usuário que foi passado como parametro

### Autenticação

Essa rota é autenticada

### URL

`POST /api/users/{id}`

### Parametro do endpoint

| Parametro | Tipo    | Descrição     | Obrigatório? |
|-----------|---------|---------------|--------------|
| id        | inteiro | Id do usuário | Sim          |

### Parametro de resposta

| Parametro | Tipo             | Descrição           |
|-----------|------------------|---------------------|
| id        | int              | Id do usuário       |
| name      | string           | Nome do usuário     |
| email     | string           | Email do usuário    |
| cpf       | string `or` null | CPF do usuário      |
| phone     | string `or` null | Telefone do usuário |


### Exemplo de resposta

    {
        "id": 1,
        "name": "Gustavo de Camargo Campos",
        "email": "contato.wanjalagus@outlook.com.br",
        "cpf": "01234567891",
        "phone": "67912345678"
    }


### Possibilidade de erros

| Código | Resposta           | Motivo                                      |
|--------|--------------------|---------------------------------------------|
| 404    | Usuário não existe | Ao passar o id de um usuário que não existe |
