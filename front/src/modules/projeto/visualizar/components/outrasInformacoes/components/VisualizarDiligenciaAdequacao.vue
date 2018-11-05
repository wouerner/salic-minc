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

        <!--<table class="tabela" v-if="Object.keys(diligencias).length > 0">-->
        <!--<thead>-->
        <!--<tr class="destacar">-->
        <!--<th>VISUALIZAR</th>-->
        <!--<th>DATA DA AVALIA&Ccedil;&Atilde;O</th>-->
        <!--<th>TIPO DE DILIG&Ecirc;NCIA</th>-->
        <!--</tr>-->
        <!--</thead>-->
        <!--<tbody v-for="(diligencia, index) in diligencias" :key="index">-->
        <!--<tr>-->
        <!--<td class="center">-->
        <!--<v-btn outline-->
        <!--slot="activator"-->
        <!--@click="setAbaAtiva(diligencia, index)"-->
        <!--color="green"-->
        <!--&gt;-->
        <!--<i class="material-icons">visibility</i>-->
        <!--</v-btn>-->
        <!--</td>-->
        <!--<td>{{ diligencia.dtAvaliacao }}</td>-->
        <!--<td>{{ diligencia.tipoDiligencia }}</td>-->
        <!--</tr>-->
        <!---->
        <!--</tbody>-->
        <!--</table>-->
        <!--<div v-else class="center">-->
        <!--<em>Dados n&atilde;o informado.</em>-->
        <!--</div>-->
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';

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
            //
            // setAbaAtiva(value, index) {
            //     if (this.abaAtiva === index) {
            //         this.ativo = !this.ativo;
            //     } else {
            //         this.abaAtiva = index;
            //         this.ativo = true;
            //
            //         const valor = value.idAvaliarAdequacaoProjeto;
            //         const idPronac = this.dadosProjeto.idPronac;
            //
            //         this.buscarDiligenciaAdequacao({idPronac, valor});
            //     }
            // },
            ...mapActions({
                buscarDiligenciaAdequacao: 'projeto/buscarDiligenciaAdequacao',
            }),
        },
    };
</script>

