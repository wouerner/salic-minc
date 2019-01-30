<template>
    <div>
        <div>
            <v-expansion-panel
                v-if="dados.desistenciaRecurso"
                popout
                focusable>
                <v-expansion-panel-content class="elevation-1">
                    <v-layout
                        slot="header"
                        class="green--text">
                        <v-icon class="mr-3 green--text">perm_media</v-icon>
                        <span>Pedido de Recurso</span>
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
                                            <span v-html="dados.dadosRecurso.dsSolicitacaoRecurso"/>
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
                                            <p>{{ dados.dadosRecurso.dtSolicitacaoRecurso | formatarData }}</p>
                                        </v-flex>
                                    </v-layout>
                                </div>
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-expansion-panel-content>
            </v-expansion-panel>
            <v-expansion-panel
                v-else-if="dados.dadosRecurso"
                popout
                focusable>
                <v-expansion-panel-content class="elevation-1">
                    <v-layout
                        slot="header"
                        class="green--text">
                        <v-icon class="mr-3 green--text">perm_media</v-icon>
                        <span>Pedido de Recurso</span>
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
                                        <b><h4>AVALIAÇÃO DO COORDENADOR</h4></b>
                                        <v-divider class="pb-2"/>
                                    </v-flex>
                                    <v-flex>
                                        <b>Recurso</b><br>
                                        <span v-html="dados.dadosRecurso.dsSolicitacaoRecurso"/>
                                    </v-flex>
                                    <v-flex>
                                        <b>Tipo do Recurso</b><br>
                                        <span v-html="dados.dadosRecurso.tpRecursoDesc"/>
                                    </v-flex>
                                    <v-flex>
                                        <b>Tipo da Solicitação</b>
                                        <p v-html="dados.dadosRecurso.tpSolicitacaoDesc"/>
                                    </v-flex>
                                    <v-flex>
                                        <b>Status do Recurso</b>
                                        <p>{{ dados.dadosRecurso.siRecursoDesc }}</p>
                                    </v-flex>
                                    <v-flex>
                                        <b>Dt. Recurso</b>
                                        <p>{{ dados.dadosRecurso.dtSolicitacaoRecurso | formatarData }}</p>
                                    </v-flex>
                                </v-layout>
                                <div>
                                    <v-layout
                                        justify-space-around
                                        row
                                        wrap>
                                        <v-flex>
                                            <b>Descrição</b>
                                            <p v-html="dados.dadosRecurso.dsAvaliacao"/>
                                        </v-flex>
                                        <v-flex>
                                            <b>Dt. Avaliação</b>
                                            <p>{{ dados.dadosRecurso.dtAvaliacao | formatarData }}</p>
                                        </v-flex>
                                        <v-flex>
                                            <b>Situação </b>
                                            <p>{{ (dados.dadosRecurso.stAtendimento === 'I') ? 'Indeferido' : 'Deferido' }}</p>
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
                                            v-for="(dadosprodutos, index) in dados.produtosRecurso"
                                            :key="index"
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
                                                                        <b>Enquadramento Favorável? *</b>
                                                                        <p>
                                                                            {{
                                                                                (dadosprodutos.ParecerFavoravel === 0) ?
                                                                                    'Não':
                                                                                    'Sim'
                                                                            }}
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex>
                                                                        <b>Lei 8.313/91 alterada pela Lei 9.874/1999
                                                                        *</b>
                                                                        <p>
                                                                            {{ (dadosprodutos.Lei8313 === 1) ? 'Sim' :
                                                                            'Não'
                                                                            }}
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex>
                                                                        <b>Artigo 3°</b>
                                                                        <p>
                                                                            {{ (dadosprodutos.Artigo3 === 1) ? 'Sim' :
                                                                            'Não'
                                                                            }}
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex>
                                                                        <b>Inciso</b>
                                                                        <p>Inciso {{ dadosprodutos.IncisoArtigo3 }}</p>
                                                                    </v-flex>
                                                                    <v-flex>
                                                                        <b>Alinea Artigo 3</b>
                                                                        <p>{{ dadosprodutos.AlineaArtigo3 }}</p>
                                                                    </v-flex>
                                                                    <v-flex>
                                                                        <b>Artigo Enquadramento</b>
                                                                        <p>
                                                                            {{ (dadosprodutos.Artigo18 === 1) ? 'Artigo 18' : 'Artigo  26' }}
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex>
                                                                        <b>Alínea Artigo 18</b>
                                                                        <p>{{ dadosprodutos.AlineaArtigo18 }}</p>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout
                                                                    justify-space-around
                                                                    row
                                                                    wrap>
                                                                    <v-flex>
                                                                        <b>Decreto 5761/2006 *</b>
                                                                        <p>{{ (dadosprodutos.Lei5761 === 1) ? 'Sim' : 'Não' }}</p>
                                                                    </v-flex>
                                                                    <v-flex>
                                                                        <b>Artigo 27°</b>
                                                                        <p>{{ (dadosprodutos.Artigo27 === 1) ? 'Sim' : 'Não' }}</p>
                                                                    </v-flex>
                                                                    <v-flex>
                                                                        <b>Inciso(s)</b>
                                                                        <v-checkbox
                                                                            v-model="dadosprodutos.IncisoArtigo27_I"
                                                                            label="I"
                                                                            value
                                                                            disabled
                                                                        />
                                                                        <v-checkbox
                                                                            v-model="dadosprodutos.IncisoArtigo27_II"
                                                                            label="II"
                                                                            value
                                                                            disabled
                                                                        />
                                                                        <v-checkbox
                                                                            v-model="dadosprodutos.IncisoArtigo27_III"
                                                                            label="III"
                                                                            value
                                                                            disabled
                                                                        />
                                                                        <v-checkbox
                                                                            v-model="dadosprodutos.IncisoArtigo27_IV"
                                                                            label="IV"
                                                                            value
                                                                            disabled
                                                                        />
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout
                                                                    justify-space-around
                                                                    row
                                                                    wrap>
                                                                    <v-flex>
                                                                        <b>Justificativa *</b>
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
                                        <v-flex v-if="Object.keys(dados.ParecerRecurso).length > 0">
                                            <v-flex
                                                v-for="(dadosParecer, index) in dados.ParecerRecurso"
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
                                            <p v-html="dados.projetosENRecurso.area"/>
                                        </v-flex>
                                        <v-flex>
                                            <b>Segmento</b>
                                            <p v-html="dados.projetosENRecurso.segmento"/>
                                        </v-flex>
                                        <v-flex>
                                            <b>Enquadramento</b>
                                            <p>{{ dados.projetosENRecurso.artigo }}</p>
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
    name: 'PedidoRecurso',
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
        dadosProjeto(value) {
            this.buscarRecurso(value.idPronac);
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
