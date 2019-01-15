<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Extratos Bancários'"/>
        </div>
        <div v-else>
            <v-card>
                <div v-if="Object.keys(dadosExtratosBancarios).length > 0">
                    <v-container fluid>
                        <FiltroData
                            :text="'Escolha a Dt. Lançamento:'"
                            @eventoFiltrarData="filtrarData"
                        />
                        <FiltroTipoConta
                            @eventoSearch="search = $event"
                        />
                    </v-container>
                </div>
                <v-card class="box">
                    <v-data-table
                        :headers="headers"
                        :items="dadosExtratosBancarios"
                        :pagination.sync="pagination"
                        :rows-per-page-items="[10, 25, 50, {'text': 'Todos', value: -1}]"
                        :search="search"
                        class="elevation-1 container-fluid"
                    >
                        <template
                            slot="items"
                            slot-scope="props">
                            <td
                                class="text-xs-left"
                                v-html="props.item.Tipo"/>
                            <td class="text-xs-right">{{ props.item.NrConta | formatarConta }}</td>
                            <td class="text-xs-right">{{ props.item.cdLancamento }}</td>
                            <td
                                class="text-xs-left"
                                v-html="props.item.Lancamento"/>
                            <td class="text-xs-right">{{ props.item.nrLancamento }}</td>
                            <td class="text-xs-right">
                                {{ props.item.dtLancamento | formatarData }}
                            </td>

                            <td
                                v-if="props.item.stLancamento === 'C'"
                                class="text-xs-right blue--text font-weight-bold"
                            >
                                {{ props.item.vlLancamento | filtroFormatarParaReal }}
                            </td>
                            <td
                                v-else
                                class="text-xs-right red--text font-weight-bold"
                            >
                                {{ props.item.vlLancamento | filtroFormatarParaReal }}
                            </td>

                            <td
                                v-if="props.item.stLancamento === 'C'"
                                class="text-xs-right blue--text font-weight-bold"
                            >
                                {{ props.item.stLancamento }}
                            </td>
                            <td
                                v-else
                                class="text-xs-right red--text font-weight-bold"
                            >
                                {{ props.item.stLancamento }}
                            </td>
                        </template>
                        <template
                            slot="pageText"
                            slot-scope="props">
                            Items {{ props.pageStart }}
                            - {{ props.pageStop }}
                            de {{ props.itemsLength }}
                        </template>
                    </v-data-table>
                </v-card>
            </v-card>
            <div
                v-if="Object.keys(dadosExtratosBancarios).length > 0"
                class="text-xs-center">
                <v-btn
                    round
                    dark
                    target="_blank"
                    @click="print"
                >
                    Imprimir
                    <v-icon
                        right
                        dark>local_printshop
                    </v-icon>
                </v-btn>
            </div>
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
    components: {
        Carregando,
        FiltroData,
        FiltroTipoConta,
    },
    mixins: [utils],
    data() {
        return {
            cssText: `
              .box {
                font-family: sans-serif;
                width: 5000px;
                text-align: left;
                padding: 1em;
              }

              .v-input , button, .v-icon, .v-datatable__actions__pagination, .v-datatable__actions__select, h6{
                display: none !important;
              }

              th{
                width: 130px
              }

              td{
                width: 120px;
                text-align: center;
              }
              `,
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
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
            dadosExtratosBancarios: 'projeto/extratosBancarios',
        }),
    },
    watch: {
        dadosExtratosBancarios() {
            this.loading = false;
        },
    },
    mounted() {
        const { Printd } = window.printd;
        this.d = new Printd();

        // Print dialog events (v0.0.9+)
        const { contentWindow } = this.d.getIFrame();

        contentWindow.addEventListener(
            'beforeprint', () => console.log('before print event!'),
        );
        contentWindow.addEventListener(
            'afterprint', () => console.log('after print event!'),
        );
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
        print() {
            this.d.print(this.$el, this.cssText);
        },
    },
};
</script>
