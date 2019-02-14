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
                    "idTipoReadequacao": 6,
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
                    "idTipoReadequacao": 6,
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
        + idTipoReadequacao (number, required)
        + dsSolicitacao (string)
        + dsJustificativa (string)
        + binDocumento (file)

+ Response 201 (application/json; charset=utf-8)

    + Body

            {
                    "idPronac": 217336,
                    "idReadequacao": 217336,
                    "idTipoReadequacao": 6,
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
                "idTipoReadequacao": 6,
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
        + binDocumento (file)
        + idAvaliador (number)
        + dsAvaliacao (string)

+ Response 200 (application/json; charset=utf-8)

    + Body
        
            {
                "idPronac": 217336,
                "idReadequacao": 217336,
                "idTipoReadequacao": 6,
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
                    "tpCampo": "input",
                    "descricao": "Alteração de Razão Social"
                },
                {
                    "idTipoReadequacao": 4,
                    "tpCampo": "input"
                    "descricao": "Agência Bancária"
                },
                {
                    "idTipoReadequacao": 5,
                    "tpCampo": "textarea",
                    "descricao": "Sinópse da Obra"
                },
                {
                    "idTipoReadequacao": 6,
                    "tpCampo": "textarea",
                    "descricao": "Impacto Ambiental"
                },
                {
                    "idTipoReadequacao": 13,
                    "tpCampo": "data",
                    "descricao": "Período de Execução"
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
                    "tpCampo": "",
                    "descricao": "Remanejamento até 50 %"
                },
                {
                    "idTipoReadequacao": 2,
                    "tpCampo": "",
                    "descricao": "Planilha Orçamentária"
                },
                {
                    "idTipoReadequacao": 22,
                    "tpCampo": "",
                    "descricao": "Saldo de Aplicação"
                },
                {
                    "idTipoReadequacao": 23,
                    "tpCampo": "",
                    "descricao": "Transferência de recursos entre projetos"
                }
            ]
    

## Readequacao - Buscar campos por tipo readequação [/readequacao/campo-atual-projeto?idPronac=216312&idTipoReadequacao=3]

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

## Readequação - Documento [/readequacao/51151/documento]   [DELETE]

+ Parameters
    + idReadequacao: 15122 (number, required)

### Remover documento de uma readequação [DELETE]

+ Response 200 (application/json; charset=utf-8)
  
    + Body
      
            {
                "mensagem": "Arquivo removido com sucesso!"
            }
