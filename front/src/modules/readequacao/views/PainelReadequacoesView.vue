<template>
<v-container fluid>
  <v-layout column >
    
    <v-flex xs9>
      <v-subheader>
	<h2 class="grey--text text--darken-4">
	  Painel de Readequações
	</h2>
	<v-spacer/>
        <h3 class="grey--text text--darken-4">
	  {{ dadosProjeto.Pronac }} - {{ dadosProjeto.NomeProjeto }}
	</h3>
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
		    :dadosProjeto="dadosProjeto"
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
                    :componentes="acoesAnalise"
		    :dadosProjeto="dadosProjeto"
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
                    :componentes="acoesFinalizadas"
		    :dadosProjeto="dadosProjeto"
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
import EditarReadequacaoButton from '../components/EditarReadequacaoButton';

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
	acoesAnalise: {
	    acoes: [],
	},
	acoesFinalizadas: {
	    acoes: [],
	},
    }
    },
    computed: {
        ...mapGetters({
            getUsuario: 'autenticacao/getUsuario',
            getReadequacoesProponente: 'readequacao/getReadequacoesProponente',
            getReadequacoesAnalise: 'readequacao/getReadequacoesAnalise',
            getReadequacoesFinalizadas: 'readequacao/getReadequacoesFinalizadas',
            dadosProjeto: 'projeto/projeto',
        }),
    },
    created() {
        if (typeof this.$route.params.idPronac !== 'undefined') {
            this.idPronac = this.$route.params.idPronac;
            if (Object.keys(this.dadosProjeto).length === 0) {
                this.buscaProjeto(this.idPronac);
            }
        }
        this.listaStatus.forEach(status => {
            this.obterReadequacoesPorStatus(status);
        });
    },
    methods: {
        ...mapActions({
            obterListaDeReadequacoes: 'readequacao/obterListaDeReadequacoes',
	    buscaProjeto: 'projeto/buscaProjeto',
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
