# API ADDRESSES


# Endpoints Disponíveis

URL base da API

[http://localhost/api](http://localhost:8000/api/v1)

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