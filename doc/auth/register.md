## Registro

Registrar o usuário no sistema.

### Autenticação

Essa rota não é autenticada

### URL

`POST /api/auth/register`

### Parametro de requisição

| Parametro | Tipo   | Descrição        | Obrigatório? |
|-----------|--------|------------------|--------------|
| name      | string | Nome do usuário  | Sim          |
| email     | string | Email do usuário | Sim          |
| password  | string | Senha do usuário | Sim          |

### Exemplo de requisição

```json
{
    "name": "Fulado de Tal",
    "email": "fulano@email.com",
    "password": "password"
}
```

### Parametros de Resposta

| Parâmetro | Tipo   | Descrição             |
|-----------|--------|-----------------------|
| msg       | string | User has been created |

### Exemplo de Resposta

```json
{
    "msg": "User has been created"
}
```

### Possibilidade de erro

| Codígo | Resposta                                     | Motivo                                                           |
|--------|----------------------------------------------|------------------------------------------------------------------|
| 422    | O campo nome é obrigatorio                   | O campo name não foi inserido na requisição ou foi em branco     |
| 422    | O campo email é obrigatorio                  | O campo email não foi inserido na requisição ou foi em branco    |
| 422    | O campo de senha é obrigatorio               | O campo password não foi inserido na requisição ou foi em branco |
| 422    | O nome deve conter no máximo 255 caracteres  | O campo name foi encaminhado com mais de 255 caracteres          |
| 422    | O email deve conter no máximo 255 caracteres | O campo email foi encaminhado com mais de 255 caracteres         |
| 422    | O email é inválido                           | Ao enviar ao que não seja um email válido                        |
| 401    | O email já existe                            | Ao tentar cadastrar um e-mail já existente no banco de dados     |
