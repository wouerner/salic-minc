Vue.component('sl-planilha-itens',{
    props: ['itens','idpronac','uf',
        'cdproduto','cdcidade','cdetapa'],
    template: `<table class="bordered">
                <thead>
                    <tr>
                        <th>Item de Custo</th>
                        <th style="text-align: right">Valor Aprovado</th>
                        <th style="text-align: right">Valor Comprovado</th>
                        <th style="text-align: right">Valor a Comprovar</th>
                        <th style="text-align: center">Analisar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr :item="item"
                       v-for="(item, index) in itens"
                       :key="index"
                       v-if="isObject(item)">
                        <td>
                            {{ item.item }}
                        </td>
                        <td style="text-align: right"> R$ {{ converterParaReal(item.varlorAprovado) }} </td>
                        <td style="text-align: right"> R$ {{ converterParaReal(item.varlorComprovado) }} </td>
                        <td style="text-align: right"> R$ {{ converterParaReal(item.varlorAprovado - item.varlorComprovado)  }} </td>
                        <td style="text-align: center"><a class="btn red" title="Comprovar item"
                            :href="url(item.idPlanilhaAprovacao, item.idPlanilhaItens, item.stItemAvaliado)"
                           ><i class="material-icons small">gavel</i></a></td>
                    </tr>
                </tbody>
            </table> `,
    methods: {
        isObject: function (el) {

            return typeof el === "object";

        },
        converterParaReal: function (value) {
            value = parseFloat(value);
            return numeral(value).format('0,0.00');
        },
        url: function (idPlanilhaAprovacao, idPlanilhaItens, stItemAvaliado) {
            return '/prestacao-contas/analisar/comprovante'
                + '/idPronac/' + this.idpronac
                + '/uf/' + this.uf
                + '/produto/' + this.cdproduto
                + '/idmunicipio/' + this.cdcidade
                + '/idPlanilhaItem/' + idPlanilhaItens
                + '/stItemAvaliado/' + stItemAvaliado;
        }
    }


})