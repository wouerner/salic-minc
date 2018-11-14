<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Carregando Dados das Readequações'"></Carregando>
        </div>
        <div>
            <v-expansion-panel popout focusable>
                <v-expansion-panel-content
                        class="elevation-1"
                        v-for="(dado, index) in dados"
                        :key="index"
                >
                    <v-layout slot="header" class="green--text">
                        <v-icon class="mr-3 green--text">subject</v-icon>
                        <span>{{ dado.dsReadequacao }}</span>
                    </v-layout>
                    <div v-if="dado.siEncaminhamento !== 12">
                        <v-container fluid>
                            <v-card class="elevation-2">
                                <!--TEMPLATE PARA CASOS DO siEncaminhamento != 12   idPronacs para teste = 201753, 201978,
                                        199437,182737, 189712, 168247, 117034,150712
                                -->
                                <v-card-text class="pl-5">
                                    <v-container fluid>
                                        <div>
                                            <v-layout row justify-space-between>
                                                <v-card>
                                                    <v-card-text>
                                                        <b>ARQUIVO</b><br>
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
                                                        <b>DATA ENVIO</b>
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
                                                        <b>DATA SOLICITAÇÃO</b>
                                                        <p>{{ dado.dtSolicitacao | formatarData }} </p>
                                                    </v-card-text>
                                                </v-card>
                                            </v-layout>

                                            <v-layout row justify-space-between>
                                                <v-card>
                                                    <v-card-text>
                                                        <b>DADOS DA SOLICITAÇÃO</b>
                                                        <p v-html="dado.dsSolicitacao"></p>
                                                    </v-card-text>
                                                </v-card>
                                            </v-layout>

                                            <v-layout row justify-space-between>
                                                <v-card>
                                                    <v-card-text>
                                                        <b>JUSTIFICATIVA DA SOLICITAÇÃO</b>
                                                        <p v-html="dado.dsJustificativa"></p>
                                                    </v-card-text>
                                                </v-card>
                                            </v-layout>
                                        </div>
                                        <!-- so mostrar os campos: "Situacao, data avaliação e DESCRIÇÃO DA AVALIAÇÃO" se siEncaminhamento, array(2,3,4,5,6,7,9,10,15)-->
                                        <div>
                                            <v-layout row justify-space-between>
                                                <v-card>
                                                    <v-card-text>
                                                        <b>SITUAÇÃO</b>
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
                                                        <b>DATA AVALIAÇÃO</b>
                                                        <p>{{ dado.dtAvaliador | formatarData }}</p>
                                                    </v-card-text>
                                                </v-card>

                                                <v-card>
                                                    <v-card-text>
                                                        <b>DESCRIÇÃO DA AVALIAÇÃO</b>
                                                        <p v-html="dado.dsAvaliacao"></p>
                                                    </v-card-text>
                                                </v-card>
                                            </v-layout>
                                        </div>
                                        <!-- fim da verificação siEncaminhamento, array(2,3,4,5,6,7,9,10,15)-->

                                        <!--( so mostrar os campos: "PARECER FAVORÁVEL,Dt. Parecer , Descrição do Parecer" quando o siEncaminhamento, array(15)-->
                                        <div v-if="dado.siEncaminhamento === 15">
                                            <v-layout row justify-space-between>
                                                <v-card>
                                                    <v-card-text>
                                                        <b>PARECER FAVORÁVEL?</b>
                                                        <p v-if="dado.pareceres[0].ParecerFavoravel === 2 ">
                                                            {{ dados.pareceres }}
                                                        </p>
                                                        <p v-else>
                                                            dados.pareceres
                                                        </p>
                                                    </v-card-text>
                                                </v-card>

                                                <v-card>
                                                    <v-card-text>
                                                        <b>DATA PARECER</b>
                                                        <p>{{ dadosPina </p>
                                                    </v-card-text>
                                                </v-card>
                                            </v-layout>

                                            <v-layout row justify-space-between>
                                                <v-card>
                                                    <v-card-text>
                                                        <b>DESCRIÇÃO DO PARECER - TÉCNICO / PARECERISTA</b>
                                                        <p v-html="dado.siEncaminhamento.ResumoParecer"></p>
                                                    </v-card-text>
                                                </v-card>
                                            </v-layout>
                                        </div>
                                    </v-container>
                                </v-card-text>
                            </v-card>
                        </v-container>
                    </div>
                    <div v-else>
                        nada nada nada
                    </div>
                </v-expansion-panel-content>
            </v-expansion-panel>

            <!--<ReadequacoesDevolvidas/>-->
        </div>
    </div>
</template>
<script>

    import { mapActions, mapGetters } from 'vuex';
    import moment from 'moment';
    import Carregando from '@/components/Carregando';
    import ReadequacoesDevolvidas from './components/ReadequacoesDevolvidas';

    export default {
        name: 'MarcasAnexadas',
        props: ['idPronac'],
        data() {
            return {
                loading: true,
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
            },
        },
        filters: {
            formatarData(date) {
                if (date.length === 0) {
                    return '-';
                }
                return moment(date).format('DD/MM/YYYY');
            },
        },
        methods: {
            ...mapActions({
                buscarDadosReadequacoes: 'projeto/buscarDadosReadequacoes',
            }),
        },
    };
</script>

