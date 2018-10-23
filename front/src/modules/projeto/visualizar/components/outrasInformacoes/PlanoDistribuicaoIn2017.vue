<template>
    <div id="conteudo">
        <IdentificacaoProjeto
            :pronac="dadosProjeto.Pronac"
            :nomeProjeto="dadosProjeto.NomeProjeto">
        </IdentificacaoProjeto>
        <PropostaPlanoDistribuicao
                :arrayProdutos="dadosIn2017.planodistribuicaoproduto"
                :arrayDetalhamentos="dadosIn2017.tbdetalhaplanodistribuicao">
        </PropostaPlanoDistribuicao>
    </div>
</template>
<script>
    import { mapGetters, mapActions } from 'vuex';
    import PropostaPlanoDistribuicao from '@/modules/proposta/visualizar/components/PropostaPlanoDistribuicao';
    import IdentificacaoProjeto from './IdentificacaoProjeto';

    export default {
        name: 'PlanoDistribuicaoIn2017',
        props: ['idPronac'],
        components: {
            IdentificacaoProjeto,
            PropostaPlanoDistribuicao,
        },
        mounted() {
            if (typeof this.dadosProjeto.idPreProjeto !== 'undefined') {
                this.buscarPlanoDistribuicaoIn2017(this.dadosProjeto.idPreProjeto);
            }
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
            })
        },
    };
</script>
