<template>
    <div class="tabelas">
            <div class="row">
                <slTabelaSimples v-bind:dados="dado"></slTabelaSimples>
            </div>
    </div>
</template>
<script>
import slTabelaSimples from '@/components/slTabelaSimples';

export default {
    name: 'slPropostaHistoricoAvaliacoes',
    data: function () {
        return {
            dado: []
        }
    },
    props: ['idpreprojeto'],
    components: {
        slTabelaSimples,
    },
    mounted: function () {
        if (typeof this.idpreprojeto != 'undefined') {
            this.fetch(this.idpreprojeto);
        }
    },
    watch: {
        idpreprojeto: function (value) {
            this.fetch(value);
        }
    },
    methods: {
        fetch: function (id) {
            if (id) {
                let vue = this;
                $3.ajax({
                    url: '/proposta/visualizar/obter-historico-avaliacoes/idPreProjeto/' + id
                }).done(function (response) {
                    vue.dado = response.data;
                });
            }
        },
    }
};
</script>