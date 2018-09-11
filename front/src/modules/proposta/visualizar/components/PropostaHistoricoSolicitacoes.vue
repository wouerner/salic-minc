<template>
    <div>
        {{dado}}
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
                    url: '/solicitacao/mensagem-rest/historico-solicitacoes/idPreProjeto/' + 282175
                }).done(function (response) {
                    console.log(response);
                    self.dado = response.data;
                });
            }
        },
    }
};
</script>
