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
                        <th style="text-align: center"> </th>
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
                        <td style="text-align: right"><a class="btn" title="Comprovar item"
                            :href="'/prestacao-contas/gerenciar/comprovar'
                               + '/idpronac/' + idpronac
                               + '/uf/' + uf
                               + '/produto/' + cdproduto
                               + '/cidade/' + cdcidade
                               + '/etapa/' + cdetapa
                               + '/idPlanilhaAprovacao/' + item.idPlanilhaAprovacao
                               + '/idPlanilhaItens/' + item.idPlanilhaItens"
                           ><i class="material-icons small">attach_money</i></a></td>
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
        }
    }


})