<template>
    <div>
        <v-data-table
            :headers="headers"
            :items="dadosListagem"
            class="elevation-1 container-fluid"
            rows-per-page-text="Items por Página"
            hide-actions
        >
            <template slot="items" slot-scope="props">
                <td class="text-xs-center">
                    <v-btn flat icon>
                        <v-tooltip bottom>
                            <v-icon
                                    slot="activator"
                                    @click="showItem(props.item.idFiscalizacao)"
                                    class="material-icons"
                                    color="green"
                                    dark>add
                            </v-icon>
                            <span>Visualizar Dados Fiscalizacao</span>
                        </v-tooltip>
                    </v-btn>
                </td>
                <td class="text-xs-center" v-html="props.item.dtInicio"></td>
                <td class="text-xs-center">{{ props.item.dtFim }}</td>
                <td class="text-xs-center">{{ props.item.cpfTecnico }}</td>
                <td class="text-xs-center">{{ props.item.nmTecnico }}</td>
            </template>
        </v-data-table>
        <v-layout row justify-center>
            <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
            <v-card>
                <v-toolbar dark color="primary">
                    <v-btn icon dark @click="dialog = false">
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Dados Fiscalizacao Completos</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-container style="max-width: 100%;">

                    <v-timeline>
                        <v-timeline-item
                        fill-dot
                        left
                        >
                            <v-card>
                                <v-card-title class="primary justify-center">
                                <h2 class="display-1 white--text font-weight-light">Locais</h2>
                                </v-card-title>
                                <v-container>
                                    <v-layout>
                                        <v-flex xs4 offset-xs1>
                                            <p><b>REGIAO</b></p>
                                        </v-flex>
                                        <v-flex xs4 offset-xs1>
                                            <p><b>UF</b></p>
                                        </v-flex>
                                        <v-flex xs4 offset-xs1>
                                            <p><b>CIDADE</b></p>
                                        </v-flex>
                                    </v-layout>
                                    <v-layout v-for="(dado, index) in dadosVisualizacao.locaisFiscalizacao" :key="index">
                                        <v-flex xs4 offset-xs1>
                                            <p>{{ dado.regiao }}</p>
                                        </v-flex>
                                        <v-flex xs4 offset-xs1>
                                            <p>{{ dado.uf }}</p>
                                        </v-flex>
                                        <v-flex xs4 offset-xs1>
                                            <p>{{ dado.cidade }}</p>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card>
                        </v-timeline-item>
                        <v-timeline-item
                        fill-dot
                        right
                        >
                            <v-card>
                                <v-card-title class="primary justify-center">
                                    <h2 class="display-1 white--text font-weight-light">Oficializar Fiscalização</h2>
                                </v-card-title>
                            </v-card>
                        </v-timeline-item>
                        <v-timeline-item
                        color="amber lighten-1"
                        fill-dot
                        right
                        small
                        >
                            <v-card>
                                <v-card-title class="amber lighten-1">
                                <h2 class="display-1 mr-3 white--text font-weight-light">Datas / Demandante</h2>
                                </v-card-title>
                                <v-container v-for="(dado, index) in dadosVisualizacao.oficializarFiscalizacao" :key="index">
                                    <v-layout >
                                        <v-flex xs6 offset-xs2>
                                            <p><b>Dt. Inicio</b></p>
                                            {{ dado.dtInicio }} <br>
                                        </v-flex>
                                        <v-flex xs6 offset-xs2>
                                            <p><b>Dt. Fim</b></p>
                                            {{ dado.dtFim }} <br>
                                        </v-flex>
                                    </v-layout>
                                    <v-layout >
                                        <v-flex xs6 offset-xs2>
                                            <br><p><b>Demandante da Fiscalização</b></p>
                                            <p v-if="dado.tpDemandante == 0" class="pl-5 justify-center">SEFIC</p>
                                            <p v-else-if="dado.tpDemandante == 1">SAV</p>
                                        </v-flex>
                                        <v-flex xs6 offset-xs2>
                                            <br><p><b>Data de Resposta</b></p>
                                            <p v-if="dado.dtResposta.length > 1"> {{ dado.dtResposta }} </p>
                                            <p v-else-if="dado.dtResposta.length == 1" class="pl-5 justify-center"> - </p>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card>
                        </v-timeline-item>
                        <v-timeline-item
                        fill-dot
                        right
                        small
                        >
                        <v-card>
                            <v-card-title style="background-color: #44CC38;">
                                <h2 class="display-1 white--text font-weight-light">Identificação do Técnico</h2>
                            </v-card-title>
                            <v-container v-for="(dado, index) in dadosVisualizacao.oficializarFiscalizacao" :key="index">
                                <v-layout>
                                    <v-flex xs6 offset-xs2>
                                        <p><b>CPF</b></p>
                                        {{ dado.cpfTecnico }} <br>
                                    </v-flex>
                                    <v-flex xs6 offset-xs2>
                                        <p><b>Técnico</b></p>
                                        {{ dado.nmTecnico }} <br>
                                    </v-flex>
                                </v-layout>
                                <v-layout>
                                    <v-flex xs10 offset-xs4>
                                        <br><p><b>Dados para Fiscalização</b></p>
                                        {{ dado.dsFiscalizacaoProjeto }}    
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card>
                        </v-timeline-item>

                        <v-timeline-item
                        color="amber lighten-1"
                        fill-dot
                        left
                        small
                        >
                        <v-card>
                            <v-card-title class="amber lighten-1 justify-end">
                            <h2 class="display-1 mr-3 white--text font-weight-light">Title 2</h2>
                            </v-card-title>
                            <v-container>
                            <v-layout>
                                <v-flex xs8>
                                Lorem ipsum dolor sit amet, no nam oblique veritus. Commune scaevola imperdiet nec ut, sed euismod convenire principes at. Est et nobis iisque percipit.
                                </v-flex>
                                <v-flex xs4>
                                Lorem ipsum dolor sit amet, no nam oblique veritus.
                                </v-flex>
                            </v-layout>
                            </v-container>
                        </v-card>
                        </v-timeline-item>

                        <v-timeline-item
                        color="cyan lighten-1"
                        fill-dot
                        right
                        >
                        <v-card>
                            <v-card-title class="cyan lighten-1">
                            <h2 class="display-1 white--text font-weight-light">Title 3</h2>
                            </v-card-title>
                            <v-container>
                            <v-layout>
                                <v-flex
                                v-for="n in 3"
                                :key="n"
                                xs4
                                >
                                Lorem ipsum dolor sit amet, no nam oblique veritus no nam oblique.
                                </v-flex>
                            </v-layout>
                            </v-container>
                        </v-card>
                        </v-timeline-item>

                        <v-timeline-item
                        color="red lighten-1"
                        fill-dot
                        left
                        small
                        >
                        <v-card>
                            <v-card-title class="red lighten-1 justify-end">
                            <h2 class="display-1 mr-3 white--text font-weight-light">Title 4</h2>
                            </v-card-title>
                            <v-container>
                            <v-layout>
                                <v-flex>
                                Lorem ipsum dolor sit amet, no nam oblique veritus. Commune scaevola imperdiet nec ut, sed euismod convenire principes at. Est et nobis iisque percipit, an vim zril disputando voluptatibus.
                                </v-flex>
                            </v-layout>
                            </v-container>
                        </v-card>
                        </v-timeline-item>

                        <v-timeline-item
                        color="green lighten-1"
                        fill-dot
                        right
                        >
                        <v-card>
                            <v-card-title class="green lighten-1">
                            <h2 class="display-1 white--text font-weight-light">Title 5</h2>
                            </v-card-title>
                            <v-container>
                            <v-layout>
                                <v-flex>
                                Lorem ipsum dolor sit amet, no nam oblique veritus. Commune scaevola imperdiet nec ut, sed euismod convenire principes at. Est et nobis iisque percipit, an vim zril disputando voluptatibus, vix an salutandi sententiae.
                                </v-flex>
                            </v-layout>
                            </v-container>
                        </v-card>
                        </v-timeline-item>
                    </v-timeline>
                </v-container>
            </v-card>
            </v-dialog>
        </v-layout>
    </div>
</template>
<script>

    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: 'DadosFiscalizacao',
        data() {
            return {
                dialog: false,
                loading: true,
                headers: [
                    {
                        text: 'VISUALIZAR',
                        align: 'center',
                        sortable: false,
                        value: 'dados',
                    },
                    {
                        text: 'DT. INICIO',
                        align: 'center',
                        value: 'dtInicio',
                    },
                    {
                        text: 'DT. FIM',
                        align: 'center',
                        value: 'dtFim',
                    },
                    {
                        text: 'CPF TECNICO',
                        align: 'center',
                        value: 'cpfTecnico',
                    },
                    {
                        text: 'NOME TECNICO',
                        align: 'center',
                        value: 'nmTecnico',
                    },
                ],
            };
        },
        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                this.buscarDadosFiscalizacaoLista(this.dadosProjeto.idPronac);
            }
        },
        watch: {
            dadosListagem() {
                this.loading = false;
            },
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dadosListagem: 'projeto/dadosFiscalizacaoLista',
                dadosVisualizacao: 'projeto/dadosFiscalizacaoVisualiza',
            }),
        },
        methods: {
            showItem(idFiscalizacao) {
                const idPronac = this.dadosProjeto.idPronac;

                this.buscarDadosFiscalizacaoVisualiza({ idPronac, idFiscalizacao });
                this.dialog = true;

            },
            ...mapActions({
                buscarDadosFiscalizacaoLista: 'projeto/buscarDadosFiscalizacaoLista',
                buscarDadosFiscalizacaoVisualiza: 'projeto/buscarDadosFiscalizacaoVisualiza',
            }),
        },
    };
</script>

