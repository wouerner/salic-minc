<template>
    <div class="tabelas">
        <div class="row">
            <slTabelaSimples v-bind:dados="dado"></slTabelaSimples>
        </div>
    </div>
</template>
<script>

export default {
    name: 'PropostaHistoricoSolicitacoes',
    data() {
        return {
            dado: [],
        };
    },
    props: ['idpreprojeto'],
    mounted() {
        if (typeof this.idpreprojeto !== 'undefined') {
            this.fetch(this.idpreprojeto);
        }
    },
    watch: {
        idpreprojeto(value) {
            this.fetch(value);
        },
    },
    methods: {
        fetch(id) {
            if (id) {
                const self = this;
                /* eslint-disable */
                $3.ajax({
                    url: '/solicitacao/mensagem/historico-solicitacoes/idPreProjeto/' + id
                }).done(function (response) {
                    self.dado = response.data;
                });
            }
        },
    }
};
</script>