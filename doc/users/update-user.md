## Atualização de usuários

Atualiza os dados do usuário passado como parametro da rota

### Autenticação

Essa rota é autenticada

### URL

`POST /api/users/{id}`

### Parametro do endpoint

| Parametro | Tipo    | Descrição     | Obrigatório? |
|-----------|---------|---------------|--------------|
| Id        | inteiro | Id do usuário | Sim          |

### Parametro da requisição

| Parametro | Tipo             | Descrição           | Obrigatório? |
|-----------|------------------|---------------------|--------------|
| name      | string           | Nome do usuário     | Sim          |
| email     | string           | Email do usuário    | Sim          |
| password  | string           | Senha do usuário    | Sim          |
| cpf       | string `or` null | CPF do usuário      | Não          |
| phone     | string `or` null | Telefone do usuário | Não          |
| _method   | string           | Metodo da requisição| Sim          |

### Exemplo de requisição

```json
{
    "name": "Gustavo de Camargo Campos",
    "email": "contato.wanjalagus@outlook.com.br",
    "password": "password",
    "cpf": "01234567891",
    "phone": "67999999999",
    "_method":"PATCH"
}
```
### Parametro da resposta

| Parametro | Tipo   | Descrição           |
|-----------|--------|---------------------|
| msg       | string | Mensagem do retorno |
| error     | string | Mensagem de erro    |

### Posibilidade de Erros

| Codígo | Resposta                                      | Motivo                                                           |
|--------|-----------------------------------------------|------------------------------------------------------------------|
| 422    | O campo nome é obrigatorio                    | O campo name não foi inserido na requisição ou foi em branco     |
| 422    | O campo email é obrigatorio                   | O campo email não foi inserido na requisição ou foi em branco    |
| 422    | O campo de senha é obrigatorio                | O campo password não foi inserido na requisição ou foi em branco |
| 422    | O nome deve conter no máximo 255 caracteres   | O campo name foi encaminhado com mais de 255 caracteres          |
| 422    | O email deve conter no máximo 255 caracteres  | O campo email foi encaminhado com mais de 255 caracteres         |
| 422    | O email é inválido                            | Ao enviar ao que não seja um email válido                        |
| 422    | O CPF deve conter no máximo 11 digitos        | Ao encaminhar um CPF com mais de 11 digitos                      |
| 422    | O telefone deve conter no máximo 20 digitos   | Ao telefone encaminhar um telefone com mais de 20 digitos        |                                                  
| 422    | O CPF inserido não é matematicamente válido   | Ao tentar encaminhar um CPF matematicamente inváilido            |
| 401    | O email já está sendo usado por outro usuário | Ao tentar cadastrar um e-mail já existente no banco de dados     |
| 401    | O CPF já está cadastrado em outro usuário     | Ao tentar cadastrar um CPF já existente                          |
| 404    | Usuário não existe                            | Ao passar um id de usuário inexistente                           |
