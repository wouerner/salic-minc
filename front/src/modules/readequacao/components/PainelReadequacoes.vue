<template>
    <TabelaReadequacoes
    :dados="getReadequacoes"
      >
      </TabelaReadequacoes>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import TabelaReadequacoes from './TabelaReadequacoes';

    export default {
        name: 'PainelReadequacoes',
        components: {
            TabelaReadequacoes,
        },
        props: {
        },
        data() {
            return {
            }
        },
        computed: {
            ...mapGetters({
                getUsuario: 'autenticacao/getUsuario',
                getReadequacoes: 'readequacao/getReadequacoes',
            }),
        },
        created() {
            const idPronac = this.$route.params.idPronac;
            this.obterListaDeReadequacoes(idPronac);
        },
        methods: {
            ...mapActions({
                obterListaDeReadequacoes: 'readequacao/obterListaDeReadequacoes',
            }),
        },
    };
</script>
