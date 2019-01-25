<template>
    <div>
        <v-expansion-panel
            v-if="dados.desistenciaReconsideracao"
            popout
            focusable>
            <v-expansion-panel-content class="elevation-1">
                <v-layout
                    slot="header"
                    class="green--text">
                    <v-icon class="mr-3 green--text">perm_media</v-icon>
                    <span v-html="dados.dadosReconsideracao.tpRecursoDesc"/>
                </v-layout>
                <v-card>
                    <v-card-text>
                        <v-container fluid>
                            <div>
                                <v-layout
                                    justify-space-around
                                    row
                                    wrap>
                                    <v-flex
                                        lg12
                                        dark>
                                        <b>Recurso</b>
                                    </v-flex>
                                    <v-flex>
                                        <p v-html="dados.dadosReconsideracao.dsSolicitacaoRecurso"/>
                                    </v-flex>
                                </v-layout>
                            </div>

                            <div>
                                <v-layout
                                    justify-space-around
                                    row
                                    wrap>
                                    <v-flex
                                        lg12
                                        dark>
                                        <b>Dt. Desistência do Recurso</b>
                                    </v-flex>
                                    <v-flex>
                                        <p>{{ dados.dadosReconsideracao.dtSolicitacaoRecurso | formatarData }}</p>
                                    </v-flex>
                                </v-layout>
                            </div>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-expansion-panel-content>
        </v-expansion-panel>

        <v-expansion-panel
            v-else-if="dados.dadosReconsideracao"
            popout
            focusable>
            <v-expansion-panel-content class="elevation-1">
                <v-layout
                    slot="header"
                    class="green--text">
                    <v-icon class="mr-3 green--text">perm_media</v-icon>
                    <span v-html="dados.dadosReconsideracao.tpRecursoDesc"/>
                </v-layout>
                <v-card>
                    <v-card-text>
                        <v-container fluid>
                            <v-layout
                                justify-space-around
                                row
                                wrap>
                                <v-flex
                                    lg12
                                    dark>
                                    <b>Recurso</b>
                                </v-flex>
                                <v-flex>
                                    <span v-html="dados.dadosReconsideracao.dsSolicitacaoRecurso"/>
                                </v-flex>
                            </v-layout>

                            <v-layout
                                justify-space-around
                                row
                                wrap>
                                <v-flex
                                    s12
                                    m6
                                    lg2
                                    offset-lg1
                                    dark>
                                    <b>Tipo do Recurso</b><br>
                                    <span v-html="dados.dadosReconsideracao.tpRecursoDesc"/>
                                </v-flex>
                                <v-flex
                                    s12
                                    m6
                                    lg3>
                                    <b>Tipo da Solicitação</b>
                                    <p>{{ dados.dadosReconsideracao.tpSolicitacaoDesc }}</p>
                                </v-flex>
                            </v-layout>

                            <v-layout
                                justify-space-around
                                row
                                wrap>
                                <v-flex
                                    s12
                                    m6
                                    lg2
                                    offset-lg1
                                    dark>
                                    <b>Status do Recurso</b>
                                    <p>{{ dados.dadosReconsideracao.siRecursoDesc }}</p>
                                </v-flex>
                                <v-flex
                                    s12
                                    m6
                                    lg3>
                                    <b>Dt. Recurso</b>
                                    <p>{{ dados.dadosReconsideracao.dtSolicitacaoRecurso | formatarData }}</p>
                                </v-flex>
                            </v-layout>

                            <div>
                                <v-layout
                                    justify-space-around
                                    row
                                    wrap>
                                    <v-flex
                                        lg12
                                        dark>
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
                                <v-layout
                                    justify-space-around
                                    row
                                    wrap>
                                    <v-flex
                                        lg12
                                        dark>
                                        <b>Dt. Avaliação</b>
                                    </v-flex>
                                    <v-flex>
                                        <p>{{ dados.dadosReconsideracao.dtAvaliacao | formatarData }}</p>
                                    </v-flex>
                                </v-layout>
                            </div>

                            <div
                                v-if="dados.dadosReconsideracao.tpSolicitacao === 'PI' ||
                                    dados.dadosReconsideracao.tpSolicitacao === 'EO' ||
                                dados.dadosReconsideracao.tpSolicitacao === 'OR' "
                            >
                                Parecer Técnico/ Produtos
                                <span
                                    v-for="(dado, index) in dados.produtosReconsideracao"
                                    v-html="dado.ParecerDeConteudo"/>
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
import Carregando from '@/components/CarregandoVuetify';
import { utils } from '@/mixins/utils';

export default {
    name: 'Recurso',
    components: {
        Carregando,
    },
    mixins: [utils],
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
            dados: 'projeto/recurso',
        }),
    },
    watch: {
        dados() {
            this.loading = false;
        },
    },
    mounted() {
        if (typeof this.dadosProjeto.idPronac !== 'undefined') {
            this.buscarRecurso(this.dadosProjeto.idPronac);
        }
    },
    methods: {
        ...mapActions({
            buscarRecurso: 'projeto/buscarRecurso',
        }),
    },
};
</script>
