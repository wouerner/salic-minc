<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Extratos Bancários'"></Carregando>
        </div>
        <div v-else>
            <v-card>
                <FiltroData
                    :text="'Escolha a Dt. Lançamento:'"
                    v-on:eventoFiltrarData="filtrarData"
                >
                </FiltroData>
                <FiltroTipoConta
                    v-on:eventoSearch="search = $event"
                >
                </FiltroTipoConta>
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
    import FiltroData from './components/FiltroData';
    import FiltroTipoConta from './components/FiltroTipoConta';

    export default {
        name: 'ExtratosBancarios',
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
                        align: 'left',
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
            FiltroData,
            FiltroTipoConta,
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
            }
        },
        watch: {
            dadosExtratosBancarios() {
                this.loading = false;
            },
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dadosExtratosBancarios: 'projeto/extratosBancarios',
            }),
        },
        methods: {
            ...mapActions({
                buscarExtratosBancarios: 'projeto/buscarExtratosBancarios',
            }),
            filtrarData(response) {
                const params = {
                    idPronac: this.dadosProjeto.idPronac,
                    dtLancamento: response.dtInicio,
                    dtLancamentoFim: response.dtFim,
                    tpConta: this.search,
                };
                this.buscarExtratosBancarios(params);
            },
        },
    };
</script>
