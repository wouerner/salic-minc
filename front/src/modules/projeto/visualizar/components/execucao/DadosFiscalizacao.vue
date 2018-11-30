<template>
    <div>
        <v-data-table
            :headers="headers"
            :items="dadosListagem"
            class="elevation-1 container-fluid"
            rows-per-page-text="Items por Página"
            hide-actions
            no-data-text="Nenhum dado encontrado"
        >
            <template slot="items" slot-scope="props">
                <td class="text-xs-center" v-html="props.item.dtInicio"></td>
                <td class="text-xs-center">{{ props.item.dtFim }}</td>
                <td class="text-xs-center">{{ props.item.cpfTecnico }}</td>
                <td class="text-xs-center">{{ props.item.nmTecnico }}</td>
                <td class="text-xs-center">
                    <v-btn flat icon>
                        <v-tooltip bottom>
                            <v-icon
                                    slot="activator"
                                    @click="showItem(props.item.idFiscalizacao)"
                                    class="material-icons"
                                    dark>visibility
                            </v-icon>
                            <span>Visualizar Dados Fiscalizacao</span>
                        </v-tooltip>
                    </v-btn>
                </td></template>
        </v-data-table>
        <v-layout row justify-center>
            <VisualizarFiscalizacao
                :dadosVisualizacao="dadosVisualizacao"
                :dialog="dialog"></VisualizarFiscalizacao>
        </v-layout>
    </div>
</template>
<script>

    import { mapActions, mapGetters } from 'vuex';
    import VisualizarFiscalizacao from './components/VisualizarFiscalizacao';

    export default {
        name: 'DadosFiscalizacao',
        data() {
            return {
                dialog: false,
                loading: true,
                headers: [
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
                    {
                        text: 'VISUALIZAR',
                        align: 'center',
                        sortable: false,
                        value: 'dados',
                    },
                ],
            };
        },
        components: {
            VisualizarFiscalizacao,
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

                this.modalOpen(true);
                this.buscarDadosFiscalizacaoVisualiza({ idPronac, idFiscalizacao });
            },
            ...mapActions({
                buscarDadosFiscalizacaoLista: 'projeto/buscarDadosFiscalizacaoLista',
                buscarDadosFiscalizacaoVisualiza: 'projeto/buscarDadosFiscalizacaoVisualiza',
                modalOpen: 'modal/modalOpen',
            }),
        },
    };
</script>

