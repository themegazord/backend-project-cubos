## Deletar o cliente

Rota utilizada para deletar um cliente.

### Autenticação

Essa rota é autenticada

### URL

`DELETE /api/debtors/{id}`

### Parametro do endpoint

| Parametro | Tipo    | Descrição     | Obrigatório? |
|-----------|---------|---------------|--------------|
| id        | inteiro | Id do cliente | Sim          |

### Parametro de requisição

Não tem parametro

### Parametros de resposta

| Parâmetro | Tipo   | Descrição           | Status |
|-----------|--------|---------------------|--------|
| vazio     | string | Apagado com sucesso | 200    |
| vazio     | string | Apagado com sucesso | 204    |

### Possibilidade de erro

| Codígo | Resposta                                               | Motivo                                                                        |
|--------|--------------------------------------------------------|-------------------------------------------------------------------------------|
| 404    | O cliente não existe                                   | Ao tentar apagar um cliente que não existe                                    |
| 401    | O cliente contêm um ou mais titulos vencidos           | Ao tentar apagar um cliente que tenha um ou mais titulos vencidos em seu nome |
| 401    | O cliente contêm um ou mais titulos parcialmente pagos | Ao tentar apagar um cliente que tenha um ou mais titulos parcialmente pagos   |

