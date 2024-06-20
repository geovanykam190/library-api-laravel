## Laravel 10 REST API - Laravel Library

Esse projeto tem como objetivo, criar uma biblioteca de livros, utilizando API REST e autenticação JWT.

## Table of Contents

- [Installation](#installation)
- [Endpoints](#endpoints)


## Installation

1. Clone o repositorio:
   ```bash
   git clone https://github.com/geovanykam190/library-api-laravel.git
    ```

2. Va até o diretorio da aplicação:
    ```bash
    cd library-api-laravel
    ```

3. Instale as dependencias usando Composer:
   ```bash
   composer install
    ```

4. Configure suas variaveis de ambiente copiando o arquivo `.env.example` e crie seu .env principal:
   ```bash
   cp .env.example .env
    ```

5. Gere um novo application key:
    ```bash
    php artisan key:generate
    ```

6. Configure seu banco de dados e conexões no arquivo `.env` criado.

7. na UserSeeder.php coloque informações de usuario com um email VERDADEIRO, pois ele sera utilizado para o disparo de e-mail com o Laravel Queue.

8. Rode o comando customizado do artisan para criar toda a estrutura de funcionamento do sistema:
    ```bash
    php artisan app:start-project
    ```

9. Gere o JWT secret key:
   ```bash
   php artisan jwt:secret
    ```

10. Para ativar a API para uso, é necessário rodar o seguinte comando:
   ```bash
   php artisan serve

    ```
10. Para realizar o envio de emails com o Laravel QUEUE, é necessario iniciar o serviço de trabalho das filas em outro terminal diferente do artisan SERVE:
   ```bash
   php artisan queue:work
    ```


## Endpoints
A documentação de todos os endpoints pode ser encontrada na seguite URL:
https://documenter.getpostman.com/view/12595155/2sA3XV8KPM



#### Autenticar o usuario
Primeiro, é necessario realizar o Login com usuario e senha na API REST para gerar o Bearer TOKEN e utiliza-lo em outras requisições.




## Erros de Autenticação
Em caso de erros de autenticação, a API ira retornar o erro no formato Json.


Aqui tem um exemplo:
```json
{
    "error": {
        "message": "The provided token is invalid, has expired, or has been blacklisted.",
        "type": "OAuthException",
        "code": "token_could_not_verified",
        "trace_id": "qOoyG0cl3R8B4x9j"
    }
}

O token pode estar:
expirado
invalido
```

Em casos assim, basta autenticar novamente com Login e senha para gerar um novo Token.
