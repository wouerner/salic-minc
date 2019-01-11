<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Inconsistência Bancária'"></Carregando>
        </div>
        <div v-else-if="dadosInconsistencia">
            <v-data-table
                    :headers="headers"
                    :items="dadosInconsistencia"
                    class="elevation-1 container-fluid"
                    :rows-per-page-items="[10, 25, 50, 100, {'text': 'Todos', value: -1}]"
            >
                <template slot="items" slot-scope="props">
                    <td class="text-xs-left">{{ props.item.ItemOrcamentario }}</td>
                    <td class="text-xs-left" style="width: 250px">{{ props.item.CNPJCPF | cnpjFilter }}</td>
                    <td class="text-xs-left">{{ props.item.Fornecedor }}</td>
                    <td class="text-xs-right font-weight-bold">{{ props.item.vlPagamento | filtroFormatarParaReal }}
                    </td>
                    <td class="text-xs-right font-weight-bold">{{ props.item.vlComprovado | filtroFormatarParaReal }}
                    </td>

                    <td class="text-xs-right" v-if="props.item.vlDebitado">
                        {{ props.item.vlDebitado | filtroFormatarParaReal }}
                    </td>
                    <td v-else class="text-xs-right">
                        {{ '000' | filtroFormatarParaReal}}
                    </td>

                    <td class="text-xs-right red--text font-weight-bold"
                        v-if="props.item.vlDiferenca && props.item.vlDiferenca !== 0"
                    >
                        {{ props.item.vlDiferenca | filtroFormatarParaReal }}
                    </td>
                    <td v-else class="text-xs-right">
                        {{ '000' | filtroFormatarParaReal}}
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
    import cnpjFilter from '@/filters/cnpj';
    import { utils } from '@/mixins/utils';

    export default {
        name: 'InconsistenciaBancaria',
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
                        text: 'ITEM ORÇAMENTÁRIO',
                        align: 'left',
                        value: 'ItemOrcamentario',
                    },
                    {
                        text: 'CNPJ / CPF',
                        align: 'left',
                        value: 'CNPJCPF',
                    },
                    {
                        text: 'FORNECEDOR',
                        align: 'left',
                        value: 'Fornecedor',
                    },
                    {
                        text: 'VALOR ',
                        align: 'center',
                        value: 'vlPagamento',
                    },
                    {
                        text: 'VL. COMPROVADO',
                        align: 'center',
                        value: 'vlComprovado',
                    },
                    {
                        text: 'VL. DEBITADO',
                        align: 'center',
                        value: 'vlDebitado',
                    },
                    {
                        text: 'VL. DIFERENÇA',
                        align: 'center',
                        value: 'vlDiferenca',
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
                this.buscarInconsistenciaBancaria(this.dadosProjeto.idPronac);
            }
        },
        watch: {
            dadosInconsistencia() {
                this.loading = false;
            },
        },
        filters: {
            cnpjFilter,
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dadosInconsistencia: 'projeto/inconsistenciaBancaria',
            }),
        },
        methods: {
            ...mapActions({
                buscarInconsistenciaBancaria: 'projeto/buscarInconsistenciaBancaria',
            }),
        },
    };
</script>

