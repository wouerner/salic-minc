<template>
    <v-container fluid>
        <v-layout column>
            <v-flex xs9>
                <v-subheader>
                    <h2 class="grey--text text--darken-4">Painel de Readequações</h2>
                    <v-spacer/>
                    <h3
                        class="grey--text text--darken-4"
                    >{{ dadosProjeto.Pronac }} - {{ dadosProjeto.NomeProjeto }}</h3>
                </v-subheader>

                <div v-if="loading">
                    <Carregando :text="'Carregando readequações...'"/>
                </div>
                <v-tabs
                    v-else-if="getReadequacoesProponente"
                    color="#0a420e"
                    centered
                    dark
                    icons-and-text
                >
                    <v-tabs-slider color="yellow"/>
                    <v-tab href="#tab-1">Edição
                        <v-icon>edit</v-icon>
                    </v-tab>
                    <v-tab href="#tab-2">Em Análise
                        <v-icon>gavel</v-icon>
                    </v-tab>
                    <v-tab href="#tab-3">Finalizadas
                        <v-icon>check</v-icon>
                    </v-tab>
                    <v-tab-item :value="'tab-1'">
                        <v-card>
                            <TabelaReadequacoes
                                :dados-readequacao="getReadequacoesProponente"
                                :componentes="acoesProponente"
                                :dados-projeto="dadosProjeto"
                                :editar-item="editarItem"
                                @v-on:excluir-readequacao="excluirReadequacao"
                            />
                        </v-card>
                    </v-tab-item>

                    <v-tab-item :value="'tab-2'">
                        <v-card>
                            <TabelaReadequacoes
                                :dados-readequacao="getReadequacoesAnalise"
                                :componentes="acoesAnalise"
                                :dados-projeto="dadosProjeto"
                            />
                        </v-card>
                    </v-tab-item>
                    <v-tab-item :value="'tab-3'">
                        <v-card>
                            <TabelaReadequacoes
                                :dados-readequacao="getReadequacoesFinalizadas"
                                :componentes="acoesFinalizadas"
                                :dados-projeto="dadosProjeto"
                            />
                        </v-card>
                    </v-tab-item>
                </v-tabs>
                <CriarReadequacao
                    :id-pronac="dadosProjeto.idPronac"
                    @v-on:criar-readequacao="criarReadequacao"
                />
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';
import TabelaReadequacoes from '../components/TabelaReadequacoes';
import ExcluirButton from '../components/ExcluirButton';
import EditarReadequacaoButton from '../components/EditarReadequacaoButton';
import VisualizarReadequacaoButton from '../components/VisualizarReadequacaoButton';
import Carregando from '@/components/CarregandoVuetify';
import CriarReadequacao from '../components/CriarReadequacao';

export default {
    name: 'PainelReadequacoesView',
    components: {
        Carregando,
        TabelaReadequacoes,
        ExcluirButton,
        EditarReadequacaoButton,
        VisualizarReadequacaoButton,
        CriarReadequacao,
    },
    data() {
        return {
            listaStatus: ['proponente', 'analise', 'finalizadas'],
            acoesProponente: {
                usuario: '',
                acoes: [ExcluirButton, EditarReadequacaoButton, VisualizarReadequacaoButton],
            },
            acoesAnalise: {
                acoes: [VisualizarReadequacaoButton],
            },
            acoesFinalizadas: {
                acoes: [VisualizarReadequacaoButton],
            },
            editarItem: {},
            loading: true,
        };
    },
    computed: {
        ...mapGetters({
            getUsuario: 'autenticacao/getUsuario',
            getReadequacoesProponente: 'readequacao/getReadequacoesProponente',
            getReadequacoesAnalise: 'readequacao/getReadequacoesAnalise',
            getReadequacoesFinalizadas: 'readequacao/getReadequacoesFinalizadas',
            getReadequacao: 'readequacao/getReadequacao',
            dadosProjeto: 'projeto/projeto',
        }),
    },
    watch: {
        getReadequacoesProponente(value) {
            if (Object.keys(value).length > 0) {
                this.loading = false;
            }
        },
        getReadequacao() {
            this.editarItem = this.getReadequacao;
        },
    },
    created() {
        if (typeof this.$route.params.idPronac !== 'undefined') {
            this.idPronac = this.$route.params.idPronac;
            if (Object.keys(this.dadosProjeto).length === 0) {
                this.buscaProjeto(this.idPronac);
            }
        }
        this.listaStatus.forEach((stStatusAtual) => {
            this.obterReadequacoesPorStatus(stStatusAtual);
        });
    },
    methods: {
        ...mapActions({
            obterListaDeReadequacoes: 'readequacao/obterListaDeReadequacoes',
            buscaProjeto: 'projeto/buscaProjeto',
        }),
        obterReadequacoesPorStatus(stStatusAtual) {
            if (this.listaStatus.includes(stStatusAtual)) {
                this.obterListaDeReadequacoes({
                    idPronac: this.$route.params.idPronac,
                    stStatusAtual,
                });
            }
        },
        criarReadequacao() {
            if (this.dadosProjeto.idPronac !== '') {
                this.obterListaDeReadequacoes({
                    idPronac: this.dadosProjeto.idPronac,
                    stStatusAtual: 'proponente',
                });
            }
        },
        excluirReadequacao() {
            this.obterListaDeReadequacoes({ stStatusAtual: 'proponente' });
        },
    },
};
</script>
