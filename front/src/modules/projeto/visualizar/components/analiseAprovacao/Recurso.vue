<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Recursos'"/>
        </div>
        <div>
            <v-expansion-panel
                v-if="dados.desistenciaReconsideracao"
                popout
                focusable>
                <v-expansion-panel-content
                    v-for="(dados, index) in dados.dadosReconsideracao"
                    :key="index"
                    class="elevation-1">
                    <v-layout
                        slot="header"
                        class="green--text">
                        <v-icon class="mr-3 green--text">perm_media</v-icon>
                        <span v-html="dados.tpRecursoDesc"/>
                    </v-layout>
                    <v-card>
                        <v-card-text>
                            <v-container

                                fluid>
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
                                            <span v-html="dados.dsSolicitacaoRecurso"/>
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
                                            <p>{{ dados.dtSolicitacaoRecurso | formatarData }}</p>
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
                <v-expansion-panel-content
                    v-for="(dados, index) in dados.dadosReconsideracao"
                    :key="index"
                    class="elevation-1">
                    <v-layout
                        slot="header"
                        class="green--text">
                        <v-icon class="mr-3 green--text">perm_media</v-icon>
                        <span v-html="dados.tpRecursoDesc"/>
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
                                        <span v-html="dados.dsSolicitacaoRecurso"/>
                                    </v-flex>
                                    <v-flex>
                                        <b>Tipo do Recurso</b><br>
                                        <span v-html="dados.tpRecursoDesc"/>
                                    </v-flex>
                                    <v-flex>
                                        <b>Tipo da Solicitação</b>
                                        <p v-html="dados.tpSolicitacaoDesc"/>
                                    </v-flex>
                                    <v-flex>
                                        <b>Status do Recurso</b>
                                        <p>{{ dados.siRecursoDesc }}</p>
                                    </v-flex>
                                    <v-flex>
                                        <b>Dt. Recurso</b>
                                        <p>{{ dados.dtSolicitacaoRecurso | formatarData }}</p>
                                    </v-flex>
                                </v-layout>
                                <div>
                                    <v-layout
                                        justify-space-around
                                        row
                                        wrap>
                                        <v-flex>
                                            <b>Avaliação do Pedido</b>
                                            <p v-html="dados.dsAvaliacao"/>
                                        </v-flex>
                                        <v-flex>
                                            <b>Dt. Avaliação</b>
                                            <p>{{ dados.dtAvaliacao | formatarData }}</p>
                                        </v-flex>
                                    </v-layout>
                                </div>
                                <!--<div>-->
                                    <!--&lt;!&ndash;<v-layout&ndash;&gt;-->
                                        <!--&lt;!&ndash;v-if="dados.dadosReconsideracao.tpSolicitacao === 'PI' ||&ndash;&gt;-->
                                            <!--&lt;!&ndash;dados.dadosReconsideracao.tpSolicitacao === 'EO' ||&ndash;&gt;-->
                                        <!--&lt;!&ndash;dados.dadosReconsideracao.tpSolicitacao === 'OR'"&ndash;&gt;-->
                                        <!--&lt;!&ndash;justify-space-around&ndash;&gt;-->
                                        <!--&lt;!&ndash;row&ndash;&gt;-->
                                        <!--&lt;!&ndash;wrap>&ndash;&gt;-->
                                        <!--&lt;!&ndash;<v-flex&ndash;&gt;-->
                                            <!--&lt;!&ndash;lg12&ndash;&gt;-->
                                            <!--&lt;!&ndash;dark&ndash;&gt;-->
                                            <!--&lt;!&ndash;class="text-xs-left">&ndash;&gt;-->
                                            <!--&lt;!&ndash;<b><h4>PARECER TÉCNICO</h4></b>&ndash;&gt;-->
                                            <!--&lt;!&ndash;<v-divider class="pb-2"/>&ndash;&gt;-->
                                        <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                        <!--&lt;!&ndash;<v-flex&ndash;&gt;-->
                                            <!--&lt;!&ndash;lg12&ndash;&gt;-->
                                            <!--&lt;!&ndash;dark&ndash;&gt;-->
                                            <!--&lt;!&ndash;class="text-xs-left">&ndash;&gt;-->
                                            <!--&lt;!&ndash;<h6>Produtos: </h6>&ndash;&gt;-->
                                        <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                        <!--&lt;!&ndash;<v-expansion-panel&ndash;&gt;-->
                                            <!--&lt;!&ndash;v-for="(dadosprodutos, index) in dados.produtosReconsideracao"&ndash;&gt;-->
                                            <!--&lt;!&ndash;:key="index"&ndash;&gt;-->
                                            <!--&lt;!&ndash;popout&ndash;&gt;-->
                                            <!--&lt;!&ndash;focusable>&ndash;&gt;-->
                                            <!--&lt;!&ndash;<v-expansion-panel-content&ndash;&gt;-->
                                                <!--&lt;!&ndash;class="elevation-1">&ndash;&gt;-->
                                                <!--&lt;!&ndash;<div slot="header">&ndash;&gt;-->
                                                    <!--&lt;!&ndash;<b><span v-html="dadosprodutos.Produto"/></b>&ndash;&gt;-->
                                                    <!--&lt;!&ndash;<v-chip&ndash;&gt;-->
                                                        <!--&lt;!&ndash;v-if="dadosprodutos.stPrincipal === 1"&ndash;&gt;-->
                                                        <!--&lt;!&ndash;outline&ndash;&gt;-->
                                                        <!--&lt;!&ndash;color="red">Produto Principal&ndash;&gt;-->
                                                    <!--&lt;!&ndash;</v-chip>&ndash;&gt;-->
                                                <!--&lt;!&ndash;</div>&ndash;&gt;-->
                                                <!--&lt;!&ndash;<v-card>&ndash;&gt;-->
                                                    <!--&lt;!&ndash;<v-card-text>&ndash;&gt;-->
                                                        <!--&lt;!&ndash;<v-container fluid>&ndash;&gt;-->
                                                            <!--&lt;!&ndash;<div>&ndash;&gt;-->
                                                                <!--&lt;!&ndash;<v-layout&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;justify-space-around&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;row&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;wrap>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;lg12&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;dark>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<b><h4>ANÁLISE DE CONTEÚDO</h4></b>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<v-divider class="pb-2"/>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<b>Enquadramento Favorável? *</b>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<p>&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;{{&ndash;&gt;-->
                                                                                <!--&lt;!&ndash;(dadosprodutos.ParecerFavoravel === 0) ?&ndash;&gt;-->
                                                                                    <!--&lt;!&ndash;'Não':&ndash;&gt;-->
                                                                                    <!--&lt;!&ndash;'Sim'&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;}}&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;</p>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<b>Lei 8.313/91 alterada pela Lei 9.874/1999&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;*</b>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<p>&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;{{ (dadosprodutos.Lei8313 === 1) ? 'Sim' :&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;'Não'&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;}}&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;</p>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<b>Artigo 3°</b>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<p>&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;{{ (dadosprodutos.Artigo3 === 1) ? 'Sim' :&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;'Não'&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;}}&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;</p>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<b>Inciso</b>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<p>Inciso {{ dadosprodutos.IncisoArtigo3 }}</p>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<b>Alinea Artigo 3</b>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<p>{{ dadosprodutos.AlineaArtigo3 }}</p>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<b>Artigo Enquadramento</b>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<p>&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;{{ (dadosprodutos.Artigo18 === 1) ? 'Artigo 18' : 'Artigo  26' }}&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;</p>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<b>Alínea Artigo 18</b>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<p>{{ dadosprodutos.AlineaArtigo18 }}</p>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                <!--&lt;!&ndash;</v-layout>&ndash;&gt;-->
                                                                <!--&lt;!&ndash;<v-layout&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;justify-space-around&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;row&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;wrap>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<b>Decreto 5761/2006 *</b>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<p>{{ (dadosprodutos.Lei5761 === 1) ? 'Sim' : 'Não' }}</p>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<b>Artigo 27°</b>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<p>{{ (dadosprodutos.Artigo27 === 1) ? 'Sim' : 'Não' }}</p>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<b>Inciso(s)</b>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<v-checkbox&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;v-model="dadosprodutos.IncisoArtigo27_I"&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;label="I"&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;value&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;disabled&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;/>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<v-checkbox&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;v-model="dadosprodutos.IncisoArtigo27_II"&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;label="II"&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;value&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;disabled&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;/>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<v-checkbox&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;v-model="dadosprodutos.IncisoArtigo27_III"&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;label="III"&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;value&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;disabled&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;/>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<v-checkbox&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;v-model="dadosprodutos.IncisoArtigo27_IV"&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;label="IV"&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;value&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;disabled&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;/>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                <!--&lt;!&ndash;</v-layout>&ndash;&gt;-->

                                                                <!--&lt;!&ndash;<v-layout&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;justify-space-around&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;row&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;wrap>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<b>Decreto 5761/2006 *</b>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<p>{{ (dadosprodutos.Lei5761 === 1) ? 'Sim' : 'Não' }}</p>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<b>Artigo 27°</b>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<p>{{ (dadosprodutos.Artigo27 === 1) ? 'Sim' : 'Não' }}</p>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<b>Inciso(s)</b>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<v-checkbox&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;v-model="dadosprodutos.IncisoArtigo27_I"&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;label="I"&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;value&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;disabled&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;/>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<v-checkbox&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;v-model="dadosprodutos.IncisoArtigo27_II"&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;label="II"&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;value&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;disabled&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;/>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<v-checkbox&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;v-model="dadosprodutos.IncisoArtigo27_III"&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;label="III"&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;value&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;disabled&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;/>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<v-checkbox&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;v-model="dadosprodutos.IncisoArtigo27_IV"&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;label="IV"&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;value&ndash;&gt;-->
                                                                            <!--&lt;!&ndash;disabled&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;/>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                <!--&lt;!&ndash;</v-layout>&ndash;&gt;-->

                                                                <!--&lt;!&ndash;<v-layout&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;justify-space-around&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;row&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;wrap>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;<v-flex>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<b>Justificativa *</b>&ndash;&gt;-->
                                                                        <!--&lt;!&ndash;<span v-html="dadosprodutos.ParecerDeConteudo"/>&ndash;&gt;-->
                                                                    <!--&lt;!&ndash;</v-flex>&ndash;&gt;-->
                                                                <!--&lt;!&ndash;</v-layout>&ndash;&gt;-->
                                                            <!--&lt;!&ndash;</div>&ndash;&gt;-->
                                                        <!--&lt;!&ndash;</v-container>&ndash;&gt;-->
                                                    <!--&lt;!&ndash;</v-card-text>&ndash;&gt;-->
                                                <!--&lt;!&ndash;</v-card>&ndash;&gt;-->
                                            <!--&lt;!&ndash;</v-expansion-panel-content>&ndash;&gt;-->
                                        <!--&lt;!&ndash;</v-expansion-panel>&ndash;&gt;-->
                                    <!--&lt;!&ndash;</v-layout>&ndash;&gt;-->
                                    <!--&lt;!&ndash;Enquadramento &ndash;&gt;-->
                                    <!--<v-layout-->
                                        <!--justify-space-around-->
                                        <!--row-->
                                        <!--wrap>-->
                                        <!--<v-flex-->
                                            <!--lg12-->
                                            <!--dark>-->
                                            <!--<b><h4>ENQUADRAMENTO</h4></b>-->
                                            <!--<v-divider class="pb-2"/>-->
                                        <!--</v-flex>-->
                                        <!--<v-flex v-if="Object.keys(dados.ParecerReconsideracao).length > 0">-->
                                            <!--<v-flex-->
                                                <!--v-for="(dadosParecer, index) in dados.ParecerReconsideracao"-->
                                                <!--:key="index">-->
                                                <!--<v-flex>-->
                                                    <!--<b>Parecer Favorável?</b>-->
                                                    <!--<p>-->
                                                        <!--{{ (dadosParecer.ParecerFavoravel === '2') ? 'Sim' : 'Não' }}-->
                                                    <!--</p>-->
                                                <!--</v-flex>-->
                                                <!--<v-flex>-->
                                                    <!--<b>Dt. Parecer</b>-->
                                                    <!--<p>-->
                                                        <!--{{ dadosParecer.DtParecer | formatarData }}-->
                                                    <!--</p>-->
                                                <!--</v-flex>-->
                                            <!--</v-flex>-->
                                        <!--</v-flex>-->
                                        <!--<v-flex>-->
                                            <!--<b>Área</b>-->
                                            <!--<p v-html="dados.projetosENReconsideracao.area"/>-->
                                        <!--</v-flex>-->
                                        <!--<v-flex>-->
                                            <!--<b>Segmento</b>-->
                                            <!--<p v-html="dados.projetosENReconsideracao.segmento"/>-->
                                        <!--</v-flex>-->
                                        <!--<v-flex>-->
                                            <!--<b>Enquadramento</b>-->
                                            <!--<p>{{ dados.projetosENReconsideracao.artigo }}</p>-->
                                        <!--</v-flex>-->
                                    <!--</v-layout>-->
                                    <!--&lt;!&ndash;resumo do parecer&ndash;&gt;-->
                                    <!--<v-layout-->
                                        <!--v-if="dados.dadosReconsideracao.siRecurso === '9 '"-->
                                        <!--justify-space-around-->
                                        <!--row-->
                                        <!--wrap>-->
                                        <!--<v-flex-->
                                            <!--v-for="(dadosParecer, index) in dados.ParecerReconsideracao"-->
                                            <!--:key="index">-->
                                            <!--<b>Resumo do Parecer</b>-->
                                            <!--<p v-html="dadosParecer.ResumoParecer"/>-->
                                        <!--</v-flex>-->
                                    <!--</v-layout>-->
                                <!--</div>-->

                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-expansion-panel-content>
            </v-expansion-panel>
            <!--<PedidoRecurso/>-->
        </div>
    </div>
</template>
<script>

import { mapActions, mapGetters } from 'vuex';
import Carregando from '@/components/CarregandoVuetify';
import PedidoRecurso from './components/PedidoRecurso';
import { utils } from '@/mixins/utils';

export default {
    name: 'Recurso',
    components: {
        Carregando,
        PedidoRecurso,
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
