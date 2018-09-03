<template>
    <div>
        <v-data-table
            :items="consolidacaoItems"
            hide-headers
            hide-actions
            item-key="title"
        >
            <template slot="items" slot-scope="props">
                <tr @click="props.expanded = !props.expanded">
                    <td>{{ props.item.title }}</td>
                </tr>
            </template>

            <template slot="expand" slot-scope="props">
                <!-- CRIAR TABELA -->
            </template>
        </v-data-table>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Modal from '@/components/modal';

export default {
    name: 'ConsolidacaoAnalise',
    data() {
        return {
            consolidacao: {
                "consolidacaoPorProduto":{
                    "lines":[
                        {
                            "dsProduto":"Administra&ccedil;&atilde;o do Projeto",
                            "qtComprovantes":"158",
                            "vlComprovado":"134.111,02",
                            "PercComprovado":"3,33"
                        },
                        {
                            "dsProduto":"Bem Imóvel - Restauração / Preservação",
                            "qtComprovantes":"1.748",
                            "vlComprovado":"3.894.555,28",
                            "PercComprovado":"96,67"
                        }
                    ],
                    "cols":{
                        "dsProduto":{
                            "name":"Produto",
                            "class":""
                        },
                        "qtComprovantes":{
                            "name":"Qtde. Comprovantes",
                            "class":"right-align"
                        },
                        "vlComprovado":{
                            "name":"Valor Comprovado",
                            "class":"right-align"
                        },
                        "PercComprovado":{
                            "name":"% Comprovado",
                            "class":"right-align"
                        }
                    },
                    "title":"COMPROVAÇÃO CONSOLIDADA POR PRODUTO",
                    "tfoot":{
                        "qtComprovantes":1906,
                        "vlComprovado":"4.028.666,30",
                        "dsProduto":"Total"
                    }
                },
                "consolidadoPorEtapa":{
                    "lines":[
                        {
                            "Descricao":"Pré-Produção",
                            "qtComprovantes":"1",
                            "vlComprovado":"6.507,07",
                            "PercComprovado":"0,16"
                        },
                        {
                            "Descricao":"Produção",
                            "qtComprovantes":"1.655",
                            "vlComprovado":"3.525.280,28",
                            "PercComprovado":"87,50"
                        },
                        {
                            "Descricao":"Divulgação / Comercialização",
                            "qtComprovantes":"92",
                            "vlComprovado":"362.767,93",
                            "PercComprovado":"9,00"
                        },
                        {
                            "Descricao":"Recolhimentos",
                            "qtComprovantes":"4",
                            "vlComprovado":"2.320,00",
                            "PercComprovado":"0,06"
                        },
                        {
                            "Descricao":"Custos / Administrativos",
                            "qtComprovantes":"154",
                            "vlComprovado":"131.791,02",
                            "PercComprovado":"3,27"
                        }
                    ],
                    "cols":{
                        "Descricao":{
                            "name":"Etapa",
                            "class":"left-align"
                        },
                        "qtComprovantes":{
                            "name":"Qtde. Comprovantes",
                            "class":"right-align"
                        },
                        "vlComprovado":{
                            "name":"Valor Comprovado",
                            "class":"right-align"
                        },
                        "PercComprovado":{
                            "name":"% Comprovado",
                            "class":"right-align"
                        }
                    },
                    "title":"COMPROVAÇÃO CONSOLIDADA POR ETAPA",
                    "tfoot":{
                        "qtComprovantes":1906,
                        "vlComprovado":"4.028.666,30",
                        "Descricao":"Total"
                    }
                },
                "maioresItensComprovados":{
                    "lines":[
                        {
                            "Descricao":"Pinturas",
                            "qtComprovantes":"203",
                            "vlComprovado":"677.674,43",
                            "PercComprovado":"16,82"
                        },
                        {
                            "Descricao":"Montagem e desmontagem",
                            "qtComprovantes":"101",
                            "vlComprovado":"649.662,86",
                            "PercComprovado":"16,13"
                        },
                        {
                            "Descricao":"Reparo nos elementos arquitetônicos das fachadas",
                            "qtComprovantes":"34",
                            "vlComprovado":"182.630,36",
                            "PercComprovado":"4,53"
                        },
                        {
                            "Descricao":"Mídia Televisiva",
                            "qtComprovantes":"18",
                            "vlComprovado":"171.890,40",
                            "PercComprovado":"4,27"
                        },
                        {
                            "Descricao":"Impermeabilizações/Tratamentos",
                            "qtComprovantes":"68",
                            "vlComprovado":"171.137,32",
                            "PercComprovado":"4,25"
                        },
                        {
                            "Descricao":"Arquiteto/engenheiro",
                            "qtComprovantes":"34",
                            "vlComprovado":"162.900,00",
                            "PercComprovado":"4,04"
                        },
                        {
                            "Descricao":"Recuperação de estrutura de madeira de telhado cerâmico",
                            "qtComprovantes":"55",
                            "vlComprovado":"154.138,44",
                            "PercComprovado":"3,83"
                        },
                        {
                            "Descricao":"Mestre de Obra",
                            "qtComprovantes":"17",
                            "vlComprovado":"145.080,00",
                            "PercComprovado":"3,60"
                        },
                        {
                            "Descricao":"Execução das janelas",
                            "qtComprovantes":"50",
                            "vlComprovado":"139.959,30",
                            "PercComprovado":"3,47"
                        },
                        {
                            "Descricao":"Revestimentos",
                            "qtComprovantes":"50",
                            "vlComprovado":"91.370,68",
                            "PercComprovado":"2,27"
                        },
                        {
                            "Descricao":"Técnico em segurança do trabalho",
                            "qtComprovantes":"17",
                            "vlComprovado":"88.920,00",
                            "PercComprovado":"2,21"
                        },
                        {
                            "Descricao":"Aplicação de produtos químicos",
                            "qtComprovantes":"40",
                            "vlComprovado":"87.926,82",
                            "PercComprovado":"2,18"
                        },
                        {
                            "Descricao":"Venezianas",
                            "qtComprovantes":"120",
                            "vlComprovado":"85.215,28",
                            "PercComprovado":"2,12"
                        },
                        {
                            "Descricao":"Proteção a transeuntes",
                            "qtComprovantes":"14",
                            "vlComprovado":"81.782,41",
                            "PercComprovado":"2,03"
                        },
                        {
                            "Descricao":"Poliuretano",
                            "qtComprovantes":"14",
                            "vlComprovado":"76.635,00",
                            "PercComprovado":"1,90"
                        },
                        {
                            "Descricao":"Mídia radiofônica",
                            "qtComprovantes":"32",
                            "vlComprovado":"76.433,14",
                            "PercComprovado":"1,90"
                        },
                        {
                            "Descricao":"Impressão",
                            "qtComprovantes":"20",
                            "vlComprovado":"76.110,34",
                            "PercComprovado":"1,89"
                        },
                        {
                            "Descricao":"Almoxarife/apontador",
                            "qtComprovantes":"17",
                            "vlComprovado":"74.880,00",
                            "PercComprovado":"1,86"
                        },
                        {
                            "Descricao":"Remoção e Recolocação",
                            "qtComprovantes":"113",
                            "vlComprovado":"73.943,40",
                            "PercComprovado":"1,84"
                        },
                        {
                            "Descricao":"Transporte de material",
                            "qtComprovantes":"147",
                            "vlComprovado":"69.892,97",
                            "PercComprovado":"1,73"
                        },
                        {
                            "Descricao":"Limpeza com hidrojateamento sob pressão controlada, escovação e detergente neutro",
                            "qtComprovantes":"42",
                            "vlComprovado":"58.976,04",
                            "PercComprovado":"1,46"
                        },
                        {
                            "Descricao":"Coordenador do Projeto",
                            "qtComprovantes":"16",
                            "vlComprovado":"54.000,00",
                            "PercComprovado":"1,34"
                        },
                        {
                            "Descricao":"Vidros",
                            "qtComprovantes":"107",
                            "vlComprovado":"50.061,62",
                            "PercComprovado":"1,24"
                        },
                        {
                            "Descricao":"Tela de proteção da obra",
                            "qtComprovantes":"36",
                            "vlComprovado":"48.088,05",
                            "PercComprovado":"1,19"
                        },
                        {
                            "Descricao":"Janelas de madeira e ferragens",
                            "qtComprovantes":"9",
                            "vlComprovado":"42.332,92",
                            "PercComprovado":"1,05"
                        },
                        {
                            "Descricao":"Piso em granito",
                            "qtComprovantes":"30",
                            "vlComprovado":"31.478,54",
                            "PercComprovado":"0,78"
                        },
                        {
                            "Descricao":"Assessoria de Comunicação",
                            "qtComprovantes":"17",
                            "vlComprovado":"27.000,00",
                            "PercComprovado":"0,67"
                        },
                        {
                            "Descricao":"Vãos - Quadros e Vedações",
                            "qtComprovantes":"56",
                            "vlComprovado":"25.706,37",
                            "PercComprovado":"0,64"
                        },
                        {
                            "Descricao":"Outdoors",
                            "qtComprovantes":"11",
                            "vlComprovado":"24.791,96",
                            "PercComprovado":"0,62"
                        },
                        {
                            "Descricao":"Guincho para elevador",
                            "qtComprovantes":"17",
                            "vlComprovado":"23.450,00",
                            "PercComprovado":"0,58"
                        }
                    ],
                    "cols":{
                        "Descricao":{
                            "name":"Item Orçamentario"
                        },
                        "qtComprovantes":{
                            "name":"Qtde. Comprovantes",
                            "class":"right-align"
                        },
                        "vlComprovado":{
                            "name":"Valor Comprovado",
                            "class":"right-align"
                        },
                        "PercComprovado":{
                            "name":"% Comprovado",
                            "class":"right-align"
                        }
                    },
                    "title":"MAIORES ITENS ORÇAMENTARIOS COMPROVADOS",
                    "tfoot":{
                        "qtComprovantes":1505,
                        "vlComprovado":"3.724.068,65",
                        "Descricao":"Total"
                    }
                },
                "comprovacaoConsolidadaUfMunicipio":{
                    "lines":[
                        {
                            "UF":"RS",
                            "qtComprovantes":"1.906",
                            "Municipio":"Porto Alegre",
                            "vlComprovado":"4.028.666,30",
                            "PercComprovado":"100,00"
                        }
                    ],
                    "cols":{
                        "UF":{
                            "name":"UF"
                        },
                        "qtComprovantes":{
                            "name":"Qtde. Comprovantes",
                            "class":"right-align"
                        },
                        "Municipio":{
                            "name":"Municipio",
                            "class":"center-align"
                        },
                        "vlComprovado":{
                            "name":"Valor Comprovado",
                            "class":"right-align"
                        },
                        "PercComprovado":{
                            "name":"% Comprovado",
                            "class":"right-align"
                        }
                    },
                    "title":"COMPROVAÇÃO CONSOLIDADA POR UF E MUNICIPIO",
                    "tfoot":{
                        "qtComprovantes":1906,
                        "vlComprovado":"4.028.666,30",
                        "UF":"Total"
                    }
                },
                "maioresComprovacaoTipoDocumento":{
                    "lines":[
                        {
                            "tpDocumento":"Nota Fiscal/Fatura",
                            "nrComprovante":"627",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"144",
                            "vlComprovado":"401.471,77",
                            "PercComprovado":"9,97"
                        },
                        {
                            "tpDocumento":"Nota Fiscal/Fatura",
                            "nrComprovante":"613",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"148",
                            "vlComprovado":"339.208,12",
                            "PercComprovado":"8,42"
                        },
                        {
                            "tpDocumento":"Nota Fiscal/Fatura",
                            "nrComprovante":"618",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"122",
                            "vlComprovado":"308.363,72",
                            "PercComprovado":"7,65"
                        },
                        {
                            "tpDocumento":"Nota Fiscal/Fatura",
                            "nrComprovante":"605",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"119",
                            "vlComprovado":"250.097,08",
                            "PercComprovado":"6,21"
                        },
                        {
                            "tpDocumento":"Nota Fiscal/Fatura",
                            "nrComprovante":"584",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"106",
                            "vlComprovado":"244.963,19",
                            "PercComprovado":"6,08"
                        },
                        {
                            "tpDocumento":"Nota Fiscal/Fatura",
                            "nrComprovante":"567",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"101",
                            "vlComprovado":"210.721,70",
                            "PercComprovado":"5,23"
                        },
                        {
                            "tpDocumento":"Nota Fiscal/Fatura",
                            "nrComprovante":"588",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"88",
                            "vlComprovado":"190.009,13",
                            "PercComprovado":"4,72"
                        },
                        {
                            "tpDocumento":"Nota Fiscal/Fatura",
                            "nrComprovante":"541",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"71",
                            "vlComprovado":"179.556,23",
                            "PercComprovado":"4,46"
                        },
                        {
                            "tpDocumento":"Nota Fiscal/Fatura",
                            "nrComprovante":"577",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"73",
                            "vlComprovado":"170.466,11",
                            "PercComprovado":"4,23"
                        },
                        {
                            "tpDocumento":"Nota Fiscal/Fatura",
                            "nrComprovante":"595",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"103",
                            "vlComprovado":"153.941,94",
                            "PercComprovado":"3,82"
                        }
                    ],
                    "cols":{
                        "tpDocumento":{
                            "name":"Tipo Documento"
                        },
                        "nrComprovante":{
                            "name":"Nr. Comprovante"
                        },
                        "nmFornecedor":{
                            "name":"Fornecedor"
                        },
                        "qtComprovacoes":{
                            "name":"Qtde. Comprovantes",
                            "class":"right-align"
                        },
                        "vlComprovado":{
                            "name":"Valor Comprovado",
                            "class":"right-align"
                        },
                        "PercComprovado":{
                            "name":"% Comprovado",
                            "class":"right-align"
                        }
                    },
                    "title":"MAIORES COMPROVAÇÕES POR TIPO DE DOCUMENTOS COMPROBATÓRIOS",
                    "tfoot":{
                        "qtComprovacoes":"1.075",
                        "vlComprovado":"2.448.798,99",
                        "tpDocumento":"Total"
                    }
                },
                "comprovacaoTipoDocumentoPagamento":{
                    "lines":[
                        {
                            "tpFormaDePagamento":"Cheque",
                            "nrDocumentoDePagamento":"850274",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"144",
                            "vlComprovado":"401.471,77",
                            "PercComprovado":"9,97"
                        },
                        {
                            "tpFormaDePagamento":"Cheque",
                            "nrDocumentoDePagamento":"850253",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"147",
                            "vlComprovado":"339.108,12",
                            "PercComprovado":"8,42"
                        },
                        {
                            "tpFormaDePagamento":"Cheque",
                            "nrDocumentoDePagamento":"850262",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"122",
                            "vlComprovado":"308.363,72",
                            "PercComprovado":"7,65"
                        },
                        {
                            "tpFormaDePagamento":"Cheque",
                            "nrDocumentoDePagamento":"850232",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"118",
                            "vlComprovado":"249.991,65",
                            "PercComprovado":"6,21"
                        },
                        {
                            "tpFormaDePagamento":"Cheque",
                            "nrDocumentoDePagamento":"850171",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"107",
                            "vlComprovado":"245.060,71",
                            "PercComprovado":"6,08"
                        },
                        {
                            "tpFormaDePagamento":"Cheque",
                            "nrDocumentoDePagamento":"850142",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"101",
                            "vlComprovado":"210.721,70",
                            "PercComprovado":"5,23"
                        },
                        {
                            "tpFormaDePagamento":"Cheque",
                            "nrDocumentoDePagamento":"850179",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"89",
                            "vlComprovado":"193.023,92",
                            "PercComprovado":"4,79"
                        },
                        {
                            "tpFormaDePagamento":"Cheque",
                            "nrDocumentoDePagamento":"850119",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"77",
                            "vlComprovado":"184.234,77",
                            "PercComprovado":"4,57"
                        },
                        {
                            "tpFormaDePagamento":"Cheque",
                            "nrDocumentoDePagamento":"850160",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"73",
                            "vlComprovado":"170.466,11",
                            "PercComprovado":"4,23"
                        },
                        {
                            "tpFormaDePagamento":"Cheque",
                            "nrDocumentoDePagamento":"850201",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"89",
                            "vlComprovado":"151.798,89",
                            "PercComprovado":"3,77"
                        }
                    ],
                    "cols":{
                        "tpFormaDePagamento":{
                            "name":"Tipo Documento"
                        },
                        "nrDocumentoDePagamento":{
                            "name":"Nr. Comprovante"
                        },
                        "nmFornecedor":{
                            "name":"Fonecedor"
                        },
                        "qtComprovacoes":{
                            "name":"Qtde. Comprovantes",
                            "class":"right-align"
                        },
                        "vlComprovado":{
                            "name":"Valor Comprovado",
                            "class":"right-align"
                        },
                        "PercComprovado":{
                            "name":"% Comprovado",
                            "class":"right-align"
                        }
                    },
                    "title":"MAIORES COMPROVAÇÕES POR TIPO DE DOCUMENTOS DE PAGAMENTO",
                    "tfoot":{
                        "qtComprovacoes":1067,
                        "vlComprovado":"2.454.241,36",
                        "tpFormaDePagamento":"Total"
                    }
                },
                "maioresFornecedoresProjeto":{
                    "lines":[
                        {
                            "nrCNPJCPF":"06.939.632/0001-00",
                            "nmFornecedor":"Arquium Construções e Restauro Ltda.",
                            "qtComprovacoes":"1.640",
                            "vlComprovado":"3.477.787,35",
                            "PercComprovado":"86,33"
                        },
                        {
                            "nrCNPJCPF":"88.616.289/0001-19",
                            "nmFornecedor":"CPL - CENTRO DE PROPAGANDA LTDA.",
                            "qtComprovacoes":"43",
                            "vlComprovado":"73.337,83",
                            "PercComprovado":"1,82"
                        },
                        {
                            "nrCNPJCPF":"00.325.903/0001-42",
                            "nmFornecedor":"Turning Point Produções Ltda.",
                            "qtComprovacoes":"1",
                            "vlComprovado":"64.137,00",
                            "PercComprovado":"1,59"
                        },
                        {
                            "nrCNPJCPF":"90.366.725/0001-90",
                            "nmFornecedor":"Associação dos Amigos da Casa de Cultura Mário Quintana",
                            "qtComprovacoes":"16",
                            "vlComprovado":"54.000,00",
                            "PercComprovado":"1,34"
                        },
                        {
                            "nrCNPJCPF":"68.737.857/0002-03",
                            "nmFornecedor":"RBS - Participações S/A",
                            "qtComprovacoes":"1",
                            "vlComprovado":"51.437,52",
                            "PercComprovado":"1,28"
                        },
                        {
                            "nrCNPJCPF":"93.791.416/0001-56",
                            "nmFornecedor":"Estúdio 5 Arquitetos Ltda.",
                            "qtComprovacoes":"17",
                            "vlComprovado":"34.200,00",
                            "PercComprovado":"0,85"
                        },
                        {
                            "nrCNPJCPF":"87.209.250/0001-14",
                            "nmFornecedor":"RÁDIO E TV PORTOVISÃO LTDA",
                            "qtComprovacoes":"9",
                            "vlComprovado":"33.647,76",
                            "PercComprovado":"0,84"
                        },
                        {
                            "nrCNPJCPF":"14.152.256/0001-29",
                            "nmFornecedor":"Maristela Bairros Schmidt",
                            "qtComprovacoes":"17",
                            "vlComprovado":"27.000,00",
                            "PercComprovado":"0,67"
                        },
                        {
                            "nrCNPJCPF":"92.821.701/0001-00",
                            "nmFornecedor":"Zero Hora Editora Jornalística S/A",
                            "qtComprovacoes":"2",
                            "vlComprovado":"21.543,08",
                            "PercComprovado":"0,53"
                        },
                        {
                            "nrCNPJCPF":"92.757.798/0001-39",
                            "nmFornecedor":"EMPRESA JORNALISTICA CALDAS JUNIOR LTDA",
                            "qtComprovacoes":"4",
                            "vlComprovado":"19.028,74",
                            "PercComprovado":"0,47"
                        },
                        {
                            "nrCNPJCPF":"04.183.461/0001-06",
                            "nmFornecedor":"Gusmão & kirsch Consultores Ltda.",
                            "qtComprovacoes":"18",
                            "vlComprovado":"18.000,00",
                            "PercComprovado":"0,45"
                        },
                        {
                            "nrCNPJCPF":"09.396.528/0001-04",
                            "nmFornecedor":"Portosul Assessoria Contábil Ltda.",
                            "qtComprovacoes":"16",
                            "vlComprovado":"18.000,00",
                            "PercComprovado":"0,45"
                        },
                        {
                            "nrCNPJCPF":"87.091.641/0001-87",
                            "nmFornecedor":"LZ Comunicação Visual Ltda",
                            "qtComprovacoes":"6",
                            "vlComprovado":"15.010,00",
                            "PercComprovado":"0,37"
                        },
                        {
                            "nrCNPJCPF":"292.518.180-53",
                            "nmFornecedor":"Vanessa Maria Ferreira Dutra",
                            "qtComprovacoes":"8",
                            "vlComprovado":"13.920,00",
                            "PercComprovado":"0,35"
                        },
                        {
                            "nrCNPJCPF":"92.662.139/0001-19",
                            "nmFornecedor":"Rádio Guaíba ltda.",
                            "qtComprovacoes":"2",
                            "vlComprovado":"13.224,96",
                            "PercComprovado":"0,33"
                        },
                        {
                            "nrCNPJCPF":"60.509.239/0006-28",
                            "nmFornecedor":"Rádio e Televisão Bandeirantes Ltda.",
                            "qtComprovacoes":"3",
                            "vlComprovado":"11.062,40",
                            "PercComprovado":"0,27"
                        },
                        {
                            "nrCNPJCPF":"10.538.641/0001-58",
                            "nmFornecedor":"Maria Viola Música Ltda.",
                            "qtComprovacoes":"3",
                            "vlComprovado":"11.050,00",
                            "PercComprovado":"0,27"
                        },
                        {
                            "nrCNPJCPF":"89.972.988/0001-64",
                            "nmFornecedor":"Rádio Itapema FM de Porto Alegre Ltda",
                            "qtComprovacoes":"4",
                            "vlComprovado":"9.708,40",
                            "PercComprovado":"0,24"
                        },
                        {
                            "nrCNPJCPF":"08.038.590/0001-53",
                            "nmFornecedor":"IES TECNOLOGIA EM COMUNICAÇÃO LTDA.",
                            "qtComprovacoes":"2",
                            "vlComprovado":"8.600,00",
                            "PercComprovado":"0,21"
                        },
                        {
                            "nrCNPJCPF":"93.049.245/0002-75",
                            "nmFornecedor":"RBS - Empresa de TV Ltda.",
                            "qtComprovacoes":"2",
                            "vlComprovado":"7.548,00",
                            "PercComprovado":"0,19"
                        }
                    ],
                    "cols":{
                        "nrCNPJCPF":{
                            "name":"CNPJ/CPF"
                        },
                        "nmFornecedor":{
                            "name":"Fornecedor"
                        },
                        "qtComprovacoes":{
                            "name":"Qtde. Comprovações",
                            "class":"right-align"
                        },
                        "vlComprovado":{
                            "name":"Valor Comprovado",
                            "class":"right-align"
                        },
                        "PercComprovado":{
                            "name":"% Comprovado",
                            "class":"right-align"
                        }
                    },
                    "title":"MAIORES FORNECEDORES DO PROJETO",
                    "tfoot":{
                        "qtComprovacoes":"2.881",
                        "vlComprovado":"3.982.245,49",
                        "tpFormaDePagamento":"Total",
                        "nrCNPJCPF":"Total"
                    }
                },
                "fornecedorItemProjeto":{
                    "lines":[
                        {
                            "nrCNPJCPF":"90.366.725/0001-90",
                            "nmFornecedor":"Associação dos Amigos da Casa de Cultura Mário Quintana",
                            "Etapa":"Produção",
                            "vlComprovado":"54.000,00",
                            "PercComprovado":"1,34"
                        }
                    ],
                    "cols":{
                        "nrCNPJCPF":{
                            "name":"CNPJ/CPF"
                        },
                        "nmFornecedor":{
                            "name":"Fornecedor"
                        },
                        "Etapa":{
                            "name":"Etapa"
                        },
                        "vlComprovado":{
                            "name":"Valor Comprovado",
                            "class":"right-align"
                        },
                        "PercComprovado":{
                            "name":"% Comprovado",
                            "class":"right-align"
                        }
                    },
                    "title":"PROPONENTE FORNECEDOR DE ITEM PARA O PROJETO",
                    "tfoot":{
                        "qtComprovacoes":18.881,
                        "vlComprovado":"54.003,98",
                        "tpFormaDePagamento":"Total",
                        "nrCNPJCPF":"Total"
                    }
                },
                "itensOrcamentariosImpugnados":{
                    "lines":[
                        {
                            "NomeProjeto":"De Hotel a Casa de Todas as Culturas.",
                            "Produto":"Administração do Projeto",
                            "Etapa":"Custos / Administrativos",
                            "Item":"Hospedagem com Alimentação",
                            "Documento":"Guia de Recolhimento",
                            "nrComprovante":"55759",
                            "tpFormaDePagamento":"Cheque",
                            "nrDocumentoDePagamento":"850246",
                            "dsJustificativa":" ",
                            "vlComprovado":"24,00"
                        },
                        {
                            "NomeProjeto":"De Hotel a Casa de Todas as Culturas.",
                            "Produto":"Administração do Projeto",
                            "Etapa":"Custos / Administrativos",
                            "Item":"Hospedagem com Alimentação",
                            "Documento":"Recibo de Pagamento",
                            "nrComprovante":"150920",
                            "tpFormaDePagamento":"Cheque",
                            "nrDocumentoDePagamento":"850234",
                            "dsJustificativa":" ",
                            "vlComprovado":"327,14"
                        },
                        {
                            "NomeProjeto":"De Hotel a Casa de Todas as Culturas.",
                            "Produto":"Administração do Projeto",
                            "Etapa":"Custos / Administrativos",
                            "Item":"Material de consumo",
                            "Documento":"Recibo de Pagamento",
                            "nrComprovante":"1745",
                            "tpFormaDePagamento":"Cheque",
                            "nrDocumentoDePagamento":"850094",
                            "dsJustificativa":" ",
                            "vlComprovado":"116,00"
                        }
                    ],
                    "cols":{
                        "NomeProjeto":{
                            "name":"Projeto"
                        },
                        "Produto":{
                            "name":"Produto"
                        },
                        "Etapa":{
                            "name":"Etapa"
                        },
                        "Item":{
                            "name":"Item"
                        },
                        "Documento":{
                            "name":"Documento"
                        },
                        "nrComprovante":{
                            "name":"Nr. Comprovante"
                        },
                        "tpFormaDePagamento":{
                            "name":"Forma de Pagamento"
                        },
                        "nrDocumentoDePagamento":{
                            "name":"Documento de Pagamento"
                        },
                        "dsJustificativa":{
                            "name":"Justificativa"
                        },
                        "vlComprovado":{
                            "name":"Valor Comprovado",
                            "class":"right-align"
                        }
                    },
                    "title":"ITENS ORÇAMENTÁRIOS IMPUGNADOS NA AVALIAÇÃO FINANCEIRA",
                    "tfoot":{
                        "vlComprovado":"467,14",
                        "NomeProjeto":"Total"
                    }
                }
            }
        }
    },
    computed: {
        consolidacaoItems: function() {
            return Object.values(this.consolidacao);
        }
    }
}
</script>
