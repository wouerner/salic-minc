<template>
    <v-container grid-list-xl>
        <v-form v-model="valid">
            <v-dialog v-model="dialog" hide-overlay transition="dialog-bottom-transition">
                <v-btn slot="activator" color="green" dark>Emitir Parecer</v-btn>
                <v-card>
                    <v-toolbar dark color="green">
                        <v-btn icon dark :href="redirectLink">
                            <v-icon>close</v-icon>
                        </v-btn>
                        <v-toolbar-title>Avaliação de Resultados - Visualizar Parecer</v-toolbar-title>
                    </v-toolbar>
                    <v-container grid-list-sm>
                        <v-layout row wrap>
                            <v-flex xs12 sm12 md12>
                                <p><b>Projeto:</b> {{projeto.AnoProjeto}}{{projeto.Sequencial}} - {{projeto.NomeProjeto}}</p>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                                <p><b>Proponente:</b> {{proponente.CgcCpf | cnpjFilter}} - {{proponente.Nome}}</p>
                            </v-flex>
                        </v-layout>
                        <v-divider></v-divider>
                    </v-container>
                    <h2 class="text-sm-center">Parecer de avaliação do cumprimento do objeto</h2>
                    <v-container grid-list-sm>
                        <v-layout row wrap>
                            <v-flex xs10 sm3 md3 >
                                <div>
                                    <p class="text-sm-right"><b>Manifestação</b>{{dados.manifestacao}}</p>
                                </div>
                            </v-flex>
                            <v-flex xs10 sm3 md3 >
                                <div>
                                    <p class="text-sm-right"><b>Parecer</b>{{dados.dsParecer}}</p>
                                </div>
                            </v-flex>
                        </v-layout>
                        <v-divider></v-divider>
                    </v-container>
                    <h2 class="text-sm-center">Parecer técnico de avaliação financeira</h2>
                    <v-container grid-list-sm>
                        <v-layout row wrap>
                            <v-flex xs10 sm3 md3 >
                                <div>
									<p class="text-sm-right"><b>Manifestação</b>{{dados.manifestacaofinanceira}}</p>
                                </div>
                            </v-flex>
                            <v-flex xs10 sm3 md3 >
                                <div>
									<p class="text-sm-right"><b>Parecer</b>{{dados.parecerfinanceira}}</p>
                                </div>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card>
            </v-dialog>
        </v-form>
    </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import ModalTemplate from '@/components/modal';
import cnpjFilter from '@/filters/cnpj';

export default {
    name: 'VisualizarParecer',
    data() {
        return {
            tipo: true,
            idPronac: this.$route.params.id,
            redirectLink: '#/planilha/',
            valid: false,
            dialog: true,
            itemRules: [
                v => !!v || 'Tipo de manifestação e obrigatório!',
            ],
            parecerRules: [
                v => !!v || 'Parecer e obrigatório!',
                v => v.length >= 10 || 'Parecer deve conter mais que 10 characters',
            ],
            items: [
                {
                    id: 'R',
                    text: 'Reprovação',
                },
                {
                    id: 'A',
                    text: 'Aprovação',
                },
                {
                    id: 'P',
                    text: 'Aprovação com Ressalva',
                },
            ],
            parecerData: { },
        };
    },
    components:
    {
        ModalTemplate,
    },
    methods:
    {
        ...mapActions({
            requestEmissaoParecer: 'avaliacaoResultados/getDadosEmissaoParecer',
            salvar: 'avaliacaoResultados/salvarParecer',
            finalizar: 'avaliacaoResultados/finalizarParecer',
            alterarParecer: 'avaliacaoResultados/alterarParecer',
        }),
        fecharModal() {
            this.modalClose();
        },
        getConsolidacao(id) {
            this.requestEmissaoParecer(id);
        },
        salvarParecer() {
            const data = {
                idPronac: this.idPronac,
                tpAvaliacaoFinanceira: this.tipo,
                siManifestacao: this.getParecer.siManifestacao,
                dsParecer: this.getParecer.dsParecer,
            };

            if (this.parecer.idAvaliacaoFinanceira) {
                data.idAvaliacaoFinanceira = this.parecer.idAvaliacaoFinanceira;
            }

            if (this.parecerData.siManifestacao) {
                data.siManifestacao = this.parecerData.siManifestacao;
            }

            if (this.parecerData.dsParecer) {
                data.dsParecer = this.parecerData.dsParecer;
            }

            this.salvar(data);
            /** Descomentar linha após migração da lista para o VUEJS */
            // this.dialog = false;
        },
        finalizarParecer() {
            const data = {
                idPronac: this.idPronac,
                tpAvaliacaoFinanceira: this.tipo,
                siManifestacao: this.parecer.siManifestacao,
                dsParecer: this.parecer.dsParecer,
                atual: 5,
                proximo: 6,
            };

            this.finalizar(data);
        },
        inputParecer(e) {
            this.parecerData.dsParecer = e;
        },
        inputManifestacao(e) {
            this.parecerData.siManifestacao = e;
        },
    },
    computed:
    {
        ...mapGetters({
            modalVisible: 'modal/default',
            consolidacaoComprovantes: 'avaliacaoResultados/consolidacaoComprovantes',
            proponente: 'avaliacaoResultados/proponente',
            parecer: 'avaliacaoResultados/parecer',
            projeto: 'avaliacaoResultados/projeto',
            getParecer: 'avaliacaoResultados/parecer',
        }),
    },
    mounted() {
        this.redirectLink = this.redirectLink + this.idPronac;
        this.getConsolidacao(this.idPronac);
    },
    filters: {
        cnpjFilter,
    },
};
</script>
