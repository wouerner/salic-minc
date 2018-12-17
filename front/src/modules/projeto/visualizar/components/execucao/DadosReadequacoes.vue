<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Carregando Dados das Readequações'"></Carregando>
        </div>
        <div v-else>
            <v-expansion-panel popout focusable>
                <v-expansion-panel-content
                        class="elevation-1"
                        v-for="(dadoAgrupado, index2) in this.gruposReadequacao"
                        :key="index2"
                >
                    <v-layout slot="header" class="primary--text">
                        <v-icon class="mr-3 primary--text">subject</v-icon>
                        <span>{{ index2 }} ({{dadoAgrupado.length}})</span>
                    </v-layout>
                    <v-data-table
                            :headers="headers"
                            :items="dadoAgrupado"
                            class="elevation-1"
                            rows-per-page-text="Items por Página"
                            no-data-text="Nenhum dado encontrado"
                    >
                        <template slot="items" slot-scope="props">
                            <td class="text-xs-right"> {{ props.item.dtSolicitacao | formatarData }}</td>
                            <td class="text-xs-left"> {{ (props.item.stAtendimento === 'I') ? 'Rejeitado' : 'Recebido'}}
                            </td>

                            <td class="text-xs-right"> {{ props.item.dtAvaliacao | formatarData }}</td>
                            <td class="text-xs-left" v-html="props.item.dsAvaliacao"></td>
                            <td class="text-xs-center">
                                <v-btn flat icon>
                                    <v-tooltip bottom>
                                        <v-icon
                                                slot="activator"
                                                @click="showItem(props.item)"
                                                class="material-icons">visibility
                                        </v-icon>
                                        <span>Visualizar Dados das Readequações</span>
                                    </v-tooltip>
                                </v-btn>
                            </td>
                        </template>
                        <template slot="pageText" slot-scope="props">
                            Items {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                        </template>
                    </v-data-table>
                    <v-dialog v-model="dialog" width="90%">
                        <div v-for="(dado, index) in dadoAgrupado" :key="index">
                            <v-card class="elevation-2">
                                <v-card-text class="pl-5">
                                    <v-container fluid>
                                        <div>
                                            <v-flex lg12 dark class="text-xs-center">
                                                <b>SOLICITAÇÃO DO PROPONENTE</b>
                                            </v-flex>
                                            <v-layout row justify-space-between>
                                                <v-card>
                                                    <v-card-text>
                                                        <b>Arquivo</b><br>
                                                        <a
                                                                v-if="dado.idArquivo"
                                                                :href="`/upload/abrir?id=${dado.idArquivo}`"
                                                        >
                                                            <span v-html="dado.nmArquivo"></span>
                                                        </a>
                                                        <span v-else>
                                                          -
                                                        </span>
                                                    </v-card-text>
                                                </v-card>
                                                <v-card>
                                                    <v-card-text>
                                                        <b>Data envio</b>
                                                        <p v-if="dado.dtEnvio">
                                                            {{ dado.dtEnvio | formatarData }}
                                                        </p>
                                                        <p v-else>
                                                             -
                                                        </p>
                                                    </v-card-text>
                                                </v-card>
                                                <v-card>
                                                    <v-card-text>
                                                        <b>Data solicitação</b>
                                                        <p>{{ dado.dtSolicitacao | formatarData }} </p>
                                                    </v-card-text>
                                                </v-card>
                                            </v-layout>
                                            <v-layout row justify-space-between>
                                                <v-card>
                                                    <v-card-text>
                                                        <b>Dados da solicitação</b>
                                                        <p v-html="dado.dsSolicitacao" v-if="dado.dsSolicitacao"></p>
                                                        <p v-else>
                                                             -
                                                        </p>
                                                    </v-card-text>
                                                </v-card>
                                            </v-layout>
                                            <v-layout row justify-space-between>
                                                <v-card>
                                                    <v-card-text>
                                                        <b>Justificativa da solicitação</b>
                                                        <p v-html="dado.dsJustificativa"></p>
                                                    </v-card-text>
                                                </v-card>
                                            </v-layout>
                                        </div>
                                        <br>
                                        <br>
                                        <div v-if="validarAcessoSituacao(dado.siEncaminhamento)">
                                            <v-flex lg12 dark class="text-xs-center">
                                                <b>----------------------------------------------</b>
                                            </v-flex>
                                            <v-layout row justify-space-between>
                                                <v-card>
                                                    <v-card-text>
                                                        <b>Situação</b>
                                                        <p v-if="dado.stAtendimento === 'I'">
                                                            Rejeitado
                                                        </p>
                                                        <p v-else>
                                                            Recebido
                                                        </p>
                                                    </v-card-text>
                                                </v-card>
                                                <v-card>
                                                    <v-card-text>
                                                        <b>Data avaliação</b>
                                                        <p v-if="dado.dtAvaliador">
                                                            {{ dado.dtAvaliador | formatarData }}
                                                        </p>
                                                        <p v-else>
                                                             -
                                                        </p>
                                                    </v-card-text>
                                                </v-card>
                                                <v-card>
                                                    <v-card-text>
                                                        <b>Descrição da avaliação</b>
                                                        <p v-html="dado.dsAvaliacao"></p>
                                                    </v-card-text>
                                                </v-card>
                                            </v-layout>
                                        </div>
                                        <br>
                                        <br>
                                        <div v-if="dado.siEncaminhamento === 15">
                                            <v-list v-for="(parecer, index) in dado.pareceres" :key="index">
                                                <v-flex lg12 dark class="text-xs-center">
                                                    <b>----------------------------------------------</b>
                                                </v-flex>
                                                <v-layout row justify-space-between>
                                                    <v-card>
                                                        <v-card-text>
                                                            <b>Parecer favorável?</b>
                                                            <p v-if="parecer.ParecerFavoravel === '2'">
                                                                SIM
                                                            </p>
                                                            <p v-else>
                                                                NÂO
                                                            </p>
                                                        </v-card-text>
                                                    </v-card>

                                                    <v-card>
                                                        <v-card-text>
                                                            <b>Data parecer</b>
                                                            <p> {{ parecer.DtParecer | formatarData }}</p>
                                                        </v-card-text>
                                                    </v-card>
                                                </v-layout>
                                                <v-layout row justify-space-between>
                                                    <v-card>
                                                        <v-card-text>
                                                            <b>Descrição do parecer - Técnico / Parecerista</b>
                                                            <p v-html="parecer.ResumoParecer"></p>
                                                        </v-card-text>
                                                    </v-card>
                                                </v-layout>
                                            </v-list>
                                        </div>

                                    </v-container>
                                </v-card-text>
                            </v-card>
                            <hr/>
                        </div>
                    </v-dialog>
                </v-expansion-panel-content>
            </v-expansion-panel>

            <ReadequacoesDevolvidas/>
        </div>
    </div>
</template>
<script>

    import { mapActions, mapGetters } from 'vuex';
    import moment from 'moment';
    import Carregando from '@/components/CarregandoVuetify';
    import ReadequacoesDevolvidas from './components/ReadequacoesDevolvidas';

    export default {
        name: 'DadosReadequacoes',
        props: ['idPronac'],
        data() {
            return {
                dialog: false,
                loading: true,
                gruposReadequacao: {},
                headers: [
                    {
                        text: 'DT. SOLICITAÇÃO',
                        align: 'center',
                        value: 'dtSolicitacao',
                    },
                    {
                        text: 'SITUAÇÃO',
                        align: 'left',
                        value: 'stAtendimento',
                    },
                    {
                        text: 'DT. AVALIAÇÃO',
                        align: 'center',
                        value: 'dtAvaliacao',
                    },
                    {
                        text: 'DESCRIÇÃO DA AVALIAÇÃO',
                        align: 'left',
                        value: 'dsAvaliacao',
                    },
                    {
                        text: 'VISUALIZAR',
                        align: 'center',
                        value: 'dsAvaliacao',
                    },
                ],
            };
        },
        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                this.buscarDadosReadequacoes(this.dadosProjeto.idPronac);
            }
        },
        components: {
            Carregando,
            ReadequacoesDevolvidas,
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dados: 'projeto/dadosReadequacoes',
            }),
        },
        watch: {
            dados() {
                this.loading = false;
                this.gruposReadequacao = this.obterGrupoReadequacoes();
            },
        },
        filters: {
            formatarData(date) {
                if (date != null && date.length === 0) {
                    return '-';
                }
                return moment(date).format('DD/MM/YYYY');
            },
        },
        methods: {
            ...mapActions({
                buscarDadosReadequacoes: 'projeto/buscarDadosReadequacoes',
                buscarGrupoReadequacao: 'projeto/buscarGrupoReadequacao',
            }),
            showItem(item) {
                const idPronac = this.dadosProjeto.idPronac;
                const valor = item.idReadequacao;

                console.log(valor);
                this.buscarGrupoReadequacao({ idPronac, valor });
                this.dialog = true;
            },
            validarAcessoSituacao(siEncaminhamento) {
                const permitidos = [2, 3, 4, 5, 6, 7, 9, 10, 15];
                return permitidos.indexOf(siEncaminhamento) !== -1;
            },
            obterGrupoReadequacoes() {
                const gruposReadequacao = {};
                for (const indiceDadosReadequacao in this.dados.dadosReadequacoes) {
                    const tipoReadequacao = this.dados.dadosReadequacoes[indiceDadosReadequacao].tipoReadequacao;
                    if (gruposReadequacao[tipoReadequacao] == null || gruposReadequacao[tipoReadequacao].length < 1) {
                        gruposReadequacao[tipoReadequacao] = [];
                    }
                    gruposReadequacao[tipoReadequacao].push(this.dados.dadosReadequacoes[indiceDadosReadequacao]);
                }

                return gruposReadequacao;
            },
        },
    };
</script>

