<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Carregando Diligências do Projeto'"></Carregando>
        </div>


        <v-flex>
            <v-expansion-panel popout focusable>
                <v-expansion-panel-content>
                    <div slot="header" class="green-text">
                        Diligência Proposta
                    </div>
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

                <v-expansion-panel-content>
                    <div slot="header" class="green-text">
                        Diligências da Adequação do Projeto
                    </div>
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

                <v-expansion-panel-content>
                    <div slot="header" class="green-text">
                        Diligência Projeto
                    </div>
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
        </v-flex>
    </div>

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

