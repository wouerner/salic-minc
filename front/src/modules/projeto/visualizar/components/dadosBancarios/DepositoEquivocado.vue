<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Depósito Equivocado'"></Carregando>
        </div>
        <div v-else>
            <v-card>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex xs12 lg6>
                            <v-menu
                                    ref="menu"
                                    :close-on-content-click="false"
                                    v-model="menu1"
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
                                        scrollable
                                        locale="pt-br"
                                        @input="menu1 = false"
                                >
                                </v-date-picker>
                            </v-menu>
                        </v-flex>
                        <v-flex xs12 lg6>
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
                                        scrollable
                                        locale="pt-br"
                                        @input="menuFim = false"
                                >
                                </v-date-picker>
                            </v-menu>
                        </v-flex>
                    </v-layout>
                </v-container>
                <v-data-table
                        :headers="headers"
                        :items="filteredItems()"
                        class="elevation-1 container-fluid"
                        rows-per-page-text="Items por Página"
                        :pagination.sync="pagination"
                        :rows-per-page-items="[10, 25, 50, {'text': 'Todos', value: -1}]"
                        no-data-text="Nenhum dado encontrado"
                        no-results-text="Nenhum dado encontrado"
                >
                    <template slot="items" slot-scope="props">
                        <td class="text-xs-left" v-html="props.item.Nome"></td>
                        <td class="text-xs-right">{{ props.item.dtCredito | formatarData }}</td>
                        <td class="text-xs-right">{{ props.item.dtLote | formatarData }}</td>
                        <td class="text-xs-right">{{ props.item.vlDeposito | filtroFormatarParaReal }}</td>
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

    export default {
        name: 'DepositoEquivocado',
        data() {
            return {
                dtLote: null,
                date: '',
                modal: false,
                menu1: false,
                menu2: false,
                datestring: '',
                dateFim: '',
                menuFim: false,
                datestringFim: '',
                search: '',
                pagination: {
                    sortBy: 'fat',
                },
                selected: [],
                loading: true,
                headers: [
                    {
                        text: 'INCENTIVADOR',
                        align: 'left',
                        value: 'Nome',
                    },
                    {
                        text: 'DT. CRÉDITO',
                        align: 'center',
                        value: 'dtCredito',
                    },
                    {
                        text: 'DT. DEVOLUÇÃO',
                        align: 'center',
                        value: 'dtLote',
                    },
                    {
                        text: 'VL. CAPTADO',
                        align: 'center',
                        value: 'vlDeposito',
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
                this.buscarDepositoEquivocado(this.dadosProjeto.idPronac);
            }
        },
        watch: {
            dadosDepositoEquivocado() {
                this.loading = false;
            },
            date(val) {
                this.datestring = this.formatDate(val);
            },
            dateFim(val) {
                this.datestringFim = this.formatDate(val);
            },
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dadosDepositoEquivocado: 'projeto/depositoEquivocado',
            }),
        },
        methods: {
            ...mapActions({
                buscarDepositoEquivocado: 'projeto/buscarDepositoEquivocado',
            }),
            filteredItems() {
                const filtroInicioData = new Date(this.datestring);
                const filtroFimData = new Date(this.datestringFim);

                if (isNaN(filtroInicioData.getTime()) || isNaN(filtroFimData.getTime())) {
                    return this.dadosDepositoEquivocado;
                }
                return this.dadosDepositoEquivocado.filter((row) => {
                    const dtLoteTimeStamp = new Date(row.dtLote);
                    return (
                        (dtLoteTimeStamp.getTime() >= filtroInicioData.getTime()) &&
                        (dtLoteTimeStamp.getTime() <= filtroFimData.getTime()));
                });
            },
            formatDate(date) {
                if (!date) return null;

                const [year, month, day] = date.split('-');
                return `${day}/${month}/${year}`;
            },
            parseDate(date) {
                if (!date) return null;

                const [day, month, year] = date.split('/');
                return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
            },
        },
    };
</script>
