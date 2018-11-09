<template>
    <div>
        <v-expansion-panel popout focusable v-if="dados.desistenciaReconsideracao">
            <v-expansion-panel-content class="elevation-1">
                <v-layout slot="header" class="green--text">
                    <v-icon class="mr-3 green--text">perm_media</v-icon>
                    <span v-html="dados.dadosReconsideracao.tpRecursoDesc"></span>
                </v-layout>
                <v-card>
                    <v-card-text>
                        <v-container fluid>
                            <div>
                                <v-layout justify-space-around row wrap>
                                    <v-flex lg12 dark>
                                        <b>Recurso</b>
                                    </v-flex>
                                    <v-flex>
                                        <p v-html="dados.dadosReconsideracao.dsSolicitacaoRecurso"></p>
                                    </v-flex>
                                </v-layout>
                            </div>

                            <div>
                                <v-layout justify-space-around row wrap>
                                    <v-flex lg12 dark>
                                        <b>Dt. Desistência do Recurso</b>
                                    </v-flex>
                                    <v-flex>
                                        <p v-html="dados.dadosReconsideracao.dtSolicitacaoRecurso"></p>
                                    </v-flex>
                                </v-layout>
                            </div>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-expansion-panel-content>
        </v-expansion-panel>

        <v-expansion-panel popout focusable v-if="dados.dadosReconsideracao">
            <v-expansion-panel-content class="elevation-1">
                <v-layout slot="header" class="green--text">
                    <v-icon class="mr-3 green--text">perm_media</v-icon>
                    <span v-html="dados.dadosReconsideracao.tpRecursoDesc"></span>
                </v-layout>
                <v-card>
                    <v-card-text>
                        <v-container fluid>
                            <v-layout justify-space-around row wrap>
                                <v-flex lg12 dark>
                                    <b>Recurso</b>
                                </v-flex>
                                <v-flex>
                                    <span v-html="dados.dadosReconsideracao.dsSolicitacaoRecurso"></span>
                                </v-flex>
                            </v-layout>

                            <v-layout justify-space-around row wrap>
                                <v-flex s12 m6 lg2 offset-lg1 dark>
                                    <b>Tipo do Recurso</b><br>
                                    <span v-html="dados.dadosReconsideracao.tpRecursoDesc"></span>
                                </v-flex>
                                <v-flex s12 m6 lg3>
                                    <b>Tipo da Solicitação</b>
                                    <p>{{ dados.dadosReconsideracao.tpSolicitacaoDesc }}</p>
                                </v-flex>
                            </v-layout>

                            <v-layout justify-space-around row wrap>
                                <v-flex s12 m6 lg2 offset-lg1 dark>
                                    <b>Status do Recurso</b>
                                    <p>{{ dados.dadosReconsideracao.siRecursoDesc }}</p>
                                </v-flex>
                                <v-flex s12 m6 lg3>
                                    <b>Dt. Recurso</b>
                                    <p>{{ dados.dadosReconsideracao.dtSolicitacaoRecurso }}</p>
                                </v-flex>
                            </v-layout>

                            <div>
                                <v-layout justify-space-around row wrap>
                                    <v-flex lg12 dark>
                                        <b>Avaliação da Pedido</b>
                                    </v-flex>
                                    <v-flex>
                                        <p>Projeto encaminhado para análise do pedido de reconsideração formulado pelo
                                            proponente,
                                            relativo ao reenquadramento no art. 18 da Lei 8.313/91.
                                        </p>
                                    </v-flex>
                                </v-layout>
                            </div>

                            <div>
                                <v-layout justify-space-around row wrap>
                                    <v-flex lg12 dark>
                                        <b>Dt. Avaliação</b>
                                    </v-flex>
                                    <v-flex>
                                        <p>11/12/2013</p>
                                    </v-flex>
                                </v-layout>
                            </div>

                            <!--<div >-->
                            <!--<v-flex lg12 dark class="text-xs-center">-->
                            <!--<b>ARQUIVOS ANEXADOS</b>-->
                            <!--</v-flex>-->
                            <!--<v-container grid-list-md>-->
                            <!--<v-layout justify-space-around row wrap>-->
                            <!--<v-flex xs6>-->
                            <!--<b>Arquivo</b>-->
                            <!--</v-flex>-->
                            <!--<v-flex xs2>-->
                            <!--<b>Dt.Envio</b>-->
                            <!--</v-flex>-->
                            <!--</v-layout>-->
                            <!--<v-layout justify-space-around align-center row-->
                            <!--v-for="arquivo of dadosDiligencia.arquivos"-->
                            <!--:key="arquivo.idArquivo"-->
                            <!--&gt;-->
                            <!--<v-flex xs6>-->
                            <!--<p>-->
                            <!--<a :href="`/upload/abrir?id=${arquivo.idArquivo}`"-->
                            <!--target="_blank">-->
                            <!--{{ arquivo.nmArquivo }}-->
                            <!--</a>-->
                            <!--</p>-->
                            <!--</v-flex>-->
                            <!--<v-flex xs2>-->
                            <!--<p>-->
                            <!--{{ arquivo.dtEnvio }}-->
                            <!--</p>-->
                            <!--</v-flex>-->
                            <!--</v-layout>-->
                            <!--</v-container>-->
                            <!--</div>-->
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-expansion-panel-content>
        </v-expansion-panel>
    </div>
</template>
<script>

    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: 'Recursos',
        props: ['idPronac'],
        data() {
            return {
                dados: {
                    type: Object,
                    default() {
                        return {};
                    },
                },
            };
        },
        mounted() {
            if (typeof this.$route.params.idPronac !== 'undefined') {
                this.buscar_dados();
            }
        },
        methods: {
            buscar_dados() {
                const self = this;
                const idPronac = self.$route.params.idPronac;
                /* eslint-disable */
                $3.ajax({
                    url: '/analise/recursos-rest/index/idPronac/' + idPronac,
                }).done(function (response) {
                    self.dados = response.data.items;
                });
            },
        },
    };
</script>

