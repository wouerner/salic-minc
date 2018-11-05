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
                <td class="text-xs-center" v-if="props.item.produto">
                    {{ props.item.produto }}
                </td>
                <td v-else class="text-xs-center"> -</td>
                <td class="text-xs-center">{{ props.item.tipoDiligencia }}</td>
                <td class="text-xs-center">{{ props.item.dataSolicitacao }}</td>
                <td class="text-xs-center">{{ props.item.dataResposta }}</td>
                <td class="text-xs-center">{{ props.item.prazoResposta }}</td>
                <td class="text-xs-center">Prorrogado</td>
            </template>
            <template slot="no-data">
                <v-alert :value="true" color="error" icon="warning">
                    Nenhum dado encontrado ¯\_(ツ)_/¯
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
                        <td colspan="7">
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
                            <table class="tabela"
                                   v-if="dadosDiligencia.arquivos && Object.keys(dadosDiligencia.arquivos).length > 0">
                                <tbody>
                                <tr>
                                    <th colspan="3">Arquivos Anexados</th>
                                </tr>
                                <tr>
                                    <td class="destacar bold" align="center">Arquivo</td>
                                    <td class="destacar bold" align="center">Dt.Envio</td>
                                </tr>
                                <tr v-for="arquivo of dadosDiligencia.arquivos" :key="arquivo.idArquivo">
                                    <td>
                                        <a :href="`/upload/abrir?id=${arquivo.idArquivo}`" target="_blank">
                                            {{ arquivo.nmArquivo }}
                                        </a>
                                    </td>
                                    <td align="center">
                                        {{ arquivo.dtEnvio }}
                                    </td>
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
    import { mapGetters, mapActions } from 'vuex';

    export default {
        name: 'VisualizarDiligenciaProjeto',
        props: ['idPronac', 'diligencias'],
        data() {
            return {
                dialog: false,
                abaAtiva: -1,
                ativo: false,
                headers: [
                    {
                        text: 'VISUALIZAR',
                        align: 'center',
                        sortable: false,
                        value: 'produto',
                    },
                    {
                        text: 'PRODUTO',
                        align: 'center',
                        value: 'produto',
                    },
                    {
                        text: 'TIPO DE DILIGÊNCIA',
                        align: 'center',
                        value: 'tipoDiligencia',
                    },
                    {
                        text: 'DATA DA SOLICITAÇÃO',
                        align: 'center',
                        value: 'dataSolicitacao',
                    },
                    {
                        text: 'DATA DA RESPOSTA',
                        align: 'center',
                        value: 'dataResposta',
                    },
                    {
                        text: 'PRAZO DA RESPOSTA',
                        align: 'center',
                        value: 'prazoResposta',
                    },
                    {
                        text: 'PRORROGADO',
                        value: 'prorrogado',
                        sortable: false,
                        align: 'center',
                    },
                ],
            };
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dadosDiligencia: 'projeto/diligenciaProjeto',
            }),
        },
        methods: {
            editItem(item) {
                const idPronac = this.dadosProjeto.idPronac;
                const valor = item.idDiligencia;

                this.buscarDiligenciaProjeto({ idPronac, valor });
                this.dialog = true;
            },
            // setAbaAtiva(value, index) {
            //     console.log(value, index);
            //     if (this.abaAtiva === index) {
            //         this.ativo = !this.ativo;
            //     } else {
            //         this.abaAtiva = index;
            //         this.ativo = true;
            //
            //         const valor = value.idDiligencia;
            //         const idPronac = this.dadosProjeto.idPronac;
            //
            //         this.buscarDiligenciaProjeto({idPronac, valor});
            //     }
            // },
            ...mapActions({
                buscarDiligenciaProjeto: 'projeto/buscarDiligenciaProjeto',
            }),
        },
    };
</script>

