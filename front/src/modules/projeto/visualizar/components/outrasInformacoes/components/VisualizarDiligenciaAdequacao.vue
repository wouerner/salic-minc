<template>
    <div>
        <v-data-table
                :headers="headers"
                :items="diligencias"
                class="elevation-1"
                rows-per-page-text="Items por Página"
        >
            <template slot="items" slot-scope="props">
                <td class="text-xs-center">
                    <v-btn flat icon>
                        <v-tooltip bottom>
                            <v-icon
                                    slot="activator"
                                    @click="editItem(props.item)"
                                    class="material-icons">visibility
                            </v-icon>
                            <span>Visualizar Projeto</span>
                        </v-tooltip>
                    </v-btn>
                </td>
                <td class="text-xs-center">{{ props.item.dtAvaliacao }}</td>
                <td class="text-xs-center">{{ props.item.tipoDiligencia }}</td>
            </template>
            <template slot="no-data">
                <v-alert :value="true" color="info" icon="warning">
                    Nenhum dado encontrado
                </v-alert>
            </template>
            <template slot="pageText" slot-scope="props">
                Items {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
            </template>
        </v-data-table>

        <v-dialog v-model="dialog" width="1000px">

            <v-card>
                <v-card-text>
                    <tr>
                        <td colspan="3">
                            <table v-if="dadosDiligencia.dsAvaliacao" class="tabela">
                                <tbody>
                                <tr>
                                    <th>SOLICITA&Ccedil;&Atilde;O</th>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px" v-html="dadosDiligencia.dsAvaliacao"></td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                            color="red"
                            flat
                            @click="dialog = false">
                        Fechar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: 'VisualizarDiligenciaAdequacao',
        props: ['idPronac', 'diligencias'],
        data() {
            return {
                dialog: false,
                headers: [
                    {
                        text: 'VISUALIZAR',
                        align: 'center',
                        sortable: false,
                        value: '',
                    },
                    {
                        text: 'DATA DA AVALIAÇÃO',
                        align: 'center',
                        value: 'dtAvaliacao',
                    },
                    {
                        text: 'TIPO DE DILIGÊNCIA',
                        align: 'center',
                        value: 'tipoDiligencia',
                    },
                ],
            };
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dadosDiligencia: 'projeto/diligenciaAdequacao',
            }),
        },
        methods: {
            editItem(item) {
                const idPronac = this.dadosProjeto.idPronac;
                const valor = item.idAvaliarAdequacaoProjeto;

                this.buscarDiligenciaAdequacao({ idPronac, valor });
                this.dialog = true;
            },
            ...mapActions({
                buscarDiligenciaAdequacao: 'projeto/buscarDiligenciaAdequacao',
            }),
        },
    };
</script>

