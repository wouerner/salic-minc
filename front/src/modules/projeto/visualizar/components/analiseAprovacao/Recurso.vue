<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Recurso'"/>
        </div>
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
                                            <b><h4>DADOS DO RECURSO</h4></b>
                                            <v-divider class="pb-2"/>
                                        </v-flex>
                                        <v-flex>
                                            <b>Recurso</b><br>
                                            <span v-html="dados.dadosReconsideracao.dsSolicitacaoRecurso"/>
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
                                <!--RECURSOS-->
                                <v-layout
                                    justify-space-around
                                    row
                                    wrap>
                                    <v-flex
                                        lg12
                                        dark>
                                        <b><h4>DADOS DO RECURSO</h4></b>
                                        <v-divider class="pb-2"/>
                                    </v-flex>
                                    <v-flex>
                                        <b>Recurso</b><br>
                                        <span v-html="dados.dadosReconsideracao.dsSolicitacaoRecurso"/>
                                    </v-flex>
                                    <v-flex>
                                        <b>Tipo do Recurso</b><br>
                                        <span v-html="dados.dadosReconsideracao.tpRecursoDesc"/>
                                    </v-flex>
                                    <v-flex>
                                        <b>Tipo da Solicitação</b>
                                        <p v-html="dados.dadosReconsideracao.tpSolicitacaoDesc"/>
                                    </v-flex>
                                    <v-flex>
                                        <b>Status do Recurso</b>
                                        <p>{{ dados.dadosReconsideracao.siRecursoDesc }}</p>
                                    </v-flex>
                                    <v-flex>
                                        <b>Dt. Recurso</b>
                                        <p>{{ dados.dadosReconsideracao.dtSolicitacaoRecurso | formatarData }}</p>
                                    </v-flex>
                                </v-layout>
                                <div>
                                    <v-layout
                                        justify-space-around
                                        row
                                        wrap>
                                        <v-flex>
                                            <b>Avaliação do Pedido</b>
                                            <p v-html="dados.dadosReconsideracao.dsAvaliacao"/>
                                        </v-flex>
                                        <v-flex>
                                            <b>Dt. Avaliação</b>
                                            <p>{{ dados.dadosReconsideracao.dtAvaliacao | formatarData }}</p>
                                        </v-flex>
                                    </v-layout>
                                </div>
                                <div>
                                    <v-layout
                                        v-if="dados.dadosReconsideracao.tpSolicitacao === 'PI' ||
                                            dados.dadosReconsideracao.tpSolicitacao === 'EO' ||
                                        dados.dadosReconsideracao.tpSolicitacao === 'OR'"
                                        justify-space-around
                                        row
                                        wrap>
                                        <v-flex
                                            lg12
                                            dark
                                            class="text-xs-left">
                                            <b><h4>PARECER TÉCNICO</h4></b>
                                            <v-divider class="pb-2"/>
                                        </v-flex>
                                        <v-flex
                                            lg12
                                            dark
                                            class="text-xs-left">
                                            <h6>Produtos: </h6>
                                        </v-flex>
                                        <v-expansion-panel
                                            v-for="(dadosprodutos, index) in dados.produtosReconsideracao"
                                            popout
                                            focusable>
                                            <v-expansion-panel-content
                                                class="elevation-1">
                                                <div slot="header">
                                                    <b><span v-html="dadosprodutos.Produto"/></b>
                                                    <v-chip
                                                        v-if="dadosprodutos.stPrincipal === 1"
                                                        outline
                                                        color="red">Produto Principal
                                                    </v-chip>
                                                </div>
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
                                                                        <b><h4>ANÁLISE DE CONTEÚDO</h4></b>
                                                                        <v-divider class="pb-2"/>
                                                                    </v-flex>
                                                                    <v-flex>
                                                                        <p><b>Enquadramento Favorável? *</b></p>
                                                                        <p>
                                                                            {{
                                                                                (dadosprodutos.ParecerFavoravel === 0) ?
                                                                                    'Não':
                                                                                    'Sim'
                                                                            }}
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex>
                                                                        <p><b>Lei 8.313/91 alterada pela Lei 9.874/1999
                                                                        *</b></p>
                                                                        <p>
                                                                            {{ (dadosprodutos.Lei8313 === 1) ? 'Sim' :
                                                                            'Não'
                                                                            }}
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex>
                                                                        <p><b>Artigo 3°</b></p>
                                                                        <p>
                                                                            {{ (dadosprodutos.Lei5761 === 1) ? 'Sim' :
                                                                            'Não'
                                                                            }}
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex>
                                                                        <p><b>Inciso</b></p>
                                                                        <p/>
                                                                    </v-flex>
                                                                    <v-flex>
                                                                        <p><b>Alinea Artigo 3</b></p>
                                                                        <p/>
                                                                    </v-flex>
                                                                    <v-flex>
                                                                        <p><b>Artigo Enquadramento</b></p>
                                                                        <p/>
                                                                    </v-flex>
                                                                    <v-flex>
                                                                        <p><b>Alínea Artigo 18</b></p>
                                                                        <p/>
                                                                    </v-flex>
                                                                    <v-flex>
                                                                        <p><b>Decreto 5761/2006 *</b></p>
                                                                        <p/>
                                                                    </v-flex>
                                                                    <v-flex>
                                                                        <p><b>Artigo 27°</b></p>
                                                                        <p/>
                                                                    </v-flex>
                                                                    <v-flex>
                                                                        <p><b>Inciso(s)</b></p>
                                                                        <p/>
                                                                    </v-flex>
                                                                    <br>
                                                                    <br>
                                                                    <v-flex>
                                                                        <p><b>Justificativa *</b></p>
                                                                        <span v-html="dadosprodutos.ParecerDeConteudo"/>
                                                                    </v-flex>
                                                                </v-layout>
                                                            </div>
                                                        </v-container>
                                                    </v-card-text>
                                                </v-card>
                                            </v-expansion-panel-content>
                                        </v-expansion-panel>
                                    </v-layout>
                                    <!--Enquadramento -->
                                    <v-layout
                                        justify-space-around
                                        row
                                        wrap>
                                        <v-flex
                                            lg12
                                            dark>
                                            <b><h4>ENQUADRAMENTO</h4></b>
                                            <v-divider class="pb-2"/>
                                        </v-flex>
                                        <v-flex v-if="Object.keys(dados.ParecerReconsideracao).length > 0">
                                            <v-flex
                                                v-for="(dadosParecer, index) in dados.ParecerReconsideracao"
                                                :key="index">
                                                <v-flex>
                                                    <b>Parecer Favorável?</b>
                                                    <p>
                                                        {{ (dadosParecer.ParecerFavoravel === '2') ? 'Sim' : 'Não' }}
                                                    </p>
                                                </v-flex>
                                                <v-flex>
                                                    <b>Dt. Parecer</b>
                                                    <p>
                                                        {{ dadosParecer.DtParecer | formatarData }}
                                                    </p>
                                                </v-flex>
                                            </v-flex>
                                        </v-flex>
                                        <v-flex>
                                            <b>Área</b>
                                            <p v-html="dados.projetosENReconsideracao.area"/>
                                        </v-flex>
                                        <v-flex>
                                            <b>Segmento</b>
                                            <p v-html="dados.projetosENReconsideracao.segmento"/>
                                        </v-flex>
                                        <v-flex>
                                            <b>Enquadramento</b>
                                            <p>{{ dados.projetosENReconsideracao.artigo }}</p>
                                        </v-flex>
                                    </v-layout>
                                    <!--resumo do parecer-->
                                    <v-layout
                                        v-if="dados.dadosReconsideracao.siRecurso === '9 '"
                                        justify-space-around
                                        row
                                        wrap>
                                        <v-flex
                                            v-for="(dadosParecer, index) in dados.ParecerReconsideracao"
                                            :key="index">
                                            <b>Resumo do Parecer</b>
                                            <p v-html="dadosParecer.ResumoParecer"/>
                                        </v-flex>
                                    </v-layout>
                                </div>

                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </div>
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
    data() {
        return {
            loading: true,
        };
    },
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
            dados: 'projeto/recurso',
        }),
    },
    watch: {
        dadosProjeto(value) {
            this.buscarRecurso(value.idPronac);
        },
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
