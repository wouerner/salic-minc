HOST: http://localhost:4000

# SALIC API

# Group Readequacao

## Readequacao - Dados readequação [/readequacao/dados-readequacao/idReadequacao/{idReadequacao}]

+ Parameters
    + idReadequacao: 14100 (number, required)

### Visualizar dados readequação [GET]

+ Response 200 (application/json; charset=utf-8)

    + Body
        
            {
                "data": {
                    "idPronac": 217336,
                    "idReadequacao": 217336,
                    "tpoReadequacao": 6,
                    "dtSolicitacao": "2019-01-22",
                    "idSolicitante": 267,
                    "dsSolicitacao": "blabalbalbalablabalb",
                    "dsJustificativa": "É nescessário",
                    "idDocumento": 19440,
                    "idAvaliador": 335,
                    "dsAvaliacao": "queuqeuqueuq",
                    "stAtendimento": "N",
                    "siEncaminhamento": 86942,
                    "idNrReuniao": 45654,
                    "stEstado": 1,
                    "dtEnvio": "2019-01-23"
                }
            }

## Readequacao - Proponente Visualizar [/readequacao/readequacao-proponente/idPronac/{idPronac}]

+ Parameters
    + idPronac: 217336 (number, required)

### Proponente visualizar readequação [GET]

+ Response 200 (application/json; charset=utf-8)

    + Body
        
            {
                "data": {
                    "itens": [
                        {
                            "idPronac": 217336,
                            "idReadequacao": 546,
                            "tpoReadequacao": 6,
                            "dtSolicitacao": "2019-01-22",
                            "idSolicitante": 267,
                            "dsSolicitacao": "blabalbalbalablabalb",
                            "dsJustificativa": "É nescessário",
                            "idDocumento": 19440,
                            "idAvaliador": 335,
                            "dsAvaliacao": "queuqeuqueuq",
                            "stAtendimento": "N",
                            "siEncaminhamento": 86942,
                            "idNrReuniao": 45654,
                            "stEstado": 1,
                            "dtEnvio": "2019-01-23"
                        },
                        {
                            "idPronac": 217336,
                            "idReadequacao": 74987,
                            "tpoReadequacao": 6,
                            "dtSolicitacao": "2019-01-22",
                            "idSolicitante": 267,
                            "dsSolicitacao": "blabalbalbalablabalb",
                            "dsJustificativa": "É nescessário",
                            "idDocumento": 19440,
                            "idAvaliador": 335,
                            "dsAvaliacao": "queuqeuqueuq",
                            "stAtendimento": "N",
                            "siEncaminhamento": 86942,
                            "idNrReuniao": 45654,
                            "stEstado": 1,
                            "dtEnvio": "2019-01-23"
                        }
                    ]
                }
            }

### Proponente enviar readequação [POST]

+ Request (application/json; charset=utf-8)

    + Attributes 

            {
                "idPronac": 217336
                "idTipoReadequacao": 4
                "dsSolicitacao": "novo nome para o projeto"
                "dsJustificativa": "porque sim" 
                "idDocumento": ""
            }

+ Response 201 (application/json; charset=utf-8)

    + Attributes (object)
        + status: 1 (number)
        + msg: Readequação criada com sucesso! (string)
        + redirect: `/readequacao/readequacao-proponente/idPronac/217336` (string)

## Readequacao - Visualizar tipos [/readequacao/readequacao-proponente/tipos-diversos/]

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

## Readequacao - Buscar campos por tipo readequação [/readequacao/campo-para-editar/]

+ Parameters
    + idPronac: 217336 (number, required)
    + idTipoReadequacao: 5 (number, required)

### Buscar campos por tipo readequação [GET]

+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                {
                    "tpoCampo": "date",
                    "dscCampo": "2018-12-25",
                }
            }

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

###