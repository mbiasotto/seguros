# API Fake para Testes

Esta é uma API simples para testes de integração com sistemas terceiros. A API não utiliza banco de dados real e retorna dados simulados para facilitar o desenvolvimento e testes.

## Endpoints Disponíveis

### 1. Verificar Cliente

**Endpoint:** `POST /api/fake/verificar-cliente`

**Parâmetros:**
```json
{
    "telefone": "11999999999"
}
```

**Resposta (Cliente Encontrado):**
```json
{
    "status": "success",
    "existe": true,
    "mensagem": "Cliente encontrado no sistema",
    "cliente": {
        "id": 1234,
        "telefone": "11999999999",
        "nome": "Cliente 9999",
        "email": "cliente9999@exemplo.com",
        "data_cadastro": "2023-07-15 10:30:45"
    }
}
```

**Resposta (Cliente Não Encontrado):**
```json
{
    "status": "success",
    "existe": false,
    "mensagem": "Cliente não encontrado no sistema"
}
```

**Observação:** Para fins de teste, os seguintes números de telefone são considerados cadastrados:
- 11999999999
- 21988888888
- 31977777777
- 41966666666

### 2. Cadastrar Cliente

**Endpoint:** `POST /api/fake/cadastrar-cliente`

**Parâmetros:**
```json
{
    "nome": "Nome do Cliente",
    "telefone": "11999999999",
    "email": "cliente@exemplo.com",
    "cpf": "123.456.789-00",
    "endereco": "Rua Exemplo, 123"
}
```

**Resposta:**
```json
{
    "status": "success",
    "mensagem": "Cliente cadastrado com sucesso",
    "cliente": {
        "id": 1234,
        "nome": "Nome do Cliente",
        "telefone": "11999999999",
        "email": "cliente@exemplo.com",
        "cpf": "123.456.789-00",
        "endereco": "Rua Exemplo, 123",
        "data_cadastro": "2023-07-15 10:30:45"
    }
}
```

### 3. Listar Clientes

**Endpoint:** `GET /api/fake/listar-clientes`

**Resposta:**
```json
{
    "status": "success",
    "total": 3,
    "clientes": [
        {
            "id": 1001,
            "nome": "Cliente Exemplo 1",
            "telefone": "11999999999",
            "email": "cliente1@exemplo.com",
            "data_cadastro": "2023-06-15 10:30:45"
        },
        {
            "id": 1002,
            "nome": "Cliente Exemplo 2",
            "telefone": "21988888888",
            "email": "cliente2@exemplo.com",
            "data_cadastro": "2023-06-30 14:20:10"
        },
        {
            "id": 1003,
            "nome": "Cliente Exemplo 3",
            "telefone": "31977777777",
            "email": "cliente3@exemplo.com",
            "data_cadastro": "2023-07-10 09:15:30"
        }
    ]
}
```

## Como Testar

Você pode testar esses endpoints usando ferramentas como Postman, Insomnia ou curl. Exemplo de comando curl:

```bash
# Verificar cliente
curl -X POST http://seu-dominio.com/api/fake/verificar-cliente \
  -H "Content-Type: application/json" \
  -d '{"telefone": "11999999999"}'

# Cadastrar cliente
curl -X POST http://seu-dominio.com/api/fake/cadastrar-cliente \
  -H "Content-Type: application/json" \
  -d '{"nome": "Nome do Cliente", "telefone": "11999999999", "email": "cliente@exemplo.com"}'

# Listar clientes
curl -X GET http://seu-dominio.com/api/fake/listar-clientes
```
