# Backend Finance Cubo's Acadaemy

## Requisitos

1. PHP 8.^
2. Laravel 9.^
3. Composer 2.5.^

## Instalação PHP

Irei ensinar a como instalar o PHP usando XAMPP, por que já matamos a questão do MySQL.

1. [Clique aqui](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.2.0/xampp-windows-x64-8.2.0-0-VS16-installer.exe) para fazer o download da versão 8.2.0 do XAMPP
2. Clique em **Next**
   ![XAMPP 1](public/readme/xampp_1.png)

3. Clique em **Next**
   ![XAMPP 1](public/readme/xampp_2.png)

4. Clique em **Next**
   ![XAMPP 1](public/readme/xampp_3.png)

5. Clique em **Next**
   ![XAMPP 1](public/readme/xampp_4.png)

6. Clique em **Next**
   ![XAMPP 1](public/readme/xampp_5.png)

Espere a instalação terminar. No final das contas do XAMPP é famoso _full next_ ksks.

## Instalação Composer

1. [Clique aqui](https://getcomposer.org/Composer-Setup.exe) isso vai fazer com que seja baixado a ultima versão do Composer
2. Clique em **Next**
   ![Composer 1](public/readme/composer_1.png)
3. Clique em **Next**
   ![Composer 2](public/readme/composer_2.png)
4. Clique em **Next**
   ![Composer 3](public/readme/composer_3.png)
5. Clique em **Install**
   ![Composer 4](public/readme/composer_4.png)

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
php artisan migrate:refresh
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

## Endpoint

Todas as endpoints da api serão `api/<nome-do-grupo>/<funcionalidade>`

### Grupo Auth

Responsável pelo registro e pelo login do mesmo.

#### api/auth/login

```json
"method": "POST",
"headers": {
    "Accept": "application/json",
},
"body": {
    "email": "",
    "password": ""
},
"validation": {
    "email": [
        "required",
        "email" //email valido
    ],
    "password": [
        "required"
    ]
},
"return": {
    "isValid": {
        "token": "token sha-256",
        "code": 200
    },
    "isNotValid": {
        "error": "Invalid credentials",
        "code": 401,
    },
    "messageValidation": {
        "email.required" : "O campo email é obrigatório",
        "password.required" : "O campo senha é obrigátorio",
        "email.email" : "O email é inválido",
    }
}
```

#### api/auth/register

```json
"method": "POST",
"headers": {
    "Accept": "application/json",
},
"body": {
    "name": "",
    "email": "",
    "password": ""
},
"validation": {
    "name": {
        "required",
        "max:255",
    },
    "email": {
        "required",
        "email",
        "max:255"
    },
    "password": {
        "required"
    }
},
"return": {
    "isValid": {
        "msg": "User has been created",
        "code": 201
    },
    "isNotValid": {},
    "messageValidation": {
        "name.required": "O campo nome é obrigátorio",
            "email.required": "O campo email é obrigatório",
            "password.required": "O campo de senha é obrigatório",
            "name.max": "O nome deve conter no máximo 255 caracteres",
            "email.max": "O email deve conter no máximo 255 caracteres",
            "email.email": "O email é inválido",
            "email.unique": "Email já cadastrado",
    }
}
```

### Grupo Installments

O grupo é utilizado para manipular e receber dados referentes aos titulos.

#### api/installments

```json
"method": "GET",
"headers": {
    "Accept": "application/json",
    "Authorization": "Bearer <token>"
},
"body": {},
"validation": {},
"return": {
    "isValid": {
        [
            "id": 1,
            "users_id": 5,
            "id_billing": 14496,
            "emission_date": "2022-12-29",
            "due_date": "2023-02-03",
            "amount": 94.96,
            "paid_amount": 73.9,
            "created_at": "2023-01-17T01:15:38.000000Z",
            "updated_at": "2023-01-17T01:15:38.000000Z",
            "user": {
                "id": 5,
                "name": "Coy Mayert"
            }
        ],
        "code": 200
    },
    "isNotValid": {
        "unathenticated": {
            "code": 401,
            "message": "Unauthenticated."
        }
    },
    "messageValidation": {}
}
```

#### api/installments
```json
"method": "POST",
"headers": {
    "Accept": "application/json",
    "Authorization": "Bearer <token>"
},
"body": {
    "users_id": 5,
    "id_billing": 14496,
    "emission_date": "2022-12-29",
    "due_date": "2023-02-03",
    "amount": 94.96,
    "paid_amount": 73.9,
},
"validation": {
    "users_id": {
        "exists",
        "numeric"
    },
    "id_billing": {
        "numeric",
        "unique"
    },
    "emission_date": {
        "date",
        "date_format:'Y-m-d'"
    },
    "due_date": {
        "date",
        "date_format:'Y-m-d'",
        "due_date:emission_date"
    },
    "amount": {
        "numeric",
        "min:1"
    },
    "paid_amount": {
        "numeric",
        "min:0",
        "lte:amount"
    }
},
"return": {
    "isValid": {
        "msg": "Installment has been created",
        "code": 201
    },
    "isNotValid": {
        "unathenticated": {
            "code": 401,
            "message": "Unauthenticated."
        }
    },
    "messageValidation": {
        "numeric": "Esse campo é apenas númerico",
        "date": "Esse campo é apenas para data",
        "users_id.exists": "Insira apenas um usuário válido",
        "id_billing.unique": "Já existe essa cobrança",
        "emission_date.date_format": "Formato inválido, formato correto -> YYYY-mm-dd",
        "due_date.date_format": "Formato inválido, formato correto -> YYYY-mm-dd",
        "due_date.due_date": "A data de vencimento não pode ser menor que a data de emissão",
        "amount.min": "O valor do titulo deve ser maior que 0",
        "paid_amount.min": "O valor do pagamento deve ser maior que 0",
        "paid_amount.lte": "O valor do pagamento deve ser menor que o valor do titulo"
    }
}
```
