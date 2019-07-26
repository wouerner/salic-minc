HOST: http://localhost:4000

# SALIC API

# Group Readequacao

## Readequacao - Visualizar lista de readequações [/readequacao?idPronac=202779&idTipoReadequacao=22&stStatusAtual=proponente]

### Filtro por três parâmetros [GET]

+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                "data": {
                    "code": 200,
                    "items": [
                        {
                            "idPronac": 217336,
                            "idReadequacao": 15123,
                            "idTipoReadequacao": 2,
                            "dsTipoReadequacao": "Planilha orçamentária",
                            "dtSolicitacao": "2019-01-22",
                            "idSolicitante": 267,
                            "dsNomeSolicitante": "Leôncio das Neves",
                            "dsSolicitacao": "Solicito alteração na planilha.",
                            "dsJustificativa": "É necessário",
                            "idDocumento": 19440,
                            "idAvaliador": 335,
                            "dsNomeAvaliador": "Ciclano avaliador",
                            "dtAvaliador": "2019-02-03",
                            "dsAvaliacao": "Avalio que está bom.",
                            "stAtendimento": "N",
                            "siEncaminhamento": 15,
                            "idNrReuniao": 45654,
                            "stEstado": 1,
                            "dtEnvio": "2019-01-23",
                            "stStatusAtual": "proponente"
                        },
                        {
                            "idPronac": 217336,
                            "idReadequacao": 15124,
                            "idTipoReadequacao": 6,
                            "dsTipoReadequacao": "Impacto ambiental",
                            "dtSolicitacao": "2019-01-22",
                            "idSolicitante": 267,
                            "dsNomeSolicitante": "Leôncio das Neves",
                            "dsSolicitacao": "Descrição completa do impacto ambiental...",
                            "dsJustificativa": "É necessário alterar a parte que diz sobre o consumo de água elevado.",
                            "idDocumento": 19440,
                            "idAvaliador": 335,
                            "dsNomeAvaliador": "Ciclano avaliador",
                            "dtAvaliador": "2019-02-03",
                            "dsAvaliacao": "Avaliação positiva, de acordo.",
                            "stAtendimento": "N",
                            "siEncaminhamento": 15,
                            "idNrReuniao": 45654,
                            "stEstado": 1,
                            "dtEnvio": "2019-01-23",
                            "stStatusAtual": "proponente"
                        },
                        {
                            "idPronac": 217336,
                            "idReadequacao": 15125,
                            "idTipoReadequacao": 10,
                            "dsTipoReadequacao": "Alteração de Proponente",
                            "dtSolicitacao": "2019-01-22",
                            "idSolicitante": 267,
                            "dsNomeSolicitante": "Leôncio das Neves",
                            "dsSolicitacao": "Fulano de Tal",
                            "dsJustificativa": "Ciclano não está mais no projeto, adicionando Fulano de Tal",
                            "idDocumento": 19440,
                            "idAvaliador": 335,
                            "dsNomeAvaliador": "Ciclano avaliador",
                            "dtAvaliador": "2019-02-03",
                            "dsAvaliacao": "Avaliação positiva, de acordo.",
                            "stAtendimento": "N",
                            "siEncaminhamento": 15,
                            "idNrReuniao": 45654,
                            "stEstado": 1,
                            "dtEnvio": "2019-01-23",
                            "stStatusAtual": "proponente"
                        },
                        {
                            "idPronac": 217336,
                            "idReadequacao": 15126,
                            "idTipoReadequacao": 12,
                            "dsTipoReadequacao": "Nome do Projeto",
                            "dtSolicitacao": "2019-01-22",
                            "idSolicitante": 267,
                            "dsNomeSolicitante": "Leôncio das Neves",
                            "dsSolicitacao": "19 Gramado Cine Áudio Video",
                            "dsJustificativa": "Adicionamos 'áudio' porque é preciso",
                            "idDocumento": 19440,
                            "idAvaliador": 335,
                            "dsNomeAvaliador": "Ciclano avaliador",
                            "dtAvaliador": "2019-02-03",
                            "dsAvaliacao": "Ok, de acordo. Aprovado",
                            "stAtendimento": "N",
                            "siEncaminhamento": 15,
                            "idNrReuniao": 45654,
                            "stEstado": 1,
                            "dtEnvio": "2019-01-23",
                            "stStatusAtual": "proponente"
                        },
                        {
                            "idPronac": 217336,
                            "idReadequacao": 15127,
                            "idTipoReadequacao": 13,
                            "dsTipoReadequacao": "Período de Execução",
                            "dtSolicitacao": "2019-01-22",
                            "idSolicitante": 267,
                            "dsNomeSolicitante": "Leôncio das Neves",
                            "dsSolicitacao": "2019-06-01 00:00:00",
                            "dsJustificativa": "Ampliando período de execução para dar tempo.",
                            "idDocumento": 19440,
                            "idAvaliador": 335,
                            "dsNomeAvaliador": "Ciclano avaliador",
                            "dtAvaliador": "2019-02-03",
                            "dsAvaliacao": "Ok, de acordo. Aprovado",
                            "stAtendimento": "N",
                            "siEncaminhamento": 15,
                            "idNrReuniao": 45654,
                            "stEstado": 1,
                            "dtEnvio": "2019-01-23",
                            "stStatusAtual": "proponente"
                        }
                    ]
                }
            }

## Readequacao - Obter Documento anexado [/readequacao/documento?idDocumento={idDocumento}&idReadequacao={idReadequacao}]

+ Parameters
    + idDocumento: 14100 (number, required)
    + idReadequacao: 14100 (number, required)

### Filtro por id do Documento [GET]

+ Response 200 (application/pdf; charset=utf-8)

    + Body

            {
                filename: "documento-readequacao.pdf",
                type: "application/pdf",
                content: "[BINARY CODE]"
            }

## Readequacao - Visualizar lista de readequações [/readequacao?idPronac={idPronac}]

+ Parameters
    + idPronac: 14100 (number, required)

### Visualizar lista de readequações [GET]

+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                "data": {
                    "code": 200,
                    "items": [
                        {
                            "idPronac": 217336,
                            "idReadequacao": 15123,
                            "idTipoReadequacao": 2,
                            "dsTipoReadequacao": "Planilha orçamentária",
                            "dtSolicitacao": "2019-01-22",
                            "idSolicitante": 267,
                            "dsNomeSolicitante": "Leôncio das Neves",
                            "dsSolicitacao": "Solicito alteração na planilha.",
                            "dsJustificativa": "É necessário",
                            "idDocumento": 19440,
                            "idAvaliador": 335,
                            "dsNomeAvaliador": "Ciclano avaliador",
                            "dtAvaliador": "2019-02-03",
                            "dsAvaliacao": "Avalio que está bom.",
                            "stAtendimento": "N",
                            "siEncaminhamento": 15,
                            "idNrReuniao": 45654,
                            "stEstado": 1,
                            "dtEnvio": "2019-01-23",
                            "stStatusAtual": "proponente"
                        },
                        {
                            "idPronac": 217336,
                            "idReadequacao": 15124,
                            "idTipoReadequacao": 6,
                            "dsTipoReadequacao": "Impacto ambiental",
                            "dtSolicitacao": "2019-01-22",
                            "idSolicitante": 267,
                            "dsNomeSolicitante": "Leôncio das Neves",
                            "dsSolicitacao": "<p><b>Descrição completa do impacto ambiental...</b></p>",
                            "dsJustificativa": "É necessário alterar a parte que diz sobre o consumo de água elevado.",
                            "idDocumento": 19440,
                            "idAvaliador": 335,
                            "dsNomeAvaliador": "Ciclano avaliador",
                            "dtAvaliador": "2019-02-03",
                            "dsAvaliacao": "Avaliação positiva, de acordo.",
                            "stAtendimento": "N",
                            "siEncaminhamento": 15,
                            "idNrReuniao": 45654,
                            "stEstado": 1,
                            "dtEnvio": "2019-01-23",
                            "stStatusAtual": "proponente"
                        },
                        {
                            "idPronac": 217336,
                            "idReadequacao": 15125,
                            "idTipoReadequacao": 10,
                            "dsTipoReadequacao": "Alteração de Proponente",
                            "dtSolicitacao": "2019-01-22",
                            "idSolicitante": 267,
                            "dsNomeSolicitante": "Leôncio das Neves",
                            "dsSolicitacao": "Fulano de Tal",
                            "dsJustificativa": "Ciclano não está mais no projeto, adicionando Fulano de Tal",
                            "idDocumento": 19440,
                            "idAvaliador": 335,
                            "dsNomeAvaliador": "Ciclano avaliador",
                            "dtAvaliador": "2019-02-03",
                            "dsAvaliacao": "Avaliação positiva, de acordo.",
                            "stAtendimento": "N",
                            "siEncaminhamento": 15,
                            "idNrReuniao": 45654,
                            "stEstado": 1,
                            "dtEnvio": "2019-01-23",
                            "stStatusAtual": "proponente"
                        },
                        {
                            "idPronac": 217336,
                            "idReadequacao": 15126,
                            "idTipoReadequacao": 12,
                            "dsTipoReadequacao": "Nome do Projeto",
                            "dtSolicitacao": "2019-01-22",
                            "idSolicitante": 267,
                            "dsNomeSolicitante": "Leôncio das Neves",
                            "dsSolicitacao": "19 Gramado Cine Áudio Video",
                            "dsJustificativa": "Adicionamos 'áudio' porque é preciso",
                            "idDocumento": 19440,
                            "idAvaliador": 335,
                            "dsNomeAvaliador": "Ciclano avaliador",
                            "dtAvaliador": "2019-02-03",
                            "dsAvaliacao": "Ok, de acordo. Aprovado",
                            "stAtendimento": "N",
                            "siEncaminhamento": 15,
                            "idNrReuniao": 45654,
                            "stEstado": 1,
                            "dtEnvio": "2019-01-23",
                            "stStatusAtual": "proponente"
                        },
                        {
                            "idPronac": 217336,
                            "idReadequacao": 15127,
                            "idTipoReadequacao": 13,
                            "dsTipoReadequacao": "Período de Execução",
                            "dtSolicitacao": "2019-01-22",
                            "idSolicitante": 267,
                            "dsNomeSolicitante": "Leôncio das Neves",
                            "dsSolicitacao": "2019-06-01 00:00:00",
                            "dsJustificativa": "Ampliando período de execução para dar tempo.",
                            "idDocumento": 19440,
                            "idAvaliador": 335,
                            "dsNomeAvaliador": "Ciclano avaliador",
                            "dtAvaliador": "2019-02-03",
                            "dsAvaliacao": "Ok, de acordo. Aprovado",
                            "stAtendimento": "N",
                            "siEncaminhamento": 15,
                            "idNrReuniao": 45654,
                            "stEstado": 1,
                            "dtEnvio": "2019-01-23",
                            "stStatusAtual": "proponente"
                        }
                    ]
                }
            }

### Criar nova readequação [POST]

+ Request (multipart/form-data; boundary=BOUNDARY)

        --BOUNDARY
        Content-Disposition: form-data; name="idPronac"

        215221
        --BOUNDARY
        Content-Disposition: form-data; name="idTipoReadequacao"

        5
        --BOUNDARY
        Content-Disposition: form-data; name="dsSolicitacao"

        Porque sim, eu quero!
        --BOUNDARY
        Content-Disposition: form-data; name="dsJustificativa"

        Porque é necessário.
        --BOUNDARY
        Content-Disposition: form-data; name="documento"; filename="file.pdf"
        Content-Type: application/pdf
        Content-Transfer-Encoding: base64

        [BINARY CODE]
        --BOUNDARY

+ Response 201 (application/json; charset=utf-8)

    + Body

            {
                    "idPronac": 217336,
                    "idReadequacao": 15128,
                    "idTipoReadequacao": 6,
                    "dsTipoReadequacao": "Impacto ambiental",
                    "dtSolicitacao": "2019-01-22",
                    "idSolicitante": 267,
                    "dsNomeSolicitante": "Leôncio das Neves",
                    "dsSolicitacao": "blabalbalbalablabalb",
                    "dsJustificativa": "É necessário",
                    "idDocumento": 19440,
                    "idAvaliador": 335,
                    "dtAvaliador": "2019-02-03",
                    "dsAvaliacao": "queuqeuqueuq",
                    "stAtendimento": "N",
                    "siEncaminhamento": 15,
                    "idNrReuniao": 45654,
                    "stEstado": 1,
                    "dtEnvio": "2019-01-23",
                    "stStatusAtual": "proponente"
            }


## Readequacao - Dados readequação [/readequacao/dados-readequacao/{idReadequacao}]

+ Parameters
    + idReadequacao: 15125 (number, required)

### Visualizar dados readequação [GET]

+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                "idPronac": 217336,
                "idReadequacao": 15125,
                "idTipoReadequacao": 6,
                "dtSolicitacao": "2019-01-22",
                "idSolicitante": 267,
                "dsNomeSolicitante": "Leôncio das Neves",
                "dsSolicitacao": "blabalbalbalablabalb",
                "dsJustificativa": "É necessário",
                "idDocumento": 19440,
                "idAvaliador": 335,
                "dtAvaliador": "2019-02-03",
                "dsAvaliacao": "queuqeuqueuq",
                "stAtendimento": "N",
                "siEncaminhamento": 15,
                "idNrReuniao": 45654,
                "stEstado": 1,
                "dtEnvio": "2019-01-23",
                "stStatusAtual": "proponente"
            }


### Atualizar dados readequação [POST]

+ Request (multipart/form-data; boundary=BOUNDARY)

        --BOUNDARY
        Content-Disposition: form-data; name="idReadequacao"

        15125
        --BOUNDARY
        Content-Disposition: form-data; name="dsSolicitacao"

        Porque sim, eu quero!
        --BOUNDARY
        Content-Disposition: form-data; name="dsJustificativa"

        Porque é necessário.
        --BOUNDARY
        Content-Disposition: form-data; name="idAvaliador"

        236
        --BOUNDARY
        Content-Disposition: form-data; name="dsAvaliacao"

        --BOUNDARY
        Content-Disposition: form-data; name="stAcao"

        Aprovado!
        --BOUNDARY
        Content-Disposition: form-data; name="documento"; filename="file.pdf"
        Content-Type: application/pdf
        Content-Transfer-Encoding: base64

        [BINARY CODE]
        --BOUNDARY


+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                "idPronac": 217336,
                "idReadequacao": 15128,
                "idTipoReadequacao": 6,
                "dtSolicitacao": "2019-01-22",
                "idSolicitante": 267,
                "dsNomeSolicitante": "Leôncio das Neves",
                "dsSolicitacao": "blabalbalbalablabalb",
                "dsJustificativa": "É necessário",
                "idDocumento": 19440,
                "idAvaliador": 335,
                "dtAvaliador": "2019-02-03",
                "dsAvaliacao": "queuqeuqueuq",
                "stAtendimento": "N",
                "siEncaminhamento": 15,
                "idNrReuniao": 45654,
                "stEstado": 1,
                "dtEnvio": "2019-01-23",
                "stStatusAtual": "proponente"
            }

### Excluir readequação [DELETE]

+ Parameters
    + idReadequacao (string, required) - ID da Readequação

+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                "mensagem": "Readequação removida com sucesso!"
            }

## Readequacao - Visualizar tipos de Readequação disponíveis para criação por Pronac [/readequacao/tipos-disponiveis?idPronac={idPronac}]

+ Parameters
    + idPronac (string, required)

### Visualizar tipos de Readequação disponíveis para criação por Pronac [GET]

+ Request
    + Attributes
        + idPronac: 141001

+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                "data": {
                    "code": 200,
                    "items": [
                        {
                            "idTipoReadequacao": 3,
                            "descricao": "Razão Social"
                        },
                        {
                            "idTipoReadequacao": 7,
                            "descricao": "Especificação Técnica"
                        },
                        {
                            "idTipoReadequacao": 16,
                            "descricao": "Objetivos"
                        }
                    ]
                }
            }


## Readequacao - Buscar campos por tipo readequação [/readequacao/campo-atual?idPronac=217336&idTipoReadequacao=12]

### Buscar campos por tipo readequação - nome do projeto [GET]

+ Parameters
    + idPronac: 217336 (number, required)
    + idTipoReadequacao: 12 (number, required)

+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                "data": {
                    "code": 200,
                    "items": [
                        {
                            "idTipoReadequacao": "12",
                            "descricao": "Nome do Projeto",
                            "tpCampo": "input",
                            "dsCampo": "19o. Gramado Cine Video"
                        }
                    ]
                }
            }

## Readequacao - Buscar campos por tipo readequação [/readequacao/campo-atual?idPronac=217336&idTipoReadequacao=2]

### Buscar campos por tipo readequação - planilha orçamentária [GET]

+ Parameters
    + idPronac: 217336 (number, required)
    + idTipoReadequacao: 2 (number, required)

+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                "data": {
                    "code": 200,
                    "items": [
                        {
                            "idTipoReadequacao": "2",
                            "descricao": "Planilha Orçamentária",
                            "tpCampo": "planilha_orcamentaria",
                            "dsCampo": ""
                        }
                    ]
                }
            }

## Readequacao - Buscar campos por tipo readequação [/readequacao/campo-atual?idPronac=217336&idTipoReadequacao=10]

### Buscar campos por tipo readequação - alteração de proponente[GET]

+ Parameters
    + idPronac: 217336 (number, required)
    + idTipoReadequacao: 10 (number, required)

+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                "data": {
                    "code": 200,
                    "items": [
                        {
                            "idTipoReadequacao": "10",
                            "descricao": "Alteração de Proponente",
                            "tpCampo": "input",
                            "dsCampo": "22344355678"
                        }
                    ]
                }
            }


## Readequacao - Buscar campos por tipo readequação [/readequacao/campo-atual?idPronac=217336&idTipoReadequacao=6]

### Buscar campos por tipo readequação - impacto ambiental [GET]

+ Parameters
    + idPronac: 217336 (number, required)
    + idTipoReadequacao: 6 (number, required)

+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                "data": {
                    "code": 200,
                    "items": [
                        {
                            "idTipoReadequacao": "6",
                            "descricao": "Impacto ambiental",
                            "tpCampo": "textarea",
                            "dsCampo": "A independência de adubação e correção anual do solo dá-se principalmente pelo manejo de podas e com a cobertura de solo, que além de produzir uma terra de qualidade química, física e biologicamente falando, retém água, matéria orgânica, acaba com problemas de erosão e promove a infiltração de água (poupança de água) e a recarga dos lençóis freáticos. <br/> A biodiversidade promove o equilíbrio biológico e elimina a necessidade de aplicação de defensivos químicos (agrotóxicos). <br/>As condições climáticas do local de plantio (microclima) favorecem a saúde das plantas, não as expondo a estresses por excesso de insolação, ventos e variações bruscas de temperatura. E ainda a evapotranspiração das plantas promove a chuva.<br/><br/>Aqui está nossa vocação como um país florestal. Nação da abundância de água e biodiversidade. A oportunidade de geração de renda e valor para todo o mundo."
                        }
                    ]
                }
            }

## Readequacao - Buscar campos por tipo readequação [/readequacao/campo-atual?idPronac=217336&idTipoReadequacao=13]

### Buscar campos por tipo readequação - período de execução [GET]

+ Parameters
    + idPronac: 217336 (number, required)
    + idTipoReadequacao: 10 (number, required)

+ Response 200 (application/json; charset=utf-8)

    + Body


            {
                "data": {
                    "code": 200,
                    "items": [
                        {
                            "idTipoReadequacao": "13",
                            "descricao": "Período de Execução",
                            "tpCampo": "date",
                            "dsCampo": "2019-06-01 00:00:00"
                        }
                    ]
                }
            }

## Readequação - Documento [/readequacao/{idReadequacao}/documento]

+ Parameters
    + idReadequacao: 15122 (number, required)

### Remover documento de uma readequação [DELETE]

+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                "mensagem": "Arquivo removido com sucesso!"
            }

## Readequação - Saldo: disponível para edição de item [/readequacao/saldo-disponivel-edicao-item/{idPronac}]

### Verifica se está disponível para editar item [GET]

+ Parameters
    + idPronac: 217336 (number, required)

+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                "disponivelEdicaoItem": "true"
            }

## Readequação - Finaliza readequação [/readequacao/finalizar?idReadequacao={idReadequacao}]

### Finaliza readequação e envia para análise [POST]

+ Parameters
    + idReadequacao: 15213 (number, required)

+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                "mensagem": "Readequação enviada para análise."
            }

## Readequação - solicitar uso do saldo [/readequacao/solicitar-saldo/{idPronac}]

### Solicita uso do saldo [GET]

+ Parameters
    + idPronac: 217336 (number, required)

+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                    "idPronac": 217336,
                    "idReadequacao": 15128,
                    "idTipoReadequacao": 22,
                    "dsTipoReadequacao": "Saldo de aplicação",
                    "dtSolicitacao": "2019-01-22",
                    "idSolicitante": 267,
                    "dsNomeSolicitante": "Leôncio das Neves",
                    "dsSolicitacao": "199533,00",
                    "dsJustificativa": "É necessário",
                    "idDocumento": 19440,
                    "idAvaliador": 335,
                    "dtAvaliador": "2019-02-03",
                    "dsAvaliacao": "queuqeuqueuq",
                    "stAtendimento": "N",
                    "siEncaminhamento": 15,
                    "idNrReuniao": 45654,
                    "stEstado": 1,
                    "dtEnvio": "2019-01-23",
                    "stStatusAtual": "proponente"
            }

## Readequação - Obter planilha [/readequacao/obter-planilha=2116336&idTipoReadequacao=22]

### Solicita planilha [GET]

+ Parameters
    + idPronac: 217336 (number, required)
    + idTipoReadequacao: 22 (number, required)

+ Response 200 (application/json; charset=utf-8)

    + Body

        {
          "items": [
            {
                "tpPlanilha": "CO",
                "dtPlanilha": "2019-05-16 14:50:17",
                "idPronac": 216611,
                "idProduto": 1,
                "dsProduto": "Livro",
                "idReadequacao": 19221,
                "idEtapa": 2,
                "dsEtapa": "Produção / execução",
                "idPlanilhaItem": 101,
                "dsItem": "Ilustração",
                "idUnidade": 23,
                "dsUnidade": "Mês"
                "qtItem": 5,
                "nrOcorrencia": 4,
                "vlUnitario": 335151.33,
                "qtDias": 10,
                "tpDespesa": 0,
                "tpPessoa": 0,
                "nrContraPartida": 0,
                "nrFonteRecurso": 109,
                "idUFDespesa": 35,
                "idMunicipioDespesa": 355030,
                "dsJustificativa": "Remanejado por isso e aquilo",
                "idAgente": 3466,
                "StAtivo" : "S",
            }
          ]
        }

## Readequação - Obter unidades [/readequacao/planilha-obter-unidades?idPronac={idPronac}]

### Obter unidades - usadas na edição dos itens de planilha
+ Parameters
    + idPronac: 217336 (number, required)

+ Response 200 (application/json; charset=utf-8)

    + Body

        {
          "items": [
            {
                "idUnidade": 25,
                "Sigla": "CH",
                "Descricao": "Cach\u00ea"
            }, {
                "idUnidade": 5,
                "Sigla": "D",
                "Descricao": "Dia"
            }, {
                "idUnidade": 11,
                "Sigla": "filme",
                "Descricao": "Filme"
            }, {
                "idUnidade": 4,
                "Sigla": "FL",
                "Descricao": "Folha"
            }, {
                "idUnidade": 8,
                "Sigla": "H",
                "Descricao": "Hora"
            }, {
                "idUnidade": 19,
                "Sigla": "instal",
                "Descricao": "Instala\u00e7\u00e3o"
            }, {
                "idUnidade": 20,
                "Sigla": "Kg",
                "Descricao": "Kilograma"
            }, {
                "idUnidade": 22,
                "Sigla": "Kg\/m2",
                "Descricao": "Kilograma \/ metro 2"
            }, {
                "idUnidade": 23,
                "Sigla": "mes",
                "Descricao": "M\u00eas"
            }, {
                "idUnidade": 9,
                "Sigla": "M",
                "Descricao": "Metro"
            }, {
                "idUnidade": 16,
                "Sigla": "m2",
                "Descricao": "Metro 2"
            }, {
                "idUnidade": 17,
                "Sigla": "m3",
                "Descricao": "Metro 3"
            }, {
                "idUnidade": 18,
                "Sigla": "m3\/Km",
                "Descricao": "Metro 3 \/ Km"
            }, {
                "idUnidade": 12,
                "Sigla": "min",
                "Descricao": "Minuto"
            }, {
                "idUnidade": 1,
                "Sigla": "N\u00e3o",
                "Descricao": "N\u00e3o Informado"
            }, {
                "idUnidade": 2,
                "Sigla": "Obra",
                "Descricao": "Obra"
            }, {
                "idUnidade": 13,
                "Sigla": "parte",
                "Descricao": "Parte"
            }, {
                "idUnidade": 10,
                "Sigla": "per",
                "Descricao": "Per\u00edodo"
            }, {
                "idUnidade": 15,
                "Sigla": "projet",
                "Descricao": "Projeto"
            }, {
                "idUnidade": 6,
                "Sigla": "RL",
                "Descricao": "Rolo"
            }
          ]
        }

## Readequação - Atualizar item planilha [/readequacao/item-planilha]

### Altera item de planilha [POST]

+ Parameters
    + idReadequacao: 15213 (number, required)
    + idPlanilhaItem: 153 (number, required)
    + idPlanilhaAprovacao: 2315213 (number, required)
    + idPronac: 205213 (number, required)
    + dsJustificativa: "Alteração do item tal, alterando valor unitário e quantidade." (string, required)
    + idUnidade: 213 (number, required)
    + idFonte: 109 (number, required)
    + Ocorrencia: 5 (number, required)
    + Quantidade: 15 (number, required)
    + QtdeDias: 205213 (number, required)
    + ValorUnitario: 3613.50 (number, required)
    + idTipoReadequacao: 22 (number, required)
    

+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                "mensagem": "Item atualizado."
            }


## Readequação - calcular resumo da planilha [/readequacao/calcular-resumo-planilha]

### Executa cálculos do resumo da planilha [GET]

+ Parameters
    + idPronac: 217336 (number, required)
    + idTipoReadequacao: 22 (number, required)

+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                "saldoDeclarado": 150636.50,
                "saldoValorUtilizado": 1220.00,
                "valorTotalDisponivelParaUso": -132.24,
                "statusPlanilha": "negativo",
                "PlanilhaReadequadaTotal": 63330.55,
                "PlanilhaAtivaTotal": 64444.55
                
            }

## Readequação - Reverter alteração de item [/readequacao/reverter-alteracao-item]

### Reverte alteração de item de planilha [POST]

+ Parameters
    + idReadequacao: 15213 (number, required)
    + idPlanilhaItem: 153 (number, required)
    + idPronac: 205213 (number, required)
    + idTipoReadequacao: 22 (number, required)
    

+ Response 200 (application/json; charset=utf-8)

    + Body

            {
                "mensagem": "Dados do item revertidos!"
            }
