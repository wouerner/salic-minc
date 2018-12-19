<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Extratos Bancários'"></Carregando>
        </div>
        <div v-else>
            <v-card>
                <template>
                    <v-layout row wrap>
                        <v-flex xs12 sm6 md4>
                            <v-menu
                                ref="menu"
                                :close-on-content-click="false"
                                v-model="menu"
                                :nudge-right="40"
                                :return-value.sync="date"
                                lazy
                                transition="scale-transition"
                                offset-y
                                full-width
                                min-width="290px"
                            >
                                <v-text-field
                                slot="activator"
                                v-model="datestring"
                                label="Escolha a data inicial"
                                prepend-icon="event"
                                readonly
                                ></v-text-field>
                                <v-date-picker
                                    class="calendario-vuetify"
                                    :max="new Date().toISOString().substr(0, 10)"
                                    v-model="date"
                                    no-title
                                    scrollable
                                >
                                    <v-spacer></v-spacer>
                                    <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                                    <v-btn flat color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-flex>
                    </v-layout>
                </template>
                <v-card-title>
                    <v-select
                        v-model="search"
                        :items="tpConta"
                        item-text="text"
                        item-value="id"
                        label="Tipo Conta"
                    ></v-select>
                    <v-spacer></v-spacer>
                </v-card-title>
                <v-data-table
                        :headers="headers"
                        :items="dadosExtratosBancarios"
                        class="elevation-1 container-fluid"
                        rows-per-page-text="Items por Página"
                        :pagination.sync="pagination"
                        :rows-per-page-items="[10, 25, 50, {'text': 'Todos', value: -1}]"
                        no-data-text="Nenhum dado encontrado"
                        no-results-text="Nenhum dado encontrado"
                        :search="search"
                >
                    <template slot="items" slot-scope="props">
                        <td class="text-xs-left" v-html="props.item.Tipo"></td>
                        <td class="text-xs-right">{{ props.item.NrConta | formatarConta }}</td>
                        <td class="text-xs-right">{{ props.item.cdLancamento }}</td>
                        <td class="text-xs-left" v-html="props.item.Lancamento"></td>
                        <td class="text-xs-right">{{ props.item.nrLancamento }}</td>
                        <td class="text-xs-right">{{ props.item.dtLancamento | FormatarData }}</td>
                        <td class="text-xs-right">{{ props.item.vlLancamento | filtroFormatarParaReal }}</td>
                        <td class="text-xs-right">{{ props.item.stLancamento }}</td>
                    </template>
                    <template slot="pageText" slot-scope="props">
                        Items {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                    </template>
                </v-data-table>
            </v-card>
            
        </div>
    </div>
</template>
<script>

    import { mapActions, mapGetters } from 'vuex';
    import Carregando from '@/components/CarregandoVuetify';
    import { utils } from '@/mixins/utils';
    import moment from 'moment';

    export default {
        name: 'ExtratosBancarios',
        data() {
            return {
                search: '',
                tpConta: [
                    {
                        id:'Captação',
                        text:'Captação'
                    },
                    {
                        id:'Movimentação',
                        text:'Movimentação'
                    },
                    {
                        id:'',
                        text:'Todos'
                    }
                ],
                date: new Date().toISOString().substr(0, 10),
                menu: false,
                datestring:'',
                pagination: {
                    sortBy: 'fat',
                },
                selected: [],
                loading: true,
                headers: [
                    {
                        text: 'TIPO DA CONTA',
                        align: 'left',
                        value: 'Tipo',
                    },
                    {
                        text: 'NR. CONTA',
                        align: 'center',
                        value: 'NrConta',
                    },
                    {
                        text: 'CÓDIGO',
                        align: 'center',
                        value: 'cdLancamento',
                    },
                    {
                        text: 'LANÇAMENTO',
                        align: 'center',
                        value: 'Lancamento',
                    },
                    {
                        text: 'NR. LANÇAMENTO',
                        align: 'left',
                        value: 'nrLancamento',
                    },
                    {
                        text: 'DT. LANÇAMENTO',
                        align: 'center',
                        value: 'dtLancamento',
                    },
                    {
                        text: 'VL. LANÇAMENTO',
                        align: 'center',
                        value: 'vlLancamento',
                    },
                    {
                        text: 'D/C',
                        align: 'center',
                        value: 'stLancamento',
                    },
                ],
            };
        },
        mixins: [utils],
        components: {
            Carregando,
        },
        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                this.buscarExtratosBancarios(this.dadosProjeto.idPronac);
                this.loading = false;
            }
        },
        filters: {
            FormatarData(date) {
                if (date != null && date.length === 0) {
                    return '-';
                }
                return moment(date).format('DD/MM/YYYY');
            },
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dadosExtratosBancarios: 'projeto/extratosBancarios',
            }),
        },
        watch: {
            date(val) {
                this.datestring = this.formatDate(val);
                console.log(val);
            }
        },
        methods: {
            ...mapActions({
                buscarExtratosBancarios: 'projeto/buscarExtratosBancarios',
            }),
            formatDate(str) {
                if (str != null) {
                    return str.substring(8, 10)+'/'+str.substring(5, 7)+'/'+str.substring(0, 4);
                }
                return '';
            },
        },
    };
</script>
