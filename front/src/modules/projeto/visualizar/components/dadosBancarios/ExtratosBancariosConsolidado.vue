<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Extratos Bancários Consolidado'"/>
        </div>
        <v-card v-else>
            <div v-if="Object.keys(dadosExtratosConsolidado).length > 0">
                <v-container fluid>
                    <FiltroTipoConta
                        @eventoSearch="search = $event"
                    />
                </v-container>
            </div>
            <v-data-table
                :headers="headers"
                :items="dadosExtratosConsolidado"
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
                        v-html="props.item.TipoConta"/>
                    <td class="text-xs-right">{{ props.item.NrConta | formatarConta }}</td>
                    <td class="text-xs-right">{{ props.item.Codigo }}</td>
                    <td
                        class="text-xs-left"
                        v-html="props.item.Lancamento"/>

                    <td
                        v-if="props.item.stLancamento === 'C'"
                        class="text-xs-right blue--text font-weight-bold"
                    >
                        {{ props.item.vlLancamento | filtroFormatarParaReal }}
                    </td>
                    <td
                        v-else
                        class="text-xs-right red--text font-weight-bold">
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
                        class="text-xs-right red--text font-weight-bold">
                        {{ props.item.stLancamento }}
                    </td>
                </template>
                <template
                    slot="pageText"
                    slot-scope="props">
                    Items {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                </template>
                <v-alert
                    slot="no-results"
                    :value="true"
                    color="error"
                    icon="warning">
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
    components: {
        Carregando,
        FiltroTipoConta,
    },
    mixins: [utils],
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
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
            dadosExtratosConsolidado: 'projeto/extratosBancariosConsolidado',
        }),
    },
    watch: {
        dadosExtratosConsolidado() {
            this.loading = false;
        },
        dadosProjeto(value) {
            this.loading = true;
            this.buscarExtratosBancariosConsolidado(value.idPronac);
        },
    },
    mounted() {
        if (typeof this.dadosProjeto.idPronac !== 'undefined') {
            this.buscarExtratosBancariosConsolidado(this.dadosProjeto.idPronac);
        }
    },
    methods: {
        ...mapActions({
            buscarExtratosBancariosConsolidado: 'projeto/buscarExtratosBancariosConsolidado',
        }),
    },
};
</script>
