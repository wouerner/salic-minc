<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Extratos Bancários'"></Carregando>
        </div>
        <div v-else>
            <v-card>
                <span v-if="validaCampo().desc !== ''" color="alert">
                    <div v-if="validaCampo().id === 1">
                        <v-alert
                            :value="true"
                            type="warning"
                            class="black--text"
                            >
                            {{ validaCampo().desc }}
                        </v-alert>
                    </div>
                </span>
                <template>
                    <v-container fluid>
                        <v-layout row wrap>
                            <v-flex xs12 sm6 md4>
                                <v-menu
                                    ref="menu"
                                    :close-on-content-click="false"
                                    v-model="menu"
                                    :nudge-right="40"
                                    lazy
                                    transition="scale-transition"
                                    offset-y
                                    full-width
                                    min-width="290px"
                                >
                                    <v-text-field
                                        slot="activator"
                                        v-model="datestring"
                                        label="Escolha a data inicial da Pesquisa"
                                        prepend-icon="event"
                                        @blur="date = parseDate(datestring)"
                                        mask="##/##/####"
                                        return-masked-value
                                    ></v-text-field>
                                    <v-date-picker
                                        class="calendario-vuetify"
                                        :max="new Date().toISOString().substr(0, 10)"
                                        v-model="date"
                                        no-title
                                        scrollable
                                        locale="pt-br"
                                        @input="menu = false"
                                    >
                                    </v-date-picker>
                                </v-menu>
                            </v-flex>

                            <v-flex xs12 sm6 md4>
                                <v-menu
                                    ref="menuFim"
                                    :close-on-content-click="false"
                                    v-model="menuFim"
                                    :nudge-right="40"
                                    lazy
                                    transition="scale-transition"
                                    offset-y
                                    full-width
                                    min-width="290px"
                                    class="pl-4"
                                >
                                    <v-text-field
                                        slot="activator"
                                        v-model="datestringFim"
                                        label="Escolha a data Final da Pesquisa"
                                        prepend-icon="event"
                                        @blur="dateFim = parseDate(datestringFim)"
                                        mask="##/##/####"
                                        return-masked-value
                                    ></v-text-field>
                                    <v-date-picker
                                        class="calendario-vuetify"
                                        :max="new Date().toISOString().substr(0, 10)"
                                        v-model="dateFim"
                                        no-title
                                        scrollable
                                        locale="pt-br"
                                        @input="menuFim = false"
                                    >
                                    </v-date-picker>
                                </v-menu>
                            </v-flex>
                            <div class="pt-4 pl-4">
                                <v-btn color="teal" class="white--text" :disabled="!validaCampo().validacao" @click="filtrarData()">Pesquisar</v-btn>
                            </div>
                        </v-layout>
                        <v-layout>
                            <v-flex xs4>
                                <v-select
                                    v-model="search"
                                    :items="tpConta"
                                    item-text="text"
                                    item-value="id"
                                    label="Tipo Conta"
                                ></v-select>
                                <v-spacer></v-spacer>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </template>
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
                        <td class="text-xs-right">{{ props.item.dtLancamento | formatarData }}</td>
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
                date: '',
                menu: false,
                datestring: '',
                dateFim: '',
                menuFim: false,
                datestringFim:'',
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
                const params = {
                    idPronac: this.dadosProjeto.idPronac,
                    dtLancamento: '',
                    dtLancamentoFim: '',
                    tpConta: '',
                };
                this.buscarExtratosBancarios(params);
                this.loading = false;
            }
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
            },
            dateFim(val) {
                this.datestringFim = this.formatDate(val);
            },
        },
        methods: {
            ...mapActions({
                buscarExtratosBancarios: 'projeto/buscarExtratosBancarios',
            }),
            formatDate (date) {
                if (!date) return null

                const [year, month, day] = date.split('-')
                return `${day}/${month}/${year}`
            },
            parseDate (date) {
                if (!date) return null

                const [day, month, year] = date.split('/')
                return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
            },
            filtrarData() {
                const params = {
                    idPronac: this.dadosProjeto.idPronac,
                    dtLancamento: this.date,
                    dtLancamentoFim: this.dateFim,
                    tpConta: ''
                };

                this.buscarExtratosBancarios(params);
            },
            filtrarTipoConta() {
                const params = {
                    idPronac: this.dadosProjeto.idPronac,
                    dtLancamento: '',
                    dtLancamentoFim: '',
                    tpConta: this.search
                };
                if (params.tpConta === 'Captação') {
                    params.tpConta = 'captacao';
                }
                if (params.tpConta === 'Movimentação') {
                    params.tpConta = 'movimentacao';
                }

                this.buscarExtratosBancarios(params);
            },
            validaCampo() {
                let status = {
                    desc: '',
                    validacao: false,
                    id: 0
                };
                if( this.date === '' && this.dateFim === '') {
                    status = { desc: 'hahaaa', validacao: false, id: 2 };
                    return status;
                }
                if( this.date === '' && this.dateFim !== '') {
                    status = { desc: 'preencher data inicial', validacao: false, id: 1 };
                    return status;
                }
                else if(this.date !== '' && this.dateFim === '') {
                    status = { desc: 'agora Escolha a data final', validacao: false, id: 1 };
                    return status;
                }
                if( this.date === this.dateFim ) {
                    status = { desc: 'hahaaa', validacao: true, id: 3 };
                    return status;
                }
                if(this.date !== '' &&  this.dateFim !== '') {
                    if( Date.parse(this.date) > Date.parse(this.dateFim)){
                        status = { desc: 'data inicial nao pode ser maior que data final', validacao: false, id: 1 };
                        return status;
                    }
                    else if ( !(Date.parse(this.date) < Date.parse(this.dateFim))) {
                        status = { desc: 'data final nao pode ser menor que data inicial', validacao: false, id: 1 };
                        return status;
                    }
                }
                
                status = { desc: 'tudo certo', validacao: true, id: 3 };
                return status;

            },
        },
    };
</script>
