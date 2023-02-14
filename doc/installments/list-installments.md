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
