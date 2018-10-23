<template>
    <div id="conteudo">
        <IdentificacaoProjeto
            :pronac="dadosProjeto.Pronac"
            :nomeProjeto="dadosProjeto.NomeProjeto">
        </IdentificacaoProjeto>
        <PropostaPlanoDistribuicao
                :arrayProdutos="dados.planodistribuicaoproduto"
                :arrayDetalhamentos="dados.tbdetalhaplanodistribuicao">
        </PropostaPlanoDistribuicao>
    </div>
</template>
<script>
    import { mapGetters } from 'vuex';
    import PropostaPlanoDistribuicao from '@/modules/proposta/visualizar/components/PropostaPlanoDistribuicao';
    import IdentificacaoProjeto from './IdentificacaoProjeto';

    export default {
        name: 'PlanoDistribuicaoIn2017',
        props: ['idPronac'],
        components: {
            IdentificacaoProjeto,
            PropostaPlanoDistribuicao,
        },
        data() {
            return {
                dados: {
                    type: Object,
                    default() {
                        return {};
                    },
                },
            };
        },
        mounted() {
            if (typeof this.dadosProjeto.idPreProjeto !== 'undefined') {
                this.obterDados();
            }
        },
        watch: {
            dadosProjeto() {
                this.obterDados();
            },
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
            }),
        },
        methods: {
            obterDados() {
                const self = this;
                /* eslint-disable */
                $3.ajax({
                    url: '/projeto/plano-distribuicao-rest/index/idPreProjeto/' + self.dadosProjeto.idPreProjeto,
                }).done(function (response) {
                    self.dados = response.data;
                });
            },
        },
    };
</script>
