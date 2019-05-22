<template>
    <div class="itens">
        <v-data-table
            :headers="headers"
            :items="table"
            :rows-per-page-items="[-1]"
            :loading="loading"
            item-key="idPlanilhaAprovacao"
            class="elevation-1"
            hide-actions
        >
            <v-progress-linear
                slot="progress"
                color="blue"
                indeterminate/>
            <template
                slot="items"
                slot-scope="props"
            >
                <tr
                    :class="obterClasseItem(props.item)"
                    style="cursor: pointer"
                    @click="props.expanded = !props.expanded"
                >
                    <td class="text-xs-left">{{ props.item.Item }}</td>
                    <td class="text-xs-center">{{ props.item.Unidade }}</td>
                    <td class="text-xs-center">{{ props.item.QtdeDias }}</td>
                    <td class="text-xs-center">{{ props.item.Quantidade }}</td>
                    <td class="text-xs-center">{{ props.item.Ocorrencia }}</td>
                    <td class="text-xs-right">{{ props.item.vlUnitario | filtroFormatarParaReal }}</td>
                    <td class="text-xs-right">{{ props.item.vlAprovado | filtroFormatarParaReal }}</td>
                    <td class="text-xs-right">{{ props.item.vlComprovado | filtroFormatarParaReal }}</td>
                    <td class="text-xs-right">{{ props.item.dsJustificativa }}</td>
                </tr>
            </template>
            <template
                slot="expand"
                slot-scope="props">
                <v-layout
                    wrap
                    column
                    class="blue-grey lighten-5 pa-2">
                    <v-card>
                        <v-card-title class="py-1">
                            <h3>Visualizando item: {{ props.item.Item }} </h3>
                            <editar-item-planilha-button
                                v-if="!readonly"
                                :item="props.item"
                            />
                        </v-card-title>
                        <v-divider/>
                        <v-card-text>
                            <v-container grid-list-md>
                                <v-layout row>
                                    <v-flex
                                        xs12
                                        md2
                                    >
                                        <b>Unidade</b>
                                        <div>{{ props.item.Unidade }}</div>
                                    </v-flex>
                                    <v-flex
                                        xs12
                                        md1
                                    >
                                        <b>Dias</b>
                                        <div>{{ props.item.QtdeDias }}</div>
                                    </v-flex>
                                    <v-flex
                                        xs12
                                        md1
                                    >
                                        <b>Qtd.</b>
                                        <div>{{ props.item.Quantidade }}</div>
                                    </v-flex>
                                    <v-flex
                                        xs12
                                        md2
                                    >
                                        <b>Ocorrência</b>
                                        <div>{{ props.item.Ocorrencia }}</div>
                                    </v-flex>
                                    <v-flex
                                        xs12
                                        md2
                                    >
                                        <b>Vl. Unitário (R$)</b>
                                        <div>{{ props.item.vlUnitario | filtroFormatarParaReal }}</div>
                                    </v-flex>
                                    <v-flex
                                        xs12
                                        md4
                                    >
                                        <b>Vl. Solicitado (R$)</b>
                                        <div>{{ props.item.VlSolicitado | filtroFormatarParaReal }}</div>
                                    </v-flex>
                                    <v-flex
                                        xs12
                                        md4
                                    >
                                        <b>Vl. Comprovado (R$)</b>
                                        <div>{{ props.item.vlAprovado | filtroFormatarParaReal }}</div>
                                    </v-flex>
                                    <v-flex
                                        xs12
                                        md4
                                    >
                                        <b>Vl. Comprovado (R$)</b>
                                        <div>{{ props.item.vlComprovado | filtroFormatarParaReal }}</div>
                                    </v-flex>
                                    <v-flex
                                        xs12
                                        md12>
                                        <b>Justificativa</b>
                                        <div
                                            v-html="props.item.justificitivaproponente"
                                        />
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-layout>
            </template>
            <template slot="footer">
                <tr
                    v-if="table && Object.keys(table).length > 0"
                    style="opacity: 0.5">
                    <td colspan="7"><b>Totais</b></td>
                    <td class="text-xs-right"><b>{{ obterValorAprovadoTotal(table) | filtroFormatarParaReal }}</b></td>
                    <td class="text-xs-right"><b>{{ obterValorComprovadoTotal(table) | filtroFormatarParaReal }}</b></td>
                </tr>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import EditarItemPlanilhaButton from './EditarItemPlanilhaButton';
import MxPlanilhaReadequacao from '../mixins/PlanilhaReadequacao';
import { utils } from '@/mixins/utils';

export default {
    name: 'PlanilhaItensSaldo',
    components: {
        EditarItemPlanilhaButton,
    },
    mixins: [
        MxPlanilhaReadequacao,
        utils,
    ],
    props: {
        table: {
            type: Array,
            required: true,
        },
        readonly: {
            type: Boolean,
            default: false,
        }
    },
    data() {
        return {
            valid: false,
            expand: false,
            loading: false,
            headers: [
                { text: 'Item', align: 'left', value: 'Item' },
                { text: 'Unidade', align: 'left', value: 'Unidade' },
                { text: 'Dias', align: 'center', value: 'QtdeDias' },
                { text: 'Qtde', align: 'center', value: 'Quantidade' },
                { text: 'Ocor.', align: 'center', value: 'Ocorrencia' },
                { text: 'Vl. Unitário', align: 'right', value: 'vlUnitario' },
                { text: 'Vl. Aprovado', align: 'right', value: 'vlAprovado' },
                { text: 'Vl. Comprovado', align: 'right', value: 'vlComprovado' },
                { text: 'Justificativa', align: 'right', value: 'dsJustificativa' },
            ],
            itemEmEdicao: {},
            select: {},
        };
    },
};
</script>
