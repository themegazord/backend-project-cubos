# Backend Finance Cubo's Acadaemy

## Requisitos

1. PHP 8.^
2. Laravel 9.^
3. Composer 2.5.^

## Clonagem e instalação das dependências

Após tudo isso instalado com sucesso, crie uma pasta para comportar o clone do repositório usando e entre na pasta

```bash
mkdir <nome-repo>
cd <nome-repo>
```

Ao entrar na pasta, execute o seguinte código

```bash
git clone https://github.com/themegazord/backend-project-cubos.git backend
cd backend
```

Isso irá criar uma pasta chamada `backend` e te levará até a mesma.

Dentro, execute o comando para instalar as dependências do projeto.

```bash
composer install
```

## Erro php-zip

Caso, ao rodar o comando acima, der erro informando sobre a falta de php-zip, vá até seu `php.ini`, que, se estiver utilizando xampp, estara em: `C:\xampp\php`, procure o arquivo `php.ini` e abra-o. Pesquise por `zip`, teclando `CTRL+F` e logo abaixo da linha comentada identificada, insira `extension=php_zip.dll` e salve. Agora, rode novamente `composer install`.

## Configurando .ENV

Como o .gitignore não permite o compartilhamento do arquivo `.env`, copie e cole no seu diretório o arquivo `.env.example` e altere o nome para `.env`.

Dentro do arquivo `.ENV` você vai ter que configurar o banco de dados baseado nas seguintes _tags_

```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=financas_cubos
DB_USERNAME=root
DB_PASSWORD=
```

Caso você tenha instalado o XAMPP, apenas altere o nome do banco de dados pela tag `DB_DATABASE` que ta show de bola.

Por último abra o terminal na pasta raiz do projeto e execute o comando:

```shell
php artisan key:generate
```

Isso irá criar o `APP_KEY` no `.env`.

## Inserindo as migrations no banco de dados.

Toda vez que houver atualização, você tera que rodar o seguinte comando

```bash
php artisan migrate:refresh --seed
```

Isso vai fazer com que o Eloquent (ORM do Laravel) de um rollback em todas as tabelas do banco de dados e migre elas novamente.

## Executando o servidor

Com tudo configurado, vamos iniciar o servidor rodando o seguinte comando

```bash
php artisan serve
```

Isso irá criar um servidor na porta 8000 por padrão, caso deseje executar em uma porta especifica, execute

```bash
php artisan serve --port=<numero-da-porta>
```

# Endpoints

## Autenticação

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

---

## Titulos

## Listagem de Titulos

Usado para listar todos os titulos existentes no banco de dados.

### Autenticação

Essa rota é autenticada

### URL
`GET /api/installments`

### Parametro de requisição

Não tem parametro

### Filtros

| Filtro | Exemplo                                             |
|--------|-----------------------------------------------------|
| `=`    | `/api/installments?filter=debtor:=:'Fulano de Tal'` |
| `>`    | `/api/installments?filter=amount:>:50`              |
| `<`    | `/api/installments?filter=amount:<:50`              |
| `>=`   | `/api/installments?filter=amount:>=:50`             |
| `<=`   | `/api/installments?filter=amount:<=:50`             |
| `like` | `/api/installments?filter=debtor:like:'%Ful%'`      |

Você também pode usar mais de um filtro, usando `;` para separar cada uma.

### Exemplos

`/api/installments?filter=debtor:=:'Fulano de Tal';amount:>:50`

## Cadastro de Titulos

Utilizada para cadastrar titulos no sistema

### Autenticação

Essa rota é autenticada

### URL

`POST /api/installments`

### Parametros de requisição

| Parametro     | Tipo    | Descrição                    | Obrigatório? |
|---------------|---------|------------------------------|--------------|
| users_id      | inteiro | Id do criador do titulo      | Sim          |
| id_billing    | inteiro | Id da cobrança               | Sim          |
| debtor        | string  | Nome do devedor              | Sim          |
| emission_date | string  | Data de emissão do titulo    | Sim          |
| due_date      | string  | Data do vencimento do titulo | Sim          |
| amount        | float   | Valor do titulo              | Sim          |
| paid_amount   | float   | Valor pago do titulo         | Sim          |

### Exemplo de requisição

```json
{
    "users_id": 5,
    "id_billing": 14496,
    "debtor": "Samantha Kshlerin",
    "emission_date": "2022-12-29",
    "due_date": "2023-02-03",
    "amount": 94.96,
    "paid_amount": 73.9
}
```

### Parametros de resposta

| Parâmetro | Tipo   | Descrição                    |
|-----------|--------|------------------------------|
| msg       | string | Installment has been created |

### Exemplo de resposta

```json
{
    "msg": "Installment has been created"
}
```

### Possibilidade de erro

| Codígo | Resposta                                                           | Motivo                                                                  |
|--------|--------------------------------------------------------------------|-------------------------------------------------------------------------|
| 422    | Esse campo é apenas númerico                                       | Ao tentar encaminhar algo que não seja númerico no campo                |
| 422    | Esse campo é apenas data                                           | Ao tentar encaminhar algo que não seja data no campo                    |
| 422    | Insira apenas um usuário válido                                    | Ao tentar passar um código de usuário inexistente no `users_id`         |
| 422    | O nome do devedor deve ser um texto                                | Ao tentar passar algo diferente de `string` no campo `debtor`           |
| 422    | O nome do devedor deve conter no máximo 155 caracteres             | Ao tentar encaminhar um nome do `debtor` maior que 155 caracteres       |
| 422    | Formato inválido, formato correto -> YYYY-mm-dd                    | Ao inserir um padrão de data diferente de `YYYY-mm-dd`                  |
| 422    | A data de vencimento não pode ser menor que a data de emissão      | Ao passar a data de vencimento menor que a data de emissão              |
| 422    | O valor do titulo deve ser maior que 0                             | Ao passar um valor menor ou igual a 0 como valor do titulo              |
| 422    | O valor do pagamento deve ser maior que 0                          | Ao passar um valor menor ou igual a 0 como valor do pagamento           |
| 422    | O valor do pagamento deve ser menor ou igual que o valor do titulo | Ao passar um valor pago maior que o valor do titulo                     |
| 400    | A cobrança já existe                                               | Ao tentar criar ou mudar um titulo inserindo uma cobrança que já existe |

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

## Atualizar titulos

Utilizado para atualizar o titulo passado.

### Autenticação

Essa rota é autenticada

### URL

`POST /api/installments/{id}`

### Parametro do endpoint

| Parametro | Tipo    | Descrição    | Obrigatório? |
|-----------|---------|--------------|--------------|
| id        | inteiro | Id do titulo | Sim          |

### Parametros da requisição

| Parametro     | Tipo    | Descrição                                     | Obrigatório? |
|---------------|---------|-----------------------------------------------|--------------|
| users_id      | inteiro | Id do criador do titulo                       | Sim          |
| id_billing    | inteiro | Id da cobrança                                | Sim          |
| debtor        | string  | Nome do devedor                               | Sim          |
| emission_date | string  | Data de emissão do titulo                     | Sim          |
| due_date      | string  | Data do vencimento do titulo                  | Sim          |
| amount        | float   | Valor do titulo                               | Sim          |
| paid_amount   | float   | Valor pago do titulo                          | Sim          |
| _method       | string  | Método utilizado para a rota `PUT` ou `PATCH` | Sim          |

### Exemplo de requisição

```json
{
    "users_id": 7,
    "id_billing": 12704,
    "debtor": "Samantha Kshlerin",
    "emission_date": "2023-01-14",
    "due_date": "2023-02-15",
    "amount": 81.16,
    "paid_amount": 81.16,
    "_method": "PUT|PATCH"
}
```
| Parâmetro       | Tipo    | Descrição                                                                   |
|-----------------|---------|-----------------------------------------------------------------------------|
| users_id        | inteiro | Id do criador do titulo                                                     |
| id_billing      | inteiro | Id da cobrança                                                              |
| status          | string  | Define o status do titulos que varia entre `Open`, `Partially Paid`, `Paid` |
| debtor          | string  | Nome do devedor                                                             |
| emission_date   | string  | Data de emissão do titulo                                                   |
| due_date        | string  | Data do vencimento do titulo                                                |
| overdue_payment | bool    | Define se o titulo está vencido ou não                                      |
| amount          | float   | Valor do titulo                                                             |
| paid_amount     | float   | Valor pago do titulo                                                        |
| _method         | string  | Método usado na requisição                                                  |

### Exemplo de resposta

```json
{
    "users_id": "3",
    "id_billing": "94312",
    "debtor": "Fulano de Tal",
    "emission_date": "2023-01-05",
    "due_date": "2023-02-01",
    "amount": "54.48",
    "paid_amount": "26.53",
    "_method": "PATCH",
    "status": "Partially paid"
}
```

### Possibilidade de erro

| Codígo | Resposta                                                           | Motivo                                                                  |
|--------|--------------------------------------------------------------------|-------------------------------------------------------------------------|
| 422    | Esse campo é apenas númerico                                       | Ao tentar encaminhar algo que não seja númerico no campo                |
| 422    | Esse campo é apenas data                                           | Ao tentar encaminhar algo que não seja data no campo                    |
| 422    | Insira apenas um usuário válido                                    | Ao tentar passar um código de usuário inexistente no `users_id`         |
| 422    | O nome do devedor deve ser um texto                                | Ao tentar passar algo diferente de `string` no campo `debtor`           |
| 422    | O nome do devedor deve conter no máximo 155 caracteres             | Ao tentar encaminhar um nome do `debtor` maior que 155 caracteres       |
| 422    | Formato inválido, formato correto -> YYYY-mm-dd                    | Ao inserir um padrão de data diferente de `YYYY-mm-dd`                  |
| 422    | A data de vencimento não pode ser menor que a data de emissão      | Ao passar a data de vencimento menor que a data de emissão              |
| 422    | O valor do titulo deve ser maior que 0                             | Ao passar um valor menor ou igual a 0 como valor do titulo              |
| 422    | O valor do pagamento deve ser maior que 0                          | Ao passar um valor menor ou igual a 0 como valor do pagamento           |
| 422    | O valor do pagamento deve ser menor ou igual que o valor do titulo | Ao passar um valor pago maior que o valor do titulo                     |
| 400    | A cobrança já existe                                               | Ao tentar criar ou mudar um titulo inserindo uma cobrança que já existe |

---

## Usuários

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

### Exemplo de requisição

```json
{
    "name": "Gustavo de Camargo Campos",
    "email": "contato.wanjalagus@outlook.com.br",
    "password": "password",
    "cpf": "01234567891",
    "phone": "67999999999"
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

## Consulta dados do usuário

Retorna os dados do usuário que foi passado como parametro

### Autenticação

Essa rota é autenticada

### URL

`POST /api/installments/{id}`

### Parametro do endpoint

| Parametro | Tipo    | Descrição    | Obrigatório? |
|-----------|---------|--------------|--------------|
| id        | inteiro | Id do titulo | Sim          |

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
