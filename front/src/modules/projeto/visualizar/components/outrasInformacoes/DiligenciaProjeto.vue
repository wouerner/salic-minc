<template>
    <div id="conteudo">
        <IdentificacaoProjeto
                :pronac="dadosProjeto.Pronac"
                :nomeProjeto="dadosProjeto.NomeProjeto"
        >
        </IdentificacaoProjeto>
        <div v-if="dados.diligenciaProposta">
            <fieldset style="margin: 0px;">
                <legend>Dilig&ecirc;ncia Proposta</legend>
                <VisualizarDiligenciaProposta
                        :idPronac="idPronac"
                        :diligencias="dados.diligenciaProposta"
                >
                </VisualizarDiligenciaProposta>
            </fieldset>
        </div>
        <div v-if="dados.diligenciaAdequacao">
            <fieldset style="margin: 0px;">
                <legend>Dilig&ecirc;ncias da Adequa&ccedil;&atilde;o do Projeto</legend>
                <VisualizarDiligenciaAdequacao
                        :idPronac="idPronac"
                        :diligencias="dados.diligenciaAdequacao"
                >
                </VisualizarDiligenciaAdequacao>
            </fieldset>
        </div>
        <div v-if="dados.diligenciaProjeto">
            <fieldset style="margin: 0px;">
                <legend>Dilig&ecirc;ncia Projeto</legend>
                <VisualizarDiligenciaProjeto
                        :idPronac="idPronac"
                        :diligencias="dados.diligenciaProjeto"
                >
                </VisualizarDiligenciaProjeto>
            </fieldset>
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
                self.idPronac = self.$route.params.idPronac,
                /* eslint-disable */
                    $3.ajax({
                        url: '/projeto/diligencia-projeto-rest/index/idPronac/' + self.idPronac,
                    }).done(function (response) {
                        self.dados = response.data;
                    });
            },
        },
    };
</script>

