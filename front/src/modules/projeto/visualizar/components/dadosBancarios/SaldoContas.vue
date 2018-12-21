<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Saldo das Contas'"></Carregando>
        </div>
        <v-card v-else>
            <v-container fluid>
                <v-layout align-end justify-end reverse fill-height>
                    <v-flex xs6>
                        <v-combobox
                                v-model="search"
                                :items="items"
                                label="Tipo da Conta"
                                chips
                                solo
                        >
                            <template
                                    slot="selection"
                                    slot-scope="data"
                            >
                                <v-chip
                                        :selected="data.selected"
                                        :disabled="data.disabled"
                                        :key="JSON.stringify(data.item)"
                                        class="v-chip--select-multi"
                                        @input="data.parent.selectItem(data.item)"
                                >
                                    <v-avatar
                                            class="primary white--text"
                                            v-text="data.item.slice(0, 1).toUpperCase()"
                                    ></v-avatar>
                                    {{ data.item }}
                                </v-chip>
                            </template>
                        </v-combobox>
                    </v-flex>
                </v-layout>

                <v-data-table
                        :headers="headers"
                        :items="dadosSaldo"
                        :search="search"
                        class="elevation-1 container-fluid"
                        rows-per-page-text="Items por Página"
                        no-data-text="Nenhum dado encontrado"
                        :rows-per-page-items="[10, 25, 50, 100, {'text': 'Todos', value: -1}]"
                >
                    <template slot="items" slot-scope="props">
                        <td class="text-xs-left">{{ props.item.Tipo }}</td>
                        <td
                                class="text-xs-left"
                        >
                            {{ props.item.NrConta | FormatarNrConta }}
                        </td>
                        <td class="text-xs-left">{{ props.item.TipoSaldo }}</td>
                        <td class="text-xs-right">{{ props.item.dtSaldoBancario | FormatarData }}</td>
                        <td class="text-xs-right blue--text font-weight-bold"
                            v-if="props.item.vlSaldoBancario === 0"
                        >
                            {{ '0' | filtroFormatarParaReal }}
                        </td>
                        <td class="text-xs-right red--text font-weight-bold" v-else-if="props.item.stSaldoBancario !== 'C'">
                            {{ props.item.vlSaldoBancario | filtroFormatarParaReal }}
                        </td>
                        <td class="text-xs-right blue--text font-weight-bold" v-else>
                            {{ props.item.vlSaldoBancario | filtroFormatarParaReal }}
                        </td>

                        <td class="text-xs-right blue--text font-weight-bold"
                            v-if="props.item.stSaldoBancario === 'C'"
                        >
                            {{ props.item.stSaldoBancario }}
                        </td>
                        <td class="text-xs-right red--text font-weight-bold" v-else>
                            {{ props.item.stSaldoBancario }}
                        </td>
                    </template>
                    <template slot="pageText" slot-scope="props">
                        Items {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                    </template>
                    <v-alert slot="no-results" :value="true" color="error" icon="warning">
                        Sua busca por "{{ search }}" não encontrou nenhum resultado.
                    </v-alert>
                </v-data-table>
            </v-container>
        </v-card>
    </div>
</template>


<script>

    import { mapActions, mapGetters } from 'vuex';
    import Carregando from '@/components/CarregandoVuetify';
    import moment from 'moment';
    import planilhas from '@/mixins/planilhas';

    export default {
        name: 'SaldoContas',
        data() {
            return {
                items: [
                    'Captação',
                    'Movimentação',
                ],
                search: '',
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
                        align: 'left',
                        value: 'NrConta',
                    },
                    {
                        text: 'TIPO DE SALDO',
                        align: 'left',
                        value: 'TipoSaldo',
                    },
                    {
                        text: 'DATA SALDO',
                        align: 'center',
                        value: 'dtSaldoBancario',
                    },
                    {
                        text: 'VL. SALDO',
                        align: 'center',
                        value: 'vlSaldoBancario',
                    },
                    {
                        text: 'D/C',
                        align: 'center',
                        value: 'stSaldoBancario',
                    },
                ],
            };
        },
        mixins: [planilhas],
        components: {
            Carregando,
        },
        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                this.buscarSaldoContas(this.dadosProjeto.idPronac);
            }
        },
        watch: {
            dadosSaldo() {
                this.loading = false;
            },
        },
        filters: {
            FormatarData(date) {
                if (date.length === 0) {
                    return '-';
                }
                return moment(date).format('DD/MM/YYYY');
            },
            FormatarNrConta(valor) {
                return valor.replace(/^(\d{2})(\d{3})(\d{3})(\d{3})(\w{1})/, '$1.$2.$3.$4-$5');
            },
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dadosSaldo: 'projeto/saldoContas',
            }),
        },
        methods: {
            ...mapActions({
                buscarSaldoContas: 'projeto/buscarSaldoContas',
            }),
        },
    };
</script>
