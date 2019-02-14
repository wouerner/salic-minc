HOST: http://localhost:4000

# SALIC API

# Group Readequacao

## Readequacao - Visualizar lista de readequações [/readequacao/dados-readequacao]

### Visualizar lista de readequações [GET]

+ Response 200 (application/json; charset=utf-8)

    + Body
        
            [
                {
                    "idPronac": 217336,
                    "idReadequacao": 217336,
                    "tpoReadequacao": 6,
                    "dtSolicitacao": "2019-01-22",
                    "idSolicitante": 267,
                    "dsSolicitacao": "blabalbalbalablabalb",
                    "dsJustificativa": "É necessário",
                    "idDocumento": 19440,
                    "idAvaliador": 335,
                    "dsAvaliacao": "queuqeuqueuq",
                    "stAtendimento": "N",
                    "siEncaminhamento": 15,
                    "idNrReuniao": 45654,
                    "stEstado": 1,
                    "dtEnvio": "2019-01-23",
                    "stEstagioAtual": "proponente"
                },
                {
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
                    "siEncaminhamento": 15,
                    "idNrReuniao": 45654,
                    "stEstado": 1,
                    "dtEnvio": "2019-01-23",
                    "stEstagioAtual": "proponente"
                }
            ]

### Criar nova readequação [POST]

+ Request (multipart/form-data; charset=utf-8)

    + Attributes 
        + idPronac (number, required)
        + tpoReadequacao (number, required)
        + dsSolicitacao (string, required)
        + dsJustificativa (string)
        + idDocumento (number)

+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                    "idPronac": 217336,
                    "idReadequacao": 217336,
                    "tpoReadequacao": 6,
                    "dtSolicitacao": "2019-01-22",
                    "idSolicitante": 267,
                    "dsSolicitacao": "blabalbalbalablabalb",
                    "dsJustificativa": "É necessário",
                    "idDocumento": 19440,
                    "idAvaliador": 335,
                    "dsAvaliacao": "queuqeuqueuq",
                    "stAtendimento": "N",
                    "siEncaminhamento": 15,
                    "idNrReuniao": 45654,
                    "stEstado": 1,
                    "dtEnvio": "2019-01-23",
                    "stEstagioAtual": "proponente"
            }


## Readequacao - Dados readequação [/readequacao/dados-readequacao/{idReadequacao}]

+ Parameters
    + idReadequacao: 14100 (number, required)

### Visualizar dados readequação [GET]

+ Response 200 (application/json; charset=utf-8)

    + Body
        
            {
                "idPronac": 217336,
                "idReadequacao": 217336,
                "tpoReadequacao": 6,
                "dtSolicitacao": "2019-01-22",
                "idSolicitante": 267,
                "dsSolicitacao": "blabalbalbalablabalb",
                "dsJustificativa": "É necessário",
                "idDocumento": 19440,
                "idAvaliador": 335,
                "dsAvaliacao": "queuqeuqueuq",
                "stAtendimento": "N",
                "siEncaminhamento": 15,
                "idNrReuniao": 45654,
                "stEstado": 1,
                "dtEnvio": "2019-01-23",
                "stEstagioAtual": "proponente"
            }


### Atualizar dados readequação [PUT]

+ Request (multipart/form-data; charset=utf-8)

    + Attributes 
        + dsSolicitacao (string)
        + dsJustificativa (string)
        + idDocumento (number)
        + idAvaliador (number)
        + dsAvaliacao (string)

+ Response 200 (application/json; charset=utf-8)

    + Body
        
            {
                "idPronac": 217336,
                "idReadequacao": 217336,
                "tpoReadequacao": 6,
                "dtSolicitacao": "2019-01-22",
                "idSolicitante": 267,
                "dsSolicitacao": "blabalbalbalablabalb",
                "dsJustificativa": "É necessário",
                "idDocumento": 19440,
                "idAvaliador": 335,
                "dsAvaliacao": "queuqeuqueuq",
                "stAtendimento": "N",
                "siEncaminhamento": 15,
                "idNrReuniao": 45654,
                "stEstado": 1,
                "dtEnvio": "2019-01-23",
                "stEstagioAtual": "proponente"
            }

## Readequacao - Visualizar tipos [/readequacao/tipos?modalidade={modalidade}]

+ Parameters
    + modalidade (string, required) - Modalidade da Readequação - diversas ou planilha 

### Visualizar tipos [GET]

+ Request
    + Attributes
        + modalidade: diversas 

+ Response 200 (application/json; charset=utf-8)

    + Body

            [
                {
                    "idTipoReadequacao": 3,
                    "descricao": "Alteração de Razão Social"
                },
                {
                    "idTipoReadequacao": 4,
                    "descricao": "Agência Bancária"
                },
                {
                    "idTipoReadequacao": 5,
                    "descricao": "Sinópse da Obra"
                },
                {
                    "idTipoReadequacao": 6,
                    "descricao": "Impacto Ambiental"
                }
            ]

+ Request
    + Attributes
        + modalidade: planilha        

+ Response 200 (application/json; charset=utf-8)

    + Body

            [
                {
                    "idTipoReadequacao": 1,
                    "descricao": "Remanejamento até 50 %"
                },
                {
                    "idTipoReadequacao": 2,
                    "descricao": "Planilha Orçamentária"
                },
                {
                    "idTipoReadequacao": 22,
                    "descricao": "Saldo de Aplicação"
                },
                {
                    "idTipoReadequacao": 23,
                    "descricao": "Transferência de recursos entre projetos"
                }
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
                    "descricao": "Remanejamento até 50 %"
                },
                {
                    "idTipoReadequacao": 2,
                    "descricao": "Planilha Orçamentária"
                },
                {
                    "idTipoReadequacao": 22,
                    "descricao": "Saldo de Aplicação"
                },
                {
                    "idTipoReadequacao": 23,
                    "descricao": "Transferência de recursos entre projetos"
                },
            ]

###