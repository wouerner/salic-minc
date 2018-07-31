<template>
    <div class="itens">
        <table class="bordered">
            <thead>
            <tr>
                <th class="center-align">#</th>
                <th class="left-align">Item</th>
                <th class="center-align">Dias</th>
                <th class="center-align">Qtde</th>
                <th class="center-align">Ocor.</th>
                <th class="right-align">Vl. Unit&aacute;rio</th>
                <th class="right-align">Vl. Solicitado</th>
                <th class="right-align">Vl. Aprovado</th>
                <th class="center-align">Justif. Proponente</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row of table"
                :key="row.idPlanilhaProposta"
                v-if="isObject(row)"
                v-bind:class="{'orange lighten-2': ultrapassaValor(row)}">
                <td class="center-align">{{row.Seq}}</td>
                <td class="left-align">{{row.Item}}</td>
                <td class="center-align">{{row.QtdeDias}}</td>
                <td class="center-align">{{row.Quantidade}}</td>
                <td class="center-align">{{row.Ocorrencia}}</td>
                <td class="right-align">
                    <SalicFormatarValor :valor="row.vlUnitario"/>
                </td>
                <td class="right-align">
                    <SalicFormatarValor :valor="row.vlSolicitado"/>
                </td>
                <td class="right-align">
                    <SalicFormatarValor :valor="row.vlSolicitado"/>
                </td>
                <td class="justify" width="30%" v-html="row.JustProponente"></td>
            </tr>
            </tbody>
            <tfoot v-if="table && Object.keys(table).length > 0" style="opacity: 0.5">
            <tr>
                <td colspan="6"><b>Totais</b></td>
                <td class="right-align">
                    <b>{{ formataValorSolicitadoTotal }}</b>
                </td>
                <td class="right-align">
                    <b>{{ formataValorSolicitadoTotal }}</b>
                </td>
                <td class="right-align"></td>
            </tr>
            </tfoot>

        </table>
    </div>
</template>

<script>
    import SalicFormatarValor from '@/components/SalicFormatarValor';
    import * as planilhas from '@/mixins/planilhas';

    export default {
        name: 'PlanilhaListaDeItensPadrao',
        data() {
            return {
                planilha: [],
            };
        },
        props: {
            table: {},
            full: '',
        },
        components: {
            SalicFormatarValor,
        },
        computed: {
            formataValorSolicitadoTotal() {
                return planilhas.formataValorSolicitadoTotal(this.table);
            },
        },
        methods: {
            isObject(el) {
                return typeof el === 'object';
            },
            ultrapassaValor(row) {
                return planilhas.ultrapassaValor(row);
            },
        },
    };
</script>
