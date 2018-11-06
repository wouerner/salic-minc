<template>
    <div id="conteudo">
        <div v-if="loading">
            <Carregando :text="'Carregando Plano de Distribuicao'"></Carregando>
        </div>
        <div v-else>
            <PropostaPlanoDistribuicao
                    :arrayProdutos="dadosIn2017.planodistribuicaoproduto"
                    :arrayDetalhamentos="dadosIn2017.tbdetalhaplanodistribuicao">
            </PropostaPlanoDistribuicao>
        </div>
    </div>
</template>
<script>
    import { mapGetters, mapActions } from 'vuex';
    import Carregando from '@/components/Carregando';
    import PropostaPlanoDistribuicao from '@/modules/proposta/visualizar/components/PropostaPlanoDistribuicao';

    export default {
        name: 'PlanoDistribuicaoIn2017',
        props: ['idPronac'],
        data() {
            return {
                loading: true,
            };
        },
        components: {
            Carregando,
            PropostaPlanoDistribuicao,
        },
        mounted() {
            if (typeof this.dadosProjeto.idPreProjeto !== 'undefined') {
                this.buscarPlanoDistribuicaoIn2017(this.dadosProjeto.idPreProjeto);
            }
        },
        watch: {
            dadosIn2017() {
                this.loading = false;
            },
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dadosIn2017: 'projeto/planoDistribuicaoIn2017',
            }),
        },
        methods: {
            ...mapActions({
                buscarPlanoDistribuicaoIn2017: 'projeto/buscarPlanoDistribuicaoIn2017',
            }),
        },
    };
</script>
