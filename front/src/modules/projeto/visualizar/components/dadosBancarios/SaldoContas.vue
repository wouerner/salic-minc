<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Saldo das Contas'"></Carregando>
        </div>
        <div v-else-if="dadosSaldo">
            <v-data-table
                    :headers="headers"
                    :items="dadosSaldo"
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
                    <td class="text-xs-right" v-if="props.item.vlSaldoBancario === 0">
                        {{ '0' | filtroFormatarParaReal }}
                    </td>
                    <td v-else class="text-xs-right">
                        {{ props.item.vlSaldoBancario | filtroFormatarParaReal }}
                    </td>

                    <td class="text-xs-right blue--text"
                        v-if="props.item.stSaldoBancario === 'C'">
                        {{ props.item.stSaldoBancario }}
                    </td>
                    <td v-else="">
                        {{ props.item.stSaldoBancario }}
                    </td>
                </template>
                <template slot="pageText" slot-scope="props">
                    Items {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                </template>
            </v-data-table>
        </div>
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
                        text: 'DT. SALDO',
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
                        value: 'vlDebitado',
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
                console.log(valor);
                return valor.replace(/^(\d{2})(\d{3})(\d{3})(\d{3})(\d{1})/, "$1.$2.$3.$4-$5");
            }
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

