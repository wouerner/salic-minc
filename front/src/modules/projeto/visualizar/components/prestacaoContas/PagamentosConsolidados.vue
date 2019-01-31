<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Carregando Pagamentos Consolidados'"/>
        </div>
        <div v-else-if="dados">
            <v-data-table
                :pagination.sync="pagination"
                :headers="headers"
                :items="indexItems"
                :rows-per-page-items="[10, 25, 50, {'text': 'Todos', value: -1}]"
                item-key="id"
                class="elevation-1 container-fluid"
            >
                <template
                    slot="items"
                    slot-scope="props">
                    <td class="text-xs-center">{{ props.item.id + 1 }}</td>
                    <td class="text-xs-center pl-5">{{ props.item.UFFornecedor }}</td>
                    <td class="text-xs-left pl-5">{{ props.item.MunicipioFornecedor }}</td>
                    <td class="text-xs-right">{{ props.item.vlPagamento | filtroFormatarParaReal }}</td>
                </template>
            </v-data-table>
        </div>
    </div>
</template>
<script>

import { mapActions, mapGetters } from 'vuex';
import Carregando from '@/components/CarregandoVuetify';
import { utils } from '@/mixins/utils';

export default {
    name: 'PagamentosConsolidados',
    components: {
        Carregando,
    },
    mixins: [utils],
    data() {
        return {
            search: '',
            pagination: {
                sortBy: 'id',
                ascending: true,
            },
            selected: [],
            loading: true,
            headers: [
                {
                    text: 'N°',
                    align: 'center',
                    value: 'id',
                },
                {
                    text: 'UF Fornecedor',
                    align: 'center',
                    value: 'UFFornecedor',
                },
                {
                    text: 'Município Fornecedor',
                    align: 'left',
                    value: 'MunicipioFornecedor',
                },
                {
                    text: 'Vl. Pagamento',
                    align: 'right',
                    value: 'vlPagamento',
                },
            ],
        };
    },
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
            dados: 'prestacaoContas/pagamentosConsolidados',
        }),
        indexItems() {
            const currentItems = this.dados;
            return currentItems.map((item, index) => ({
                id: index,
                ...item,
            }));
        },
    },
    watch: {
        dados() {
            this.loading = false;
        },
    },
    mounted() {
        if (typeof this.dadosProjeto.idPronac !== 'undefined') {
            this.buscarPagamentosConsolidados(this.dadosProjeto.idPronac);
        }
    },
    methods: {
        ...mapActions({
            buscarPagamentosConsolidados: 'prestacaoContas/buscarPagamentosConsolidados',
        }),
    },
};
</script>
