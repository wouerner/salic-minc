<template>
    <tfoot style="opacity: 0.8">
            <tr>
                <td><b>Totais</b></td>
                <td class="right-align">{{ qtExemplaresTotal }}</td>

                <td class="right-align">
                    {{
                        parseInt(qtGratuitaDivulgacaoTotal) +
                        parseInt(qtGratuitaPatrocinadorTotal) +
                        parseInt(qtGratuitaPopulacaoTotal)
                    }}
                </td>

                <td class="right-align">{{ qtPopularIntegralTotal }}</td>
                <td class="right-align">{{ qtPopularParcialTotal }}</td>
                <td class="right-align"> --- </td>

                <td class="right-align">{{ qtProponenteIntegralTotal }}</td>
                <td class="right-align">{{ qtProponenteParcialTotal }}</td>
                <td class="right-align"> --- </td>
                <td class="right-align">{{ receitaPrevistaTotal }}</td>
            </tr>
    </tfoot>
</template>
<script>

import { utils } from '@/mixins/utils';
import numeral from 'numeral';
import 'numeral/locales';

numeral.locale('pt-br');
numeral.defaultFormat('0,0.00');


export default {
    name: 'slPropostaDetalhamentoConsolidacao',
    props: {
        items : {},
    },
    mixins: [utils],
    computed: {
        // Total de exemplares
        qtExemplaresTotal: function () {
            let total = 0;
            for (var i = 0; i < this.items.length; i++) {
                total += parseInt(this.items[i]['qtExemplares']);
            }
            return total;
        },
        // Total de divulgação gratuita.
        qtGratuitaDivulgacaoTotal: function () {
            let total = 0;
            for (var i = 0; i < this.items.length; i++) {
                total += parseInt(this.items[i]['qtGratuitaDivulgacao']);
            }
            return total;
        },
        // Total de divulgação Patrocinador
        qtGratuitaPatrocinadorTotal: function () {
            let total = 0;
            for (var i = 0; i < this.items.length; i++) {
                total += parseInt(this.items[i]['qtGratuitaPatrocinador']);
            }
            return total;
        },
        // Total de divulgação gratuita.
        qtGratuitaPopulacaoTotal: function () {
            let total = 0;
            for (var i = 0; i < this.items.length; i++) {
                total += parseInt(this.items[i]['qtGratuitaPopulacao']);
            }
            return total;
        },
        //Preço Popular: Quantidade de Inteira
        qtPopularIntegralTotal: function () {
            let total = 0;
            for (var i = 0; i < this.items.length; i++) {
                total += parseInt(this.items[i]['qtPopularIntegral']);
            }
            return total;
        },
        //Preço Popular: Quantidade de meia entrada
        qtPopularParcialTotal: function () {
            let total = 0;
            for (var i = 0; i < this.items.length; i++) {
                total += parseInt(this.items[i]['qtPopularParcial']);
            }
            return total;
        },
        vlReceitaPopularIntegralTotal: function () {
            let total = 0;
            for (var i = 0; i < this.items.length; i++) {
                var vl = (this.items[i]['vlReceitaPopularIntegral']);
                total += numeral(vl).value();
            }
            return numeral(total).format('0,0.00');
        },
        vlReceitaPopularParcialTotal: function () {
            let total = 0;
            for (var i = 0; i < this.items.length; i++) {
                var vl = (this.items[i]['vlReceitaPopularParcial']);
                total += numeral(vl).value();
            }
            return numeral(total).format('0,0.00');
        },
        qtProponenteIntegralTotal: function () {
            let total = 0;
            for (var i = 0; i < this.items.length; i++) {
                total += parseInt(this.items[i]['qtProponenteIntegral']);
            }
            return total;
        },
        qtProponenteParcialTotal: function () {
            let total = 0;
            for (var i = 0; i < this.items.length; i++) {
                total += parseInt(this.items[i]['qtProponenteParcial']);
            }
            return total;
        },
        vlReceitaProponenteIntegralTotal: function () {
            let total = 0;
            for (var i = 0; i < this.items.length; i++) {
                vl = (this.items[i]['vlReceitaProponenteIntegral']);
                total += this.converterParaMoedaAmericana(vl);
            }
            return numeral(total).format('0,0.00');
        },
        vlReceitaProponenteParcialTotal: function () {
            let total = 0;
            for (var i = 0; i < this.items.length; i++) {
                var vl = (this.items[i]['vlReceitaProponenteParcial']);
                total += this.converterParaMoedaAmericana(vl);
            }
            return numeral(total).format('0,0.00');
        },
        receitaPrevistaTotal: function () {
            var total = numeral();

            for (var i = 0; i < this.items.length; i++) {
                var vl = this.items[i]['vlReceitaPrevista'];
                total.add(parseFloat(vl));
            }
            return total.format('0,0.00');
        }
    },
};
</script>
