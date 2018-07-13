<template>
    <tfoot v-if="itens && itens.length > 0" style="opacity: 0.5">
    <tr>
        <td colspan="6"><b>Totais</b></td>
        <td class="right-align"><b>{{ vlSolicitadoTotal }}</b></td>
        <td class="right-align"></td>
    </tr>
    </tfoot>
</template>
<script>
    import numeral from 'numeral'
    export default {
        name: 'ListaConsolidacao',
        props: {
            itens: {}
        },
        computed: {
            vlSolicitadoTotal: function () {
                var soma = numeral();

                soma.add(this.itens.reduce(function (total, value) {
                    return total + parseFloat(value.vlSolicitado);
                }, 0));

                return soma.format();
            }
        }
    };
</script>