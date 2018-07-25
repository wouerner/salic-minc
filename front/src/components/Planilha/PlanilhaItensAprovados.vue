<template>
    <div class="itens">
        <table class="bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Dias</th>
                <th>Qtde</th>
                <th>Ocor.</th>
                <th>Vl. Unit&aacute;rio</th>
                <th>Vl. Solicitado</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row of table"
                :key="row.idPlanilhaProposta"
                v-if="isObject(row)"
                v-bind:class="{'orange lighten-2': ultrapassaValor(row)}">
                <td>{{row.Seq}}</td>
                <td>{{row.Item}}</td>
                <td>{{row.QtdeDias}}</td>
                <td>{{row.Quantidade}}</td>
                <td>{{row.Ocorrencia}}</td>
                <td>{{converterParaReal(row.vlUnitario)}}</td>
                <td>{{converterParaReal(row.vlSolicitado)}}</td>
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
import * as planilhas from '@/mixins/planilhas';

export default {
  name: 'PlanilhaListaDeItensAprovados',
  data() {
    return {
      planilha: [],
    };
  },
  props: ['table', 'full'],
  methods: {
    isObject(el) {
      return typeof el === 'object';
    },
    ultrapassaValor(row) {
      return planilhas.ultrapassaValor(row);
    },
    converterParaReal(value) {
      return planilhas.converterParaReal(value);
    },
  },
};
</script>
