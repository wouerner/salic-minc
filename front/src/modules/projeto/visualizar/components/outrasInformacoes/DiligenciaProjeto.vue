<template>
    <div id="conteudo">
            <IdentificacaoProjeto
                :pronac="dadosProjeto.Pronac"
                :nomeProjeto="dadosProjeto.NomeProjeto"
            >
            </IdentificacaoProjeto>
            <div v-if="dados.diligenciaProposta">
                <div v-if="dados.diligenciaProposta.length > 0">
                    <fieldset>
                        <legend>Dilig&ecirc;ncia Proposta</legend>
                            <VisualizarDiligenciaProposta
                                :idPronac="idPronac"
                                :infos="dados.diligenciaProposta"
                            >
                            </VisualizarDiligenciaProposta>
                    </fieldset>
                </div>
            </div>
            <div v-if="dados.diligenciaAdequacao">
                <div v-if="dados.diligenciaAdequacao.length > 0">
                    <fieldset>
                        <legend>Dilig&ecirc;ncias da Adequa&ccedil;&atilde;o do Projeto</legend>
                        <VisualizarDiligenciaAdequacao
                                :idPronac="idPronac"
                                :infos="dados.diligenciaAdequacao"
                            >
                            </VisualizarDiligenciaAdequacao>
                    </fieldset>
                </div>
            </div>
            <div v-if="dados.diligenciaProjeto">
                <div v-if="dados.diligenciaProjeto.length > 0">
                    <fieldset>
                        <legend>Dilig&ecirc;ncia Projeto</legend>
                        <VisualizarDiligenciaProjeto
                                :idPronac="idPronac"
                                :infos="dados.diligenciaProjeto"
                            >
                        </VisualizarDiligenciaProjeto>
                    </fieldset>
                </div>
            </div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
import IdentificacaoProjeto from './IdentificacaoProjeto';
import VisualizarDiligenciaProposta from './components/VisualizarDiligenciaProposta';
import VisualizarDiligenciaAdequacao from './components/VisualizarDiligenciaAdequacao';
import VisualizarDiligenciaProjeto from './components/VisualizarDiligenciaProjeto';


export default {
    name: 'DiligenciaProjeto',
    components: {
        IdentificacaoProjeto,
        VisualizarDiligenciaProposta,
        VisualizarDiligenciaAdequacao,
        VisualizarDiligenciaProjeto,
    },
    data() {
        return {
            dados: {
                    type: Object,
                    default() {
                        return {};
                    },
                },
            idPronac: {},
        };
    },
    mounted() {
        if (typeof this.$route.params.idPronac !== 'undefined') {
            this.buscar_dados();
        }
    },
    computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
            }),
        },
    methods: {
        buscar_dados() {
            const self = this;
            self.idPronac = self.$route.params.idPronac
            /* eslint-disable */
            $3.ajax({
                url: '/projeto/diligencia-projeto-rest/index/idPronac/' + self.idPronac,
            }).done(function (response) {
                self.dados = response.data;
            });
        },
    },
}
</script>

