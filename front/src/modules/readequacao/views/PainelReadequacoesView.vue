<template>
<v-container fluid>
    <v-layout column >

        <v-flex xs9>
            <v-subheader>
                <h2>Projeto: 7º Festival do Japão do Rio Grande do Sul - 217336</h2>
            </v-subheader>


        <v-tabs
            color="#0a420e"
            centered
            dark
            icons-and-text
        >
            <v-tabs-slider color="yellow"></v-tabs-slider>

            <v-tab href="#tab-1">
            Edição
            <v-icon>edit</v-icon>
            </v-tab>

            <v-tab href="#tab-2">
            Em Análise
            <v-icon>gavel</v-icon>
            </v-tab>

            <v-tab href="#tab-3">
            Finalizadas
            <v-icon>check</v-icon>
            </v-tab>

            <v-tab-item
            :value="'tab-1'"
            >
                <v-card>
                    <TabelaReadequacoes
                    :dados="getReadequacoesProponente"
                    :componentes="acoesProponente"
                    >
                    </TabelaReadequacoes>
                </v-card>
            </v-tab-item>

            <v-tab-item
            :value="'tab-2'"
            >
                <v-card>
                    <TabelaReadequacoes
                    :dados="getReadequacoesAnalise"
                    >
                    </TabelaReadequacoes>
                </v-card>

            </v-tab-item>
                        <v-tab-item
            :value="'tab-3'"
            >
                <v-card>
                    <TabelaReadequacoes
                    :dados="getReadequacoesFinalizadas"
                    >
                    </TabelaReadequacoes>
                </v-card>
            </v-tab-item>
        </v-tabs>

    </v-flex>
</v-layout>
</v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import TabelaReadequacoes from '../components/TabelaReadequacoes';
import ExcluirButton from '../components/ExcluirButton';
import EditarReadequacaoButton from '../components/EditarReadequacaoButton'

    export default {
    name: 'PainelReadequacoesView',
    components: {
        TabelaReadequacoes,
        ExcluirButton,
        EditarReadequacaoButton,
    },
    data() {
    return {
        listaStatus: [
            'proponente',
            'analise',
            'finalizadas'
        ],
        acoesProponente: {
            usuario: '',
            acoes: [ExcluirButton, EditarReadequacaoButton],
        },
    }
    },
    computed: {
        ...mapGetters({
            getUsuario: 'autenticacao/getUsuario',
            getReadequacoesProponente: 'readequacao/getReadequacoesProponente',
            getReadequacoesAnalise: 'readequacao/getReadequacoesAnalise',
            getReadequacoesFinalizadas: 'readequacao/getReadequacoesFinalizadas',
        }),
    },
    created() {
        this.listaStatus.forEach(status => {
            this.obterReadequacoesPorStatus(status);
        });
    },
    methods: {
        ...mapActions({
            obterListaDeReadequacoes: 'readequacao/obterListaDeReadequacoes',
        }),
        obterReadequacoesPorStatus(status) {
            if (this.listaStatus.includes(status)) {
                const idPronac = this.$route.params.idPronac;
                this.obterListaDeReadequacoes({ idPronac, status });
            }
        },
    },
};
</script>
