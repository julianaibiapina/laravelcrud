# Instalação

> PHP 8.0.21
> 

> Laravel 8
> 

> MySql 14.14
> 
- Instalar as dependências do projeto
    
    ```bash
    composer install
    ```
    
- Criar o arquivo .env
    
    ```bash
    cp .env.example .env
    ```
    
- Preencher as variáveis de ambiente do banco de dados
    
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
    ```
    
- Criar a variável de ambiente com a URL do serviço de busca de CEP
    
    ```json
    CEP_SERVICE_URL=https://viacep.com.br/ws/CEP/json/
    ```
    
- Gerar a key para o JWT
    
    ```bash
    php artisan jwt:secret
    ```
    
- Criar a variável de ambiente JWT_SECRET e atribuir a key gerada no passo anterior
    
    ```bash
    JWT_SECRET={JWT_KEY}
    ```
    

# Endpoints Disponíveis

URL base da API

[http://localhost/{project_name}/public/api](http://localhost:8000/api/v1)

## Auth

### [POST] Register

```bash
/auth/register
```

Body

```json
{
    "name": "Usuario",
    "email": "usuario@email.com",
    "password": "123456"
}
```

Response

```json
{
    "success": true,
    "data": {
        "user": {
            "name": "Usuario",
            "email": "usuario@email.com",
            "updated_at": "2022-08-02T00:22:33.000000Z",
            "created_at": "2022-08-02T00:22:33.000000Z",
            "id": 13
        }
    },
    "message": "User created successfully"
}
```

### [POST] Login

```bash
/auth/login
```

Body

```json
{
  "email": "usuario@mail.com",
  "password": "123456"
}
```

Response

```json
{
    "success": true,
    "data": {
        "token": "TOKEN"
    },
    "message": "Token created successfully"
}
```

### [POST] Logout

```bash
/auth/logout
```

Body

```json
{
  "token": "TOKEN"
}
```

Response

```json
{
    "success": true,
    "data": [],
    "message": "User has been logged out"
}
```

## Addresses

### [POST] Create

```bash
/addresses
```

Headers

```json
{
  "Authorization": "Bearer {TOKEN}",
  "Content-Type": "application/json"
}
```

Body

```json
{
    "cep": "62320069",
    "numero": "1247",
    "ponto_referencia": "Avenida principal da cidade"
}
```

Response

```json
{
    "success": true,
    "data": {
        "endereco": {
            "cep_id": 1,
            "numero": "1247",
            "ponto_referencia": "Avenida principal da cidade",
            "user_id": 13,
            "updated_at": "2022-08-02T00:08:13.000000Z",
            "created_at": "2022-08-02T00:08:13.000000Z",
            "id": 12,
            "cep": {
                "id": 1,
                "cep": "62320069",
                "rua": "Avenida Prefeito Jacques Nunes",
                "bairro": "Centro",
                "cidade": "Tiangua",
                "uf": "CE",
                "created_at": "2022-07-27T18:42:48.000000Z",
                "updated_at": "2022-07-27T18:42:48.000000Z"
            }
        }
    },
    "message": "Address created successfully"
}
```

### [GET] List

```bash
/addresses
```

Headers

```json
{
  "Authorization": "Bearer {TOKEN}",
  "Content-Type": "application/json"
}
```

Body

```json
{
}
```

Response

```json
{
    "success": true,
    "data": {
        "addresses": [
            {
                "id": 1,
                "user_id": 13,
                "numero": "1247",
                "ponto_referencia": "Avenida principal da cidade",
                "created_at": "2022-08-01T01:57:26.000000Z",
                "updated_at": "2022-08-01T01:58:22.000000Z",
                "cep_id": 4,
                "cep": {
                    "id": 1,
		                "cep": "62320069",
		                "rua": "Avenida Prefeito Jacques Nunes",
		                "bairro": "Centro",
		                "cidade": "Tiangua",
		                "uf": "CE",
		                "created_at": "2022-07-27T18:42:48.000000Z",
		                "updated_at": "2022-07-27T18:42:48.000000Z"
                }
            },
        ]
    },
    "message": "OK"
}
```

### [GET] Show

```bash
/addresses/{id}
```

Headers

```json
{
  "Authorization": "Bearer {TOKEN}",
  "Content-Type": "application/json"
}
```

Body

```json
{
}
```

Response

```json
{
    "success": true,
    "data": {
        "address": {
            "id": 11,
            "user_id": 13,
            "numero": "1247",
            "ponto_referencia": "Avenida principal da cidade",
            "created_at": "2022-08-02T00:06:46.000000Z",
            "updated_at": "2022-08-02T00:06:46.000000Z",
            "cep_id": 1,
            "cep": {
                "id": 1,
                "cep": "62320069",
                "rua": "Avenida Prefeito Jacques Nunes",
                "bairro": "Centro",
                "cidade": "Tiangua",
                "uf": "CE",
                "created_at": "2022-07-27T18:42:48.000000Z",
                "updated_at": "2022-07-27T18:42:48.000000Z"
            }
        }
    },
    "message": "OK"
}
```

### [PUT] Update

```bash
/addresses/{id}
```

Headers

```json
{
  "Authorization": "Bearer {TOKEN}",
  "Content-Type": "application/json"
}
```

Body

```json
{
    "cep": "62320021",
    "numero": "1010",
    "ponto_referencia": "Proximo a Igreja"
}
```

Response

```json
{
    "success": true,
    "data": [],
    "message": "Address updated successfully"
}
```

### [DELETE] Delete

```bash
/addresses/{id}
```

Headers

```json
{
  "Authorization": "Bearer {TOKEN}",
  "Content-Type": "application/json"
}
```

Body

```json
{
}
```

Response

```json
{
    "success": true,
    "data": [],
    "message": "Address deleted successfully"
}
```

# Tópicos e conceitos aplicados

- Repository pattern
- Service layer
- Clean Code
- Traits do PHP
- JWT Authentication