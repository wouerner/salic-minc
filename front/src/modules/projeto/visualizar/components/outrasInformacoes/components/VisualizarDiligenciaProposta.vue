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
                <td class="text-xs-center">{{ props.item.idPreprojeto }}</td>
                <td class="text-xs-center">{{ props.item.dataSolicitacao }}</td>
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
        <!--<table class="tabela" v-if="Object.keys(diligencias).length > 0">-->
            <!--<thead>-->
            <!--<tr class="destacar">-->
                <!--<th>VISUALIZAR</th>-->
                <!--<th>NR PROPOSTA</th>-->
                <!--<th>DATA DA SOLICITA&Ccedil;&Atilde;O</th>-->
            <!--</tr>-->
            <!--</thead>-->
            <!--<tbody v-for="(diligencia, index) in diligencias" :key="index">-->
            <!--<tr>-->
                <!--<td class="center">-->
                    <!--<button-->
                            <!--class="waves-effect waves-darken btn white black-text"-->
                            <!--@click="setAbaAtiva(diligencia, index)"-->
                    <!--&gt;-->
                        <!--<i class="material-icons">visibility</i>-->
                    <!--</button>-->
                <!--</td>-->
                <!--<td>{{ diligencia.idPreprojeto }}</td>-->
                <!--<td>{{ diligencia.dataSolicitacao }}</td>-->
            <!--</tr>-->
            <!---->
            <!---->
            <!---->
            <!--<tr v-if="abaAtiva === index && ativo && Object.keys(dadosDiligencia).length > 2">-->
                <!--<td colspan="3">-->
                    <!--<template>-->
                        <!--<table class="tabela">-->
                            <!--<tbody>-->
                            <!--<tr>-->
                                <!--<th>Nr PROPOSTA</th>-->
                                <!--<th>NOME DA PROPOSTA</th>-->
                            <!--</tr>-->
                            <!--<tr>-->
                                <!--<td>{{ dadosDiligencia.idPreprojeto }}</td>-->
                                <!--<td>{{ dadosDiligencia.nomeProjeto }}</td>-->
                            <!--</tr>-->
                            <!--<tr>-->
                                <!--<th>DATA DA SOLICITA&Ccedil;&Atilde;O</th>-->
                                <!--<th>DATA DA RESPOSTA</th>-->
                            <!--</tr>-->
                            <!--<tr>-->
                                <!--<td>{{ dadosDiligencia.dataSolicitacao }}</td>-->
                                <!--<td>{{ dadosDiligencia.dataResposta }}</td>-->
                            <!--</tr>-->
                            <!--</tbody>-->
                        <!--</table>-->
                        <!--<table v-if="dadosDiligencia.Solicitacao" class="tabela">-->
                            <!--<tbody>-->
                            <!--<tr>-->
                                <!--<th>SOLICITA&Ccedil;&Atilde;O</th>-->
                            <!--</tr>-->
                            <!--<tr>-->
                                <!--<td style="padding-left: 20px" v-html="dadosDiligencia.Solicitacao"></td>-->
                            <!--</tr>-->
                            <!--</tbody>-->
                        <!--</table>-->
                        <!--<table v-if="dadosDiligencia.Resposta" class="tabela">-->
                            <!--<tbody>-->
                            <!--<tr>-->
                                <!--<th>RESPOSTA:</th>-->
                            <!--</tr>-->
                            <!--<tr>-->
                                <!--<td style="padding-left: 20px" v-html="dadosDiligencia.Resposta"></td>-->
                            <!--</tr>-->
                            <!--</tbody>-->
                        <!--</table>-->
                    <!--</template>-->
                <!--</td>-->
            <!--</tr>-->
            <!---->
            <!---->
            <!--</tbody>-->
        <!--</table>-->

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
                // console.log(dados);
                const idPreprojeto = item.idPreprojeto;
                const valor = item.idAvaliacaoProposta;

                this.buscarDiligenciaProposta({ idPreprojeto , valor });
                this.dialog = true;
            },

            // setAbaAtiva(value, index) {
            //     if (this.abaAtiva === index) {
            //         this.ativo = !this.ativo;
            //     } else {
            //         this.abaAtiva = index;
            //         this.ativo = true;
            //         this.buscarDiligenciaProposta(value);
            //     }
            // },
            ...mapActions({
                buscarDiligenciaProposta: 'projeto/buscarDiligenciaProposta',
            }),
        },
    };
</script>

