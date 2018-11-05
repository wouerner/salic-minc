<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Carregando Diligências do Projeto'"></Carregando>
        </div>
                <v-flex>
                    <v-expansion-panel popout focusable>
                        <v-expansion-panel-content>
                            <div slot="header">Diligência Proposta</div>
                            <v-card>
                                <v-card-text>
                                    <VisualizarDiligenciaProposta
                                            :idPronac="idPronac"
                                            :diligencias="dados.diligenciaProposta"
                                    >
                                    </VisualizarDiligenciaProposta>
                                </v-card-text>
                            </v-card>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-flex>

                    <v-expansion-panel popout focusable>
                        <v-expansion-panel-content>
                            <div slot="header">Diligências da Adequação do Projeto</div>
                            <v-card>
                                <v-card-text>
                                    <VisualizarDiligenciaAdequacao
                                            :idPronac="idPronac"
                                            :diligencias="dados.diligenciaAdequacao"
                                    >
                                    </VisualizarDiligenciaAdequacao>
                                </v-card-text>
                            </v-card>
                        </v-expansion-panel-content>
                    </v-expansion-panel>

                    <v-expansion-panel popout focusable>
                        <v-expansion-panel-content>
                            <div slot="header">Diligência Projeto</div>
                            <v-card>
                                <v-card-text>
                                    <VisualizarDiligenciaProjeto
                                            :idPronac="idPronac"
                                            :diligencias="dados.diligenciaProjeto"
                                    >
                                    </VisualizarDiligenciaProjeto>
                                </v-card-text>
                            </v-card>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
        <!--<div class="plano-distribuicao card">-->
            <!--<ul class="collapsible collapsible-produto no-padding" data-collapsible="expandable">-->
                <!--<li>-->
                    <!--<div class="collapsible-header green-text">-->
                        <!--<i class="material-icons">perm_media</i> Diligência Proposta-->
                    <!--</div>-->
                    <!--<div class="collapsible-body no-padding margin10 scroll-x">-->
                        <!--<VisualizarDiligenciaProposta-->
                                <!--:idPronac="idPronac"-->
                                <!--:diligencias="dados.diligenciaProposta"-->
                        <!--&gt;-->
                        <!--</VisualizarDiligenciaProposta>-->
                    <!--</div>-->
                <!--</li>-->
            <!--</ul>-->

            <!--<ul class="collapsible collapsible-produto no-padding" data-collapsible="expandable">-->
                <!--<li>-->
                    <!--<div class="collapsible-header green-text">-->
                        <!--<i class="material-icons">perm_media</i>Diligências da Adequação do Projeto-->
                    <!--</div>-->
                    <!--<div class="collapsible-body no-padding margin10 scroll-x">-->
                        <!--<VisualizarDiligenciaAdequacao-->
                                <!--:idPronac="idPronac"-->
                                <!--:diligencias="dados.diligenciaAdequacao"-->
                        <!--&gt;-->
                        <!--</VisualizarDiligenciaAdequacao>-->
                    <!--</div>-->
                <!--</li>-->
            <!--</ul>-->

            <!--<ul class="collapsible collapsible-produto no-padding" data-collapsible="expandable">-->
                <!--<li>-->
                    <!--<div class="collapsible-header green-text">-->
                        <!--<i class="material-icons">perm_media</i> Diligência Projeto-->
                    <!--</div>-->
                    <!--<div class="collapsible-body no-padding margin10 scroll-x">-->
                        <!--<VisualizarDiligenciaProjeto-->
                                <!--:idPronac="idPronac"-->
                                <!--:diligencias="dados.diligenciaProjeto"-->
                        <!--&gt;-->
                        <!--</VisualizarDiligenciaProjeto>-->
                    <!--</div>-->
                <!--&lt;!&ndash;</li>&ndash;&gt;-->
            <!--&lt;!&ndash;</ul>&ndash;&gt;-->
        <!--&lt;!&ndash;</div>&ndash;&gt;-->
    </div>

    <!--<div>-->
        <!--<div v-if="loading">-->
            <!--<Carregando :text="'Carregando Diligências do Projeto'"></Carregando>-->
        <!--</div>-->
        <!--<div v-if="dados.diligenciaProposta">-->
            <!--<fieldset style="margin: 0px;">-->
                <!--<legend>Dilig&ecirc;ncia Proposta</legend>-->
                <!--<VisualizarDiligenciaProposta-->
                        <!--:idPronac="idPronac"-->
                        <!--:diligencias="dados.diligenciaProposta"-->
                <!--&gt;-->
                <!--</VisualizarDiligenciaProposta>-->
            <!--</fieldset>-->
        <!--</div>-->
        <!--<div v-if="dados.diligenciaAdequacao">-->
            <!--<fieldset style="margin: 0px;">-->
                <!--<legend></legend>-->
                <!---->
            <!--</fieldset>-->
        <!--</div>-->
        <!--<div v-if="dados.diligenciaProjeto">-->
            <!--<fieldset style="margin: 0px;">-->
                <!--<legend></legend>-->
                <!---->
            <!--</fieldset>-->
        <!--</div>-->
    <!--</div>-->
</template>
<script>
    import { mapGetters, mapActions } from 'vuex';
    import Carregando from '@/components/Carregando';
    import VisualizarDiligenciaProposta from './components/VisualizarDiligenciaProposta';
    import VisualizarDiligenciaAdequacao from './components/VisualizarDiligenciaAdequacao';
    import VisualizarDiligenciaProjeto from './components/VisualizarDiligenciaProjeto';

    export default {
        name: 'DiligenciaProjeto',
        components: {
            Carregando,
            VisualizarDiligenciaProposta,
            VisualizarDiligenciaAdequacao,
            VisualizarDiligenciaProjeto,
        },
        data() {
            return {
                loading: true,
                idPronac: {},
            };
        },
        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                this.buscarDiligencia(this.dadosProjeto.idPronac);
            }
        },
        watch: {
            dados() {
                this.loading = false;
            },
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dados: 'projeto/diligencia',
            }),
        },
        methods: {
            ...mapActions({
                buscarDiligencia: 'projeto/buscarDiligencia',
            }),
        },
    };
</script>

