<template>
    <div id="conteudo">
        <div v-if="loading">
            <Carregando :text="'Carregando Diligências do Projeto'"></Carregando>
        </div>
        <IdentificacaoProjeto
                :pronac="dadosProjeto.Pronac"
                :nomeProjeto="dadosProjeto.NomeProjeto"
        >
        </IdentificacaoProjeto>
        <ul class="collapsible collapsible-produto no-padding" data-collapsible="expandable">
            <li>
                <div class="collapsible-header green-text">
                    <i class="material-icons">perm_media</i> Diligência Proposta
                </div>
                <div class="collapsible-body no-padding margin10 scroll-x">
                    <VisualizarDiligenciaProposta
                            :idPronac="idPronac"
                            :diligencias="dados.diligenciaProposta"
                    >
                    </VisualizarDiligenciaProposta>
                </div>
            </li>
        </ul>

        <ul class="collapsible collapsible-produto no-padding" data-collapsible="expandable">
            <li>
                <div class="collapsible-header green-text">
                    <i class="material-icons">perm_media</i> Diligência Adeqação Projeto
                </div>
                <div class="collapsible-body no-padding margin10 scroll-x">
                    <VisualizarDiligenciaAdequacao
                            :idPronac="idPronac"
                            :diligencias="dados.diligenciaAdequacao"
                    >
                    </VisualizarDiligenciaAdequacao>
                </div>
            </li>
        </ul>
        <ul class="collapsible collapsible-produto no-padding" data-collapsible="expandable">
            <li>
                <div class="collapsible-header green-text">
                    <i class="material-icons">perm_media</i> Diligência Projeto
                </div>
                <div class="collapsible-body no-padding margin10 scroll-x">
                    <VisualizarDiligenciaProjeto
                            :idPronac="idPronac"
                            :diligencias="dados.diligenciaProjeto"
                    >
                    </VisualizarDiligenciaProjeto>
                </div>
            </li>
        </ul>

    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
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

