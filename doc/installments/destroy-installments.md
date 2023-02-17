## Deletar titulos

Rota utilizada para deletar titulos

### Autenticação

Essa rota é autenticada

### URL

`DELETE /api/installments/{id}`

### Parametro do endpoint

| Parametro | Tipo    | Descrição    | Obrigatório? |
|-----------|---------|--------------|--------------|
| id        | inteiro | Id do titulo | Sim          |

### Parametro de requisição

Não tem parametro

### Parametros de resposta

| Parâmetro | Tipo   | Descrição           | Status |
|-----------|--------|---------------------|--------|
| vazio     | string | Apagado com sucesso | 204    |

### Possibilidade de erro

| Codígo | Resposta                                                                                                       | Motivo                                                |
|--------|----------------------------------------------------------------------------------------------------------------|-------------------------------------------------------|
| 404    | O titulo não existe                                                                                            | Ao tentar apagar um titulo que não existe             |
| 401    | O titulo não pode ser apagado, pois está parcialmente pago, defina-o como aberto ou quite-o para poder apagar. | Ao tentar apagar um titulo que está parcialmente pago |
| 401    | O titulo não pode ser apagado, pois está em atraso                                                             | Ao tentar apagar um titulo vencido                    |


