<template>
    <div class="tabelas">
        <div class="row">
            <slTabelaSimples v-bind:dados="dados"></slTabelaSimples>
        </div>
    </div>
</template>
<script>
import slTabelaSimples from '@/components/slTabelaSimples';

export default {
    name: 'slPropostaCustosVinculados',
    data() {
        return {
            dados: [],
        };
    },
    props: ['idpreprojeto', 'arrayCustos'],
    components: {
        slTabelaSimples,
    },
    mounted() {
        if (typeof this.idpreprojeto !== 'undefined') {
            this.buscar_dados(this.idpreprojeto);
        }

        if (typeof this.arrayCustos !== 'undefined') {
            this.dados = this.arrayCustos;
        }
    },
    watch: {
        idpreprojeto(value) {
            this.buscar_dados(value);
        },
        arrayCustos(value) {
            this.dados = value;
        },
    },
    methods: {
        buscar_dados(id) {
            if (id) {
                const self = this;
                /* eslint-disable */
                $3.ajax({
                    url: '/proposta/visualizar/obter-custos-vinculados/idPreProjeto/' + id
                }).done(function (response) {
                    self.dados = response.data;
                });
            }
        },
    },
};
</script>