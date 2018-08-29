<template>
    <div class="tabelas">
            <div class="row">
                <slTabelaSimples v-bind:dados="dado"></slTabelaSimples>
            </div>
    </div>
</template>
<script>
import slTabelaSimples from '@/components/slTabelaSimples';
import { mapActions, mapGetters } from 'vuex';

export default {
    name: 'PropostaFontesDeRecursos',
    props: ['idpreprojeto'],
    components: {
        slTabelaSimples,
    },
    mounted() {
        if (typeof this.idpreprojeto !== 'undefined') {
            this.buscaFontesDeRecursos(this.idpreprojeto);
        }
    },
    watch: {
        idpreprojeto(value) {
            this.buscaFontesDeRecursos(value);
        },
    },
    computed: {
        ...mapGetters({
            dado: 'proposta/fontesDeRecursos',
        }),
    },
    methods: {
        ...mapActions({
            buscaFontesDeRecursos: 'proposta/buscaFontesDeRecursos',
        }),
        // fetch(id) {
        //     if (id) {
        //         const self = this;
        //         /* eslint-disable */
        //         $3.ajax({
        //             url: '/proposta/visualizar/obter-fonte-de-recurso/idPreProjeto/' + id
        //         }).done(function (response) {
        //             self.dado = response.data;
        //         });

        //     }
        // },
    },
};
</script>
