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
                <th class="right-align">Vl. Solicitado</th>
                <th class="right-align">Vl. Sugerido</th>
                <th class="right-align">Vl. Aprovado</th>
                <th class="center-align">Justf. do Proponente</th>
                <th class="center-align">Justf. do Parecerista</th>
                <th class="center-align">Justf. do Componente</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row of table"
                :key="row.idPlanilhaProposta"
                v-if="isObject(row)"
                v-bind:class="{'orange lighten-2': ultrapassaValor(row)}">
                <td class="center-align">{{row.Seq}}</td>
                <td class="left-align">{{row.Item}}</td>
                <td class="center-align">{{row.Unidade}}</td>
                <td class="center-align">{{row.QtdeDias}}</td>
                <td class="center-align">{{row.Quantidade}}</td>
                <td class="center-align">{{row.Ocorrencia}}</td>
                <td class="right-align"><SalicFormatarValor :valor="row.vlUnitario"/></td>
                <td class="right-align"><SalicFormatarValor :valor="row.vlSolicitado"/></td>
                <td class="right-align"><SalicFormatarValor :valor="row.vlSugerido"/></td>
                <td class="right-align"><SalicFormatarValor :valor="row.vlAprovado"/></td>
                <td class="justify" width="30%" v-html="row.JustProponente"></td>
                <td class="justify" width="30%" v-html="row.JustParecerista"></td>
                <td class="justify" width="30%" v-html="row.JustComponente"></td>
            </tr>
            </tbody>
            <tfoot v-if="table && Object.keys(table).length > 0" style="opacity: 0.5">
            <tr>
                <td colspan="7"><b>Totais</b></td>
                <td class="right-align"><b>{{ vlSolicitadoTotal }}</b></td>
                <td class="right-align"><b>{{ vlSugeridoTotal }}</b></td>
                <td class="right-align"><b>{{ vlAprovadoTotal }}</b></td>
                <td colspan="3" class="right-align"></td>
            </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
import numeral from 'numeral';
import 'numeral/locales';

import SalicFormatarValor from '@/components/SalicFormatarValor';

export default {
  name: 'PlanilhaListaDeItensHomologados',
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
  created() {
    numeral.locale('pt-br');
    numeral.defaultFormat('0,0.00');
  },
  computed: {
    vlSolicitadoTotal() {
      const soma = numeral();
      /* eslint-disable-next-line */
      Object.entries(this.table).forEach(([column, cell]) => {
        if (typeof cell.vlSolicitado !== 'undefined') {
          soma.add(parseFloat(cell.vlSolicitado));
        }
      });
      return soma.format();
    },
    vlSugeridoTotal() {
      const soma = numeral();
      /* eslint-disable-next-line */
      Object.entries(this.table).forEach(([column, cell]) => {
        if (typeof cell.vlSugerido !== 'undefined') {
          soma.add(parseFloat(cell.vlSugerido));
        }
      });
      return soma.format();
    },
    vlAprovadoTotal() {
      const soma = numeral();
      /* eslint-disable-next-line */
      Object.entries(this.table).forEach(([column, cell]) => {
        if (typeof cell.vlAprovado !== 'undefined') {
          soma.add(parseFloat(cell.vlAprovado));
        }
      });
      return soma.format();
    },
  },
  methods: {
    isObject(el) {
      return typeof el === 'object';
    },
    converterStringParaClasseCss(text) {
      return text
        .toString()
        .toLowerCase()
        .trim()
        .replace(/&/g, '-and-')
        .replace(/[\s\W-]+/g, '-');
    },
    ultrapassaValor(row) {
      return row.stCustoPraticado === true;
    },
    converterParaReal(value) {
      value = parseFloat(value);
      return numeral(value).format('0,0.00');
    },
  },
};
</script>