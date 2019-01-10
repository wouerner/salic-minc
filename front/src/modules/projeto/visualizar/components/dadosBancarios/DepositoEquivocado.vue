<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Depósito Equivocado'"></Carregando>
        </div>
        <div v-else>
            <v-card>
                <FiltroData
                    :text="'Escolha a Dt. Devolução:'"
                    v-on:eventoFiltrarData="filtrarData"
                >
                </FiltroData>
                <v-data-table
                        :headers="headers"
                        :items="dadosDepositoEquivocado"
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
    import FiltroData from './components/FiltroData';

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
            FiltroData
        },
        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                const params = {
                    idPronac: this.dadosProjeto.idPronac,
                    dtInicio: '',
                    dtFim: '',
                };

                this.buscarDepositoEquivocado(params);
            }
        },
        watch: {
            dadosDepositoEquivocado() {
                this.loading = false;
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
            filtrarData(response) {
                const params = {
                    idPronac: this.dadosProjeto.idPronac,
                    dtInicio: response.dtInicio,
                    dtFim: response.dtFim,
                };
                this.buscarDepositoEquivocado(params);
            },
        },
    };
</script>
