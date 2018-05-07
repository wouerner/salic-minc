Vue.component('plano-distribuicao-visualizar-produto-resumido', {
    template: `
    <div class="plano-distribuicao-visualizar-produto-rodape " v-if="produto">
        <table class="resumo-distribuicao planoDistribuicao bordered responsive-table ">
            <caption>Resumo dos detalhamentos</caption>
            <thead>
                <tr>
                    <th class="center-align" rowspan="2">Quantidade</th>
                    <th colspan="3" class="proponente">Proponente</th>
                    <th colspan="3" class="popular">Preço Popular</th>
                    <th colspan="3" class="gratuito">Distribuição Gratuita</th>
                    <th class="right-align" rowspan="2" width="8%">Receita Prevista total</th>
                </tr>
                <tr>
                    <th class="proponente">Qtd. de Inteira</th>
                    <th class="proponente">Qtd. de Meia</th>
                    <th class="proponente">Valor médio</th>
                    <th class="popular">Qtd. de Inteira</th>
                    <th class="popular">Qtd. de Meia</th>
                    <th class="popular">Valor médio</th>
                    <th class="gratuito">Divulgação</th>
                    <th class="gratuito">Patrocinador</th>
                    <th class="gratuito">População</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="center-align">{{produto.QtdeProduzida}}</td>
                    <td class="proponente">{{produto.QtdeVendaNormal}}</td>
                    <td class="proponente">{{produto.QtdeVendaPromocional}}</td>
                    <td class="proponente">{{produto.PrecoUnitarioNormal}}</td>
                    <td class="popular">{{produto.QtdeVendaPopularNormal}}</td>
                    <td class="popular">{{produto.QtdeVendaPopularPromocional}}</td>
                    <td class="popular">{{produto.ReceitaPopularNormal}}</td>
                    <td class="gratuito">{{produto.QtdeProponente}}</td>
                    <td class="gratuito">{{produto.QtdePatrocinador}}</td>
                    <td class="gratuito">{{produto.QtdeOutros}}</td>
                    <td class="right-align">{{produto.Receita}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    `,
    props: {
        'produto': {}
    },
    mixins: [utils],
    created: function () {
        console.log('ordapeeee');
    }
});
