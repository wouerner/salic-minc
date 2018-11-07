<template>
    <div>
        <v-data-table
                :headers="headers"
                :items="diligencias"
                class="elevation-1"
                rows-per-page-text="Items por Página"
                no-data-text="Nenhum dado encontrado"
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
                <td class="text-xs-center">{{ props.item.idPreprojeto }}</td>
                <td class="text-xs-center">{{ props.item.dataSolicitacao }}</td>
            </template>
            <template slot="pageText" slot-scope="props">
                Items {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
            </template>
        </v-data-table>
        <v-dialog
                v-model="dialog"
                width="1200px"
                transition="scale-transition"
        >
            <v-card>
                <v-card-text>
                    <tr>
                        <td colspan="3">
                            <template>
                                <table class="tabela">
                                    <tbody>
                                    <tr>
                                        <th>DATA DA SOLICITA&Ccedil;&Atilde;O</th>
                                        <th>DATA DA RESPOSTA</th>
                                    </tr>
                                    <tr>
                                        <td>{{ dadosDiligencia.dataSolicitacao }}</td>
                                        <td>{{ dadosDiligencia.dataResposta }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table v-if="dadosDiligencia.Solicitacao" class="tabela">
                                    <tbody>
                                    <tr>
                                        <th>SOLICITA&Ccedil;&Atilde;O</th>
                                    </tr>
                                    <tr>
                                        <td style="padding-left: 20px" v-html="dadosDiligencia.Solicitacao"></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table v-if="dadosDiligencia.Resposta" class="tabela">
                                    <tbody>
                                    <tr>
                                        <th>RESPOSTA:</th>
                                    </tr>
                                    <tr>
                                        <td style="padding-left: 20px" v-html="dadosDiligencia.Resposta"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </template>
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
        name: 'VisualizarDiligenciaProposta',
        props: ['idPronac', 'diligencias'],
        data() {
            return {
                dialog: false,
                headers: [
                    {
                        text: 'VISUALIZAR',
                        align: 'center',
                        sortable: false,
                        value: 'idPreprojeto',
                    },
                    {
                        text: 'NR PROPOSTA',
                        align: 'center',
                        value: 'idPreprojeto',
                    },
                    {
                        text: 'DATA DA SOLICITAÇÃO',
                        align: 'center',
                        value: 'dataSolicitacao',
                    },
                ],
            };
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dadosDiligencia: 'projeto/diligenciaProposta',
            }),
        },
        methods: {
            editItem(item) {
                const idPreprojeto = item.idPreprojeto;
                const valor = item.idAvaliacaoProposta;

                this.buscarDiligenciaProposta({ idPreprojeto, valor });
                this.dialog = true;
            },
            ...mapActions({
                buscarDiligenciaProposta: 'projeto/buscarDiligenciaProposta',
            }),
        },
    };
</script>

