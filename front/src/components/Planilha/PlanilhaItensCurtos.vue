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
                <th>Vl. Solicitado</th>
                <th>#</th>
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
                <td class="right-align"><SalicFormatarValor :valor="row.vlUnitario"/></td>
                <td class="right-align"><SalicFormatarValor :valor="row.vlSolicitado"/></td>
                <td>
                    <a v-if="row.JustProponente.length > 3"
                       class="tooltipped"
                       data-position="left"
                       data-delay="50"
                       v-bind:data-tooltip="row.JustProponente"
                    ><i class="material-icons tiny">message</i>
                    </a>

                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import numeral from "numeral";
import SalicFormatarValor from "@/components/SalicFormatarValor";

export default {
  name: "PlanilhaListaDeItensCurta",
  data() {
    return {
      planilha: []
    };
  },
  props: {
    table: {}
  },
  components: {
    SalicFormatarValor
  },
  methods: {
    isObject(el) {
      return typeof el === "object";
    },
    converterStringParaClasseCss(text) {
      return text
        .toString()
        .toLowerCase()
        .trim()
        .replace(/&/g, "-and-")
        .replace(/[\s\W-]+/g, "-");
    },
    ultrapassaValor(row) {
      return row.stCustoPraticado == true;
    },
    converterParaReal(value) {
      value = parseFloat(value);
      return numeral(value).format('0,0.00');
    },
  },
};
</script>