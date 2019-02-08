<template>
    <div>
        <v-card>
            <v-card-title>
                <h6>COMPROVAÇÃO DE ITENS ORÇAMENTÁRIOS</h6>
            </v-card-title>
            <v-data-table
                :pagination.sync="pagination"
                :headers="headers"
                :items="dados.dadosItensOrcamentarios"
                class="elevation-1 container-fluid"
            >
                <template
                    slot="items"
                    slot-scope="props">
                    <td class="text-xs-left">{{ props.item.Item }}</td>
                    <td class="text-xs-right">{{ props.item.qtFisicaAprovada }}</td>
                    <td class="text-xs-right">{{ props.item.qtFisicaExecutada | tipoExecucaoRound }}</td>
                    <td class="text-xs-right">{{ props.item.PerFisica | tipoExecucao }} %</td>
                    <td class="text-xs-right">{{ props.item.vlAprovado | filtroFormatarParaReal }}</td>
                    <td class="text-xs-right">{{ props.item.vlExecutado | filtroFormatarParaReal }}</td>
                    <td class="text-xs-right">{{ props.item.PercFinanceiro | tipoExecucao }} %</td>
                    <td class="text-xs-right">{{ props.item.SaldoAExecutar | filtroFormatarParaReal }}</td>
                </template>
                <template
                    slot="pageText"
                    slot-scope="props">
                    Items {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                </template>
            </v-data-table>
        </v-card>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
import { utils } from '@/mixins/utils';

export default {
    name: 'ComprovacaoItensOrcamentarios',
    filters: {
        tipoExecucao(qtFisicaExecutada) {
            return (qtFisicaExecutada).toFixed(2);
        },
        tipoExecucaoRound(qtFisicaExecutada) {
            return Math.round(qtFisicaExecutada);
        },
    },
    mixins: [utils],
    props: {
        valorDespesaTotal: {
            type: Number,
            default: 0,
        },
    },
    data() {
        return {
            pagination: {
                sortBy: '',
                descending: true,
            },
            headers: [
                {
                    text: 'Item',
                    align: 'left',
                    value: 'Item',
                },
                {
                    text: 'Aprovada',
                    align: 'left',
                    value: 'qtFisicaAprovada',
                },
                {
                    text: 'Executada',
                    align: 'right',
                    value: 'qtFisicaExecutada',
                },
                {
                    text: '% Executado',
                    align: 'right',
                    value: 'PercFinanceiro',
                },
                {
                    text: 'Aprovada',
                    align: 'left',
                    value: 'vlAprovado',
                },

                {
                    text: 'Executada',
                    align: 'left',
                    value: 'vlExecutado',
                },

                {
                    text: '% Executado',
                    align: 'left',
                    value: 'PerFisica',
                },
                {
                    text: 'Saldo à Executar',
                    align: 'left',
                    value: 'SaldoAExecutar',
                },
            ],
        };
    },
    computed: {
        ...mapGetters({
            dados: 'prestacaoContas/relatorioCumprimentoObjeto',
        }),
    },
};
</script>
