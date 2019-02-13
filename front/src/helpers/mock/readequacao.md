HOST: http://localhost:4000

# SALIC API

# Group Readequacao

## Readequacao - Proponente Visualizar [/readequacao/readequacao-proponente-rest/idPronac/{idPronac}]

+ Parameters
    + idPronac: 217336 (number, required)

### Proponente visualizar readequação [GET]

+ Response 200 (application/json; charset=utf-8)

    + Body
        
            {
                "data": {
                    "idPronac": 217336,
                    "idReadequacao": 19440,
                }
            }


## Readequacao - Visualizar tipos [/readequacao/tipos-diversos/]

### Visualizar tipos de readequação [GET]

+ Response 200 (application/json; charset=utf-8)

    + Body

            [
                {
                    "idTipoReadequacao": 3,
                    "descricao": "Alteração de Razão Social",
                },
                {
                    "idTipoReadequacao": 4,
                    "descricao": "Agência Bancária",
                },
                {
                    "idTipoReadequacao": 5,
                    "descricao": "Sinópse da Obra",
                },
                {
                    "idTipoReadequacao": 6,
                    "descricao": "Impacto Ambiental",
                },
            ]

## Readequacao - Visualizar tipos [/readequacao/tipos-planilha/]

### Visualizar tipos de readequação [GET]

+ Response 200 (application/json; charset=utf-8)

    + Body

            [
                {
                    "idTipoReadequacao": 1,
                    "descricao": "Remanejamento até 50 %",
                },
                {
                    "idTipoReadequacao": 2,
                    "descricao": "Planilha Orçamentária",
                },
                {
                    "idTipoReadequacao": 22,
                    "descricao": "Saldo de Aplicação",
                },
                {
                    "idTipoReadequacao": 23,
                    "descricao": "Transferência de recursos entre projetos",
                },
            ]

## 