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
                <th class="center-align">Justificativa</th>
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
                <td class="right-align">{{converterParaReal(row.vlUnitario)}}</td>
                <td class="right-align">{{converterParaReal(row.vlSolicitado)}}</td>
                <td class="justify"width="30%" v-html="row.JustProponente"></td>
            </tr>
            </tbody>
            <ListaConsolidacao :itens="table"></ListaConsolidacao>
        </table>
    </div>
</template>

<script>
    import numeral from 'numeral'
    import ListaConsolidacao from '@/components/planilha/ListaConsolidacao'

    export default {
        name: 'ListaDeItensPadrao',
        data: function () {
            return {
                planilha: []
            }
        },
        props: [
            'table',
            'full'
        ],
        components: {
            ListaConsolidacao
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
            }
        }
    };
</script>