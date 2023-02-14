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
