<template>
    <div v-if="loading">
        <Carregando :text="'Carregando Diligências do Projeto'"></Carregando>
    </div>
    <div v-else>
        <IdentificacaoProjeto
                :pronac="dadosProjeto.Pronac"
                :nomeProjeto="dadosProjeto.NomeProjeto"
        >
        </IdentificacaoProjeto>
        <template>
            <v-expansion-panel popout>
                <v-expansion-panel-content
                >
                    <div slot="header">Diligência Proposta</div>
                    <v-card>
                        <v-card-text class="grey lighten-3">
                            <VisualizarDiligenciaProposta
                                    :idPronac="idPronac"
                                    :diligencias="dados.diligenciaProposta"
                            >
                            </VisualizarDiligenciaProposta>
                        </v-card-text>
                    </v-card>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </template>
        <template>
            <v-expansion-panel popout>
                <v-expansion-panel-content
                >
                    <div slot="header">Diligência Adeqação Projeto</div>
                    <v-card>
                        <v-card-text class="grey lighten-3">
                            <VisualizarDiligenciaAdequacao
                                    :idPronac="idPronac"
                                    :diligencias="dados.diligenciaAdequacao"
                            >
                            </VisualizarDiligenciaAdequacao>
                        </v-card-text>
                    </v-card>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </template>

        <template>
            <v-expansion-panel popout>
                <v-expansion-panel-content
                >
                    <div slot="header">Diligência Projeto</div>
                    <v-card>
                        <v-card-text class="grey lighten-3">
                            <VisualizarDiligenciaProjeto
                                    :idPronac="idPronac"
                                    :diligencias="dados.diligenciaProjeto"
                            >
                            </VisualizarDiligenciaProjeto>
                        </v-card-text>
                    </v-card>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </template>
    </div>
</template>
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
<!--<legend>Dilig&ecirc;ncias da Adequa&ccedil;&atilde;o do Projeto</legend>-->
<!--<VisualizarDiligenciaAdequacao-->
<!--:idPronac="idPronac"-->
<!--:diligencias="dados.diligenciaAdequacao"-->
<!--&gt;-->
<!--</VisualizarDiligenciaAdequacao>-->
<!--</fieldset>-->
<!--</div>-->
<!--<div v-if="dados.diligenciaProjeto">-->
<!--<fieldset style="margin: 0px;">-->
<!--<legend>Dilig&ecirc;ncia Projeto</legend>-->
<!--<VisualizarDiligenciaProjeto-->
<!--:idPronac="idPronac"-->
<!--:diligencias="dados.diligenciaProjeto"-->
<!--&gt;-->
<!--</VisualizarDiligenciaProjeto>-->
<!--</fieldset>-->
<!--</div>-->


<script>
    import {mapGetters, mapActions} from 'vuex';
    import Carregando from '@/components/Carregando';
    import IdentificacaoProjeto from './IdentificacaoProjeto';
    import VisualizarDiligenciaProposta from './components/VisualizarDiligenciaProposta';
    import VisualizarDiligenciaAdequacao from './components/VisualizarDiligenciaAdequacao';
    import VisualizarDiligenciaProjeto from './components/VisualizarDiligenciaProjeto';

    export default {
        name: 'DiligenciaProjeto',
        components: {
            Carregando,
            IdentificacaoProjeto,
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

