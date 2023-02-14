## Login

Logar o usuário no sistema

### Autenticação

Essa rota não é autenticada

### URL
`POST /api/auth/login`

### Parametros de requisição
| Parametro | Tipo   | Descrição           | Obrigatório? |
|-----------|--------|---------------------|--------------|
| email     | string | O e-mail do usuário | Sim          |
| password  | string | A senha do usuário  | Sim          |

### Exemplo de requisição

```json
{
    "email": "email@email.com",
    "password": "password"
}
```

### Parametros de resposta

| Parâmetro | Tipo    | Descrição                                  |
|-----------|---------|--------------------------------------------|
| token     | string  | Token de autenticação gerado pelo sistema. |
| user      | objeto  | Dados do usuário autenticado.              |
| id        | inteiro | ID do usuário.                             |
| name      | string  | Nome completo do usuário.                  |
| email     | string  | Endereço de e-mail do usuário.             |
| aka       | string  | Apelido do usuário.                        |

### Exemplo da resposta

```json
{
    "token": "2|Iv0rt1zQseX6izrIP800jlLYOAwL1U0rp4naIIf9",
    "user": {
        "id": 7,
        "name": "Fulano de Tal",
        "email": "fulano@email.com",
        "aka": "FT"
    }
}
```

### Possibilidades de erros

| Codígo | Resposta                        | Motivo                                                     |
|--------|---------------------------------|------------------------------------------------------------|
| 401    | O email e a senha são inválidos | Ao enviar e-mail e senhas que não combinam ou não existem  |
| 422    | O e-mail é inválido             | Ao enviar algo que não seja um e-mail válido               |
| 422    | O email é obrigatório           | Ao enviar o request sem o campo de e-mail ou foi em branco |
| 422    | A senha é obrigatória           | Ao enviar o request sem a senha ou foi em branco           |
