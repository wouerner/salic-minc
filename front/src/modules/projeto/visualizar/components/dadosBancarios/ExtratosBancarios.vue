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
                            >
                            {{ validaCampo().desc }}
                        </v-alert>
                    </div>
                    <div v-if="validaCampo().id === 3">
                        <v-alert
                            :value="true"
                            type="success"
                            >
                            {{ validaCampo().desc }}
                        </v-alert>
                    </div>
                </span>
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
                                label="Escolha a data inicial da Pesquisa"
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
                                    <v-btn flat color="primary" @click="validaCampo();$refs.menu.save(date)">OK</v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-flex>

                        <v-flex xs12 sm6 md4>
                            <v-menu
                                ref="menuFim"
                                :close-on-content-click="false"
                                v-model="menuFim"
                                :nudge-right="40"
                                :return-value.sync="dateFim"
                                lazy
                                transition="scale-transition"
                                offset-y
                                full-width
                                min-width="290px"
                            >
                                <v-text-field
                                slot="activator"
                                v-model="datestringFim"
                                label="Escolha a data Final da Pesquisa"
                                prepend-icon="event"
                                readonly
                                ></v-text-field>
                                <v-date-picker
                                    class="calendario-vuetify"
                                    :max="new Date().toISOString().substr(0, 10)"
                                    v-model="dateFim"
                                    no-title
                                    scrollable
                                >
                                    <v-spacer></v-spacer>
                                    <v-btn flat color="primary" @click="menuFim = false">Cancel</v-btn>
                                    <v-btn flat color="primary" @click="validaCampo();$refs.menuFim.save(dateFim)">OK</v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-flex>
                        <div class="pt-4 pl-4">
                            <v-btn color="teal" class="white--text" :change="validaCampo().validacao" :disabled="!validaCampo().validacao">Pesquisar</v-btn>
                        </div>
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
                dateFim: new Date().toISOString().substr(0, 10),
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
                this.buscarExtratosBancarios(this.dadosProjeto.idPronac);
                this.loading = false;
            }
            // this.validaCampo();
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
            },
            dateFim(val) {
                this.datestringFim = this.formatDate(val);
                console.log(val);
            },
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
            validaCampo() {
                // this.menu = true;
                let status = {
                    desc: '',
                    validacao: false,
                    id: 0
                };
                if( this.datestring === '' && this.datestringFim === '') {
                    console.log('ahahah');
                    status = { desc: 'hahaaa', validacao: false, id: 2 };
                    return status;
                }
                if( this.datestring === '' && this.datestringFim !== '') {
                    console.log('primeiro preencher data inicial');
                    status = { desc: 'preencher data inicial', validacao: false, id: 1 };
                    return status;
                }
                else if(this.datestring !== '' && this.datestringFim === '') {
                    console.log('segundo agora Escolha a data final');
                    status = { desc: 'agora Escolha a data final', validacao: false, id: 1 };
                    return status;
                }
                if(this.datestring !== '' &&  this.datestringFim !== '') {
                    if( Date.parse(this.datestring) > Date.parse(this.datestringFim)){
                        console.log('data inicial nao pode ser maior que data final');
                        status = { desc: 'data inicial nao pode ser maior que data final', validacao: false, id: 1 };
                        return status;
                    }
                    else if ( !(Date.parse(this.datestring) < Date.parse(this.datestringFim))) {
                        console.log('data final nao pode ser menor que data inicial222222');
                        status = { desc: 'data final nao pode ser menor que data inicial2222', validacao: false, id: 1 };
                        return status;
                    }
                }
                // if(this.datestring !== '' &&  this.datestringFim !== '' && Date.parse(this.datestring) > !Date.parse(this.datestringFim)) {
                //     console.log('data inicial nao pode ser maior que data final');
                //     status = { desc: 'data inicial nao pode ser maior que data final', validacao: false };
                //     return status;
                // }
                console.log('tudo certo:'+Date.parse(this.datestring),'Tudo certo fim:' + Date.parse(this.datestringFim));
                status = { desc: 'tudo certo', validacao: true, id: 3 };
                return status;

            },
        },
    };
</script>
