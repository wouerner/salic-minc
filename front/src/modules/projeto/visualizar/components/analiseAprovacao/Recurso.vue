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

        <!--<v-expansion-panel-->
        <!--v-if="dados.dadosReconsideracao"-->
        <!--popout-->
        <!--focusable>-->
        <!--<v-expansion-panel-content class="elevation-1">-->
        <!--<v-layout-->
        <!--slot="header"-->
        <!--class="green&#45;&#45;text">-->
        <!--<v-icon class="mr-3 green&#45;&#45;text">perm_media</v-icon>-->
        <!--<span v-html="dados.dadosReconsideracao.tpRecursoDesc"/>-->
        <!--</v-layout>-->
        <!--<v-card>-->
        <!--<v-card-text>-->
        <!--<v-container fluid>-->
        <!--<v-layout-->
        <!--justify-space-around-->
        <!--row-->
        <!--wrap>-->
        <!--<v-flex-->
        <!--lg12-->
        <!--dark>-->
        <!--<b>Recurso</b>-->
        <!--</v-flex>-->
        <!--<v-flex>-->
        <!--<span v-html="dados.dadosReconsideracao.dsSolicitacaoRecurso"/>-->
        <!--</v-flex>-->
        <!--</v-layout>-->

        <!--<v-layout-->
        <!--justify-space-around-->
        <!--row-->
        <!--wrap>-->
        <!--<v-flex-->
        <!--s12-->
        <!--m6-->
        <!--lg2-->
        <!--offset-lg1-->
        <!--dark>-->
        <!--<b>Tipo do Recurso</b><br>-->
        <!--<span v-html="dados.dadosReconsideracao.tpRecursoDesc"/>-->
        <!--</v-flex>-->
        <!--<v-flex-->
        <!--s12-->
        <!--m6-->
        <!--lg3>-->
        <!--<b>Tipo da Solicitação</b>-->
        <!--<p>{{ dados.dadosReconsideracao.tpSolicitacaoDesc }}</p>-->
        <!--</v-flex>-->
        <!--</v-layout>-->

        <!--<v-layout-->
        <!--justify-space-around-->
        <!--row-->
        <!--wrap>-->
        <!--<v-flex-->
        <!--s12-->
        <!--m6-->
        <!--lg2-->
        <!--offset-lg1-->
        <!--dark>-->
        <!--<b>Status do Recurso</b>-->
        <!--<p>{{ dados.dadosReconsideracao.siRecursoDesc }}</p>-->
        <!--</v-flex>-->
        <!--<v-flex-->
        <!--s12-->
        <!--m6-->
        <!--lg3>-->
        <!--<b>Dt. Recurso</b>-->
        <!--<p>{{ dados.dadosReconsideracao.dtSolicitacaoRecurso }}</p>-->
        <!--</v-flex>-->
        <!--</v-layout>-->

        <!--<div>-->
        <!--<v-layout-->
        <!--justify-space-around-->
        <!--row-->
        <!--wrap>-->
        <!--<v-flex-->
        <!--lg12-->
        <!--dark>-->
        <!--<b>Avaliação da Pedido</b>-->
        <!--</v-flex>-->
        <!--<v-flex>-->
        <!--<p>Projeto encaminhado para análise do pedido de reconsideração formulado pelo-->
        <!--proponente,-->
        <!--relativo ao reenquadramento no art. 18 da Lei 8.313/91.-->
        <!--</p>-->
        <!--</v-flex>-->
        <!--</v-layout>-->
        <!--</div>-->

        <!--<div>-->
        <!--<v-layout-->
        <!--justify-space-around-->
        <!--row-->
        <!--wrap>-->
        <!--<v-flex-->
        <!--lg12-->
        <!--dark>-->
        <!--<b>Dt. Avaliação</b>-->
        <!--</v-flex>-->
        <!--<v-flex>-->
        <!--<p>11/12/2013</p>-->
        <!--</v-flex>-->
        <!--</v-layout>-->
        <!--</div>-->

        <!--&lt;!&ndash;<div >&ndash;&gt;-->
        <!--&lt;!&ndash;<v-flex lg12 dark class="text-xs-center">&ndash;&gt;-->
        <!--&lt;!&ndash;<b>ARQUIVOS ANEXADOS</b>&ndash;&gt;-->
        <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
        <!--&lt;!&ndash;<v-container grid-list-md>&ndash;&gt;-->
        <!--&lt;!&ndash;<v-layout justify-space-around row wrap>&ndash;&gt;-->
        <!--&lt;!&ndash;<v-flex xs6>&ndash;&gt;-->
        <!--&lt;!&ndash;<b>Arquivo</b>&ndash;&gt;-->
        <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
        <!--&lt;!&ndash;<v-flex xs2>&ndash;&gt;-->
        <!--&lt;!&ndash;<b>Dt.Envio</b>&ndash;&gt;-->
        <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
        <!--&lt;!&ndash;</v-layout>&ndash;&gt;-->
        <!--&lt;!&ndash;<v-layout justify-space-around align-center row&ndash;&gt;-->
        <!--&lt;!&ndash;v-for="arquivo of dadosDiligencia.arquivos"&ndash;&gt;-->
        <!--&lt;!&ndash;:key="arquivo.idArquivo"&ndash;&gt;-->
        <!--&lt;!&ndash;&gt;&ndash;&gt;-->
        <!--&lt;!&ndash;<v-flex xs6>&ndash;&gt;-->
        <!--&lt;!&ndash;<p>&ndash;&gt;-->
        <!--&lt;!&ndash;<a :href="`/upload/abrir?id=${arquivo.idArquivo}`"&ndash;&gt;-->
        <!--&lt;!&ndash;target="_blank">&ndash;&gt;-->
        <!--&lt;!&ndash;{{ arquivo.nmArquivo }}&ndash;&gt;-->
        <!--&lt;!&ndash;</a>&ndash;&gt;-->
        <!--&lt;!&ndash;</p>&ndash;&gt;-->
        <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
        <!--&lt;!&ndash;<v-flex xs2>&ndash;&gt;-->
        <!--&lt;!&ndash;<p>&ndash;&gt;-->
        <!--&lt;!&ndash;{{ arquivo.dtEnvio }}&ndash;&gt;-->
        <!--&lt;!&ndash;</p>&ndash;&gt;-->
        <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
        <!--&lt;!&ndash;</v-layout>&ndash;&gt;-->
        <!--&lt;!&ndash;</v-container>&ndash;&gt;-->
        <!--&lt;!&ndash;</div>&ndash;&gt;-->
        <!--</v-container>-->
        <!--</v-card-text>-->
        <!--</v-card>-->
        <!--</v-expansion-panel-content>-->
        <!--</v-expansion-panel>-->
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
    // data() {
    //     return {
    //         search: '',
    //         pagination: {
    //             sortBy: 'DtEmissao',
    //             descending: true,
    //         },
    //         selected: [],
    //         loading: true,
    //         headers: [
    //             {
    //                 text: 'CERTIDÕES',
    //                 align: 'left',
    //                 value: 'dsCertidao',
    //             },
    //             {
    //                 text: 'DATA DE EMISSÃO',
    //                 align: 'center',
    //                 value: 'DtEmissao',
    //             },
    //             {
    //                 text: 'DATA DE VALIDADE',
    //                 align: 'center',
    //                 value: 'DtValidade',
    //             },
    //             {
    //                 text: 'PRONAC',
    //                 align: 'center',
    //                 value: 'Pronac',
    //             },
    //             {
    //                 text: 'SITUAÇÃO',
    //                 align: 'left',
    //                 value: 'Situacao',
    //             },
    //         ],
    //     };
    // },
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
