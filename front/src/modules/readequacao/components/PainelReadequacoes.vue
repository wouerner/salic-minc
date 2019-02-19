<template>
    <TabelaReadequacoes
    :dados="getReadequacoes"
    :componentes="listaAcoesProponente"
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
                listaAcoesProponente: {
                    atual: '',
                    proximo: '',
                    acoes: [],
                },
            }
        },
        computed: {
            ...mapGetters({
                getUsuario: 'autenticacao/getUsuario',
                getReadequacoes: 'readequacao/getReadequacoes',
            }),
        },
        created() {
            this.obterListaDeReadequacoes(14100);
        },
        methods: {
            ...mapActions({
                obterListaDeReadequacoes: 'readequacao/obterListaDeReadequacoes',
            }),
        },
    };
</script>
