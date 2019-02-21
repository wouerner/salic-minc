<template>
<v-container fluid>
    <v-layout column >

        <v-flex xs9>
            <v-subheader>
                <h2>Nome do Projeto</h2>
            </v-subheader>

            <v-card>
                <TabelaReadequacoes
                :dados="getReadequacoes"
                >
                </TabelaReadequacoes>
            </v-card>
        </v-flex>
    </v-layout>
</v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import TabelaReadequacoes from '../components/TabelaReadequacoes';

    export default {
        name: 'PainelReadequacoesView',
        components: {
            TabelaReadequacoes,
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
