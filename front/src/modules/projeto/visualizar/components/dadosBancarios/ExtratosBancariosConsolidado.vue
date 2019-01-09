<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Extratos Bancários Consolidado'"></Carregando>
        </div>
        <v-card v-else>
            <FiltroTipoConta
                v-on:eventoSearch="search = $event"
            >
            </FiltroTipoConta>
            <v-data-table
                    :headers="headers"
                    :items="dadosExtratosConsolidado"
                    class="elevation-1 container-fluid"
                    rows-per-page-text="Items por Página"
                    :pagination.sync="pagination"
                    :rows-per-page-items="[10, 25, 50, {'text': 'Todos', value: -1}]"
                    no-data-text="Nenhum dado encontrado"
                    no-results-text="Nenhum dado encontrado"
                    :search="search"
            >
                <template slot="items" slot-scope="props">
                    <td class="text-xs-left" v-html="props.item.TipoConta"></td>
                    <td class="text-xs-right">{{ props.item.NrConta | formatarConta }}</td>
                    <td class="text-xs-right">{{ props.item.Codigo }}</td>
                    <td class="text-xs-left" v-html="props.item.Lancamento"></td>

                    <td class="text-xs-right blue--text font-weight-bold"
                        v-if="props.item.stLancamento === 'C'"
                    >
                        {{ props.item.vlLancamento | filtroFormatarParaReal }}
                    </td>
                    <td class="text-xs-right red--text font-weight-bold" v-else>
                        {{ props.item.vlLancamento | filtroFormatarParaReal }}
                    </td>

                    <td class="text-xs-right blue--text font-weight-bold"
                        v-if="props.item.stLancamento === 'C'"
                    >
                        {{ props.item.stLancamento }}
                    </td>
                    <td class="text-xs-right red--text font-weight-bold" v-else>
                        {{ props.item.stLancamento }}
                    </td>
                </template>
                <template slot="pageText" slot-scope="props">
                    Items {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                </template>
                <v-alert slot="no-results" :value="true" color="error" icon="warning">
                    Sua busca por "{{ search }}" não encontrou nenhum resultado.
                </v-alert>
            </v-data-table>
        </v-card>
    </div>
</template>
<script>

    import { mapActions, mapGetters } from 'vuex';
    import Carregando from '@/components/CarregandoVuetify';
    import { utils } from '@/mixins/utils';
    import FiltroTipoConta from './components/FiltroTipoConta';

    export default {
        name: 'ExtratosBancariosConsolidado',
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
                        value: 'TipoConta',
                    },
                    {
                        text: 'NR. CONTA',
                        align: 'center',
                        value: 'NrConta',
                    },
                    {
                        text: 'CÓDIGO',
                        align: 'center',
                        value: 'Codigo',
                    },
                    {
                        text: 'LANÇAMENTO',
                        align: 'left',
                        value: 'Lancamento',
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
            FiltroTipoConta,
        },
        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                this.buscarExtratosBancariosConsolidado(this.dadosProjeto.idPronac);
            }
        },
        watch: {
            dadosExtratosConsolidado() {
                this.loading = false;
            },
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dadosExtratosConsolidado: 'projeto/extratosBancariosConsolidado',
            }),
        },
        methods: {
            ...mapActions({
                buscarExtratosBancariosConsolidado: 'projeto/buscarExtratosBancariosConsolidado',
            }),
        },
    };
</script>
