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
                <th class="right-align"><CharsetEncode :texto="'Vl. Unit&aacute;rio'" /></th>
                <th class="right-align">Vl. Aprovado</th>
                <th class="right-align">Vl. Comprovado</th>
                <th class="center-align"><CharsetEncode :texto="'Justf. de Readequa&ccedil;&atilde;o'" /></th>
                <th class="center-align"><CharsetEncode :texto="'A&ccedil;&atilde;o'" /></th>
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
                <td class="right-align"><SalicFormatarValor :valor="row.vlUnitario"/></td>
                <td class="right-align"><SalicFormatarValor :valor="row.vlAprovado"/></td>
                <td class="right-align"><SalicFormatarValor :valor="row.VlComprovado"/></td>
                <td class="justify" width="30%" v-html="row.JustProponente"></td>
                <td class="justify" width="30%" v-html="row.DescAcao"></td>
            </tr>
            </tbody>
            <tfoot v-if="table && Object.keys(table).length > 0" style="opacity: 0.5">
            <tr>
                <td colspan="6"><b>Totais</b></td>
                <td class="right-align">
                    <b>{{ vlSolicitadoTotal }}</b>
                </td>  <td class="right-align">
                    <b>{{ vlSolicitadoTotal }}</b>
                </td>  <td class="right-align">
                    <b>{{ vlSolicitadoTotal }}</b>
                </td>
                <td class="right-align"></td>
            </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
    import numeral from 'numeral'
    import 'numeral/locales';

    import CharsetEncode from '@/components/CharsetEncode';
    import SalicFormatarValor from '@/components/SalicFormatarValor';

    export default {
        name: 'ListaDeItensReadequados',
        data: function () {
            return {
                planilha: []
            }
        },
        props: {
            'table': {},
            'full': ''
        },
        components: {
            SalicFormatarValor,
            CharsetEncode
        },
        created: function() {
            numeral.locale('pt-br');
            numeral.defaultFormat('0,0.00');
        },
        computed: {
            vlSolicitadoTotal: function () {
                var soma = numeral();
                Object.entries(this.table).forEach(([column, cell]) => {
                    if(typeof cell.vlSolicitado != 'undefined') {
                        soma.add(parseFloat(cell.vlSolicitado));
                    }
                });
                return soma.format();
            }
        },
        methods: {
            isObject: function (el) {
                return typeof el === "object";
            },
            converterStringParaClasseCss: function (text) {
                return text.toString().toLowerCase().trim()
                        .replace(/&/g, '-and-')
                        .replace(/[\s\W-]+/g, '-');
            },
            ultrapassaValor: function (row) {
                return row.stCustoPraticado == true;
            },
            converterParaReal: function (value) {
                value = parseFloat(value);
                return numeral(value).format('0,0.00');
            },
            definirClasseItem: function (row) {
                return {
                    'orange lighten-2': row.stCustoPraticado == true,
                    'linha-incluida': row.tpAcao == 'I',
                    'linha-excluida': row.tpAcao == 'E',
                    'linha-atualizada': row.tpAcao == 'A',
                }
            }
        }
    };
</script>