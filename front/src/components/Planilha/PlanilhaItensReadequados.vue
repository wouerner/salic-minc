<template>
    <div class="itens">
        <table class="bordered">
            <thead>
            <tr>
                <th class="center-align">#</th>
                <th class="left-align">Item</th>
                <th class="left-align">Unidade</th>
                <th class="center-align">Dias</th>
                <th class="center-align">Qtde</th>
                <th class="center-align">Ocor.</th>
                <th class="right-align">Vl. Unit&aacute;rio</th>
                <th class="right-align">Vl. Aprovado</th>
                <th class="right-align">Vl. Comprovado</th>
                <th class="center-align">Justf. de Readequa&ccedil;&atilde;o</th>
                <th class="center-align">A&ccedil;&atilde;o</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row of table"
                :key="row.idPlanilhaProposta"
                :class="definirClasseItem(row)"
                v-if="isObject(row)">
                <td class="center-align">{{row.Seq}}</td>
                <td class="left-align">{{row.Item}}</td>
                <td class="center-align">{{row.Unidade}}</td>
                <td class="center-align">{{row.QtdeDias}}</td>
                <td class="center-align">{{row.Quantidade}}</td>
                <td class="center-align">{{row.Ocorrencia}}</td>
                <td class="right-align">
                    <SalicFormatarValor :valor="row.vlUnitario"/>
                </td>
                <td class="right-align">
                    <SalicFormatarValor :valor="row.vlAprovado"/>
                </td>
                <td class="right-align">
                    <SalicFormatarValor :valor="row.VlComprovado"/>
                </td>
                <td class="justify" width="30%" v-html="row.JustProponente"></td>
                <td class="justify" width="30%" v-html="row.DescAcao"></td>
            </tr>
            </tbody>
            <tfoot v-if="table && Object.keys(table).length > 0" style="opacity: 0.5">
            <tr>
                <td colspan="7"><b>Totais</b></td>
                <td class="right-align"><b>{{ formataValorAprovadoTotal }}</b></td>
                <td class="right-align"><b>{{ formataValorComprovadoTotal }}</b></td>
                <td colspan="2" class="right-align"></td>
            </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
    import SalicFormatarValor from '@/components/SalicFormatarValor';
    import * as planilhas from '@/mixins/planilhas';

    export default {
        name: 'PlanilhaListaDeItensReadequados',
        data() {
            return {
                planilha: [],
            };
        },
        props: {
            table: {},
        },
        components: {
            SalicFormatarValor,
        },
        computed: {
            formataValorComprovadoTotal() {
                return planilhas.formataValorComprovadoTotal();
            },
            formataValorAprovadoTotal() {
                return planilhas.formataValorAprovadoTotal();
            },
        },
        methods: {
            isObject(el) {
                return typeof el === 'object';
            },
            converterParaReal(value) {
                return planilhas.converterParaReal(value);
            },
            definirClasseItem(row) {
                return {
                    'orange lighten-2': row.stCustoPraticado === true,
                    'linha-incluida': row.tpAcao === 'I',
                    'linha-excluida': row.tpAcao === 'E',
                    'linha-atualizada': row.tpAcao === 'A',
                };
            },
        },
    };
</script>
