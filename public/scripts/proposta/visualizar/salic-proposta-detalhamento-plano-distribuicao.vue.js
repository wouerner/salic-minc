Vue.component('salic-proposta-plano-distribuicao', {
    template: `
    <div class="plano-distribuicao">
        <ul class="collapsible collapsible-produto no-padding" data-collapsible="accordion">
            <li v-for="produto of produtos">
                <div class="collapsible-header">
                    <i class="material-icons">add</i> {{produto.Produto}}
                </div>
                <div class="collapsible-body">
                    <table>
                        <thead>
                           <tr>
                                <th>&Aacute;rea</th>
                                <th>Segmento</th>
                                <th>Principal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{produto.DescricaoArea}}</td>
                                <td>{{produto.DescricaoSegmento}}</td>
                                <td>{{produto.stPrincipal ? 'N&atilde;o' : 'Sim'}}</td>
                            </tr>
                        </tbody>
                    </table>
                   
                    <table class="resumo-distribuicao planoDistribuicao">
                        <thead>
                        <tr>
                            <th class="center-align" rowspan="2">Quantidade</th>
                            <th colspan="3" class="center-align gratuito">Distribui&ccedil;&atilde;o Gratuita</th>
                            <th colspan="3" class="center-align popular">Pre&ccedil;o Popular</th>
                            <th colspan="3" class="center-align proponente">Proponente</th>
                            <th class="right-align" rowspan="2" width="8%">Receita Prevista total</th>
                        </tr>
                        <tr>
                            <th class="gratuito right-align">Divulga&ccedil;&atilde;o</th>
                            <th class="gratuito right-align">Patrocinador</th>
                            <th class="gratuito right-align">Popula&ccedil;&atilde;o</th>
                            <th class="popular right-align">Qtd. Inteira</th>
                            <th class="popular right-align">Qtd. Meia</th>
                            <th class="popular right-align">Valor m&eacute;dio</th>
                            <th class="proponente right-align">Qtd. Inteira</th>
                            <th class="proponente right-align">Qtd. Meia</th>
                            <th class="proponente right-align">Valor m&eacute;dio</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="center-align">{{produto.QtdeProduzida}}</td>
                            <td class="gratuito right-align">{{produto.QtdeProponente}}</td>
                            <td class="gratuito right-align">{{produto.QtdePatrocinador}}</td>
                            <td class="gratuito right-align">{{produto.QtdeOutros}}</td>
                            <td class="popular right-align">{{produto.QtdeVendaPopularNormal}}</td>
                            <td class="popular right-align">{{produto.QtdeVendaPopularPromocional}}</td>
                            <td class="popular right-align">{{produto.ReceitaPopularNormal}}</td>
                            <td class="proponente right-align">{{produto.QtdeVendaNormal}}</td>
                            <td class="proponente right-align">{{produto.QtdeVendaPromocional}}</td>
                            <td class="proponente right-align">{{produto.PrecoUnitarioNormal}}</td>
                            <td class="right-align">{{produto.Receita}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </li>
        </ul>
    </div>
    `,
    data: function () {
        return {
            "dsProduto": '', // Categoria
            "qtExemplares": 0, // Quantidade de exemplar / Ingresso
            "qtGratuitaDivulgacao": 0,
            "qtGratuitaPatrocinador": 0,
            "qtGratuitaPopulacao": 0,
            "vlUnitarioPopularIntegral": 0.0, // Preço popular: Preço Unitario do Ingresso
            "qtPrecoPopularValorIntegral": 0, //Preço Popular: Quantidade de Inteira
            "qtPrecoPopularValorParcial": 0,//Preço Popular: Quantidade de meia entrada
            "vlUnitarioProponenteIntegral": 0,
            "qtPopularIntegral": 0,
            "qtPopularParcial": 0,
            produto: {}, // produto sendo manipulado
            produtos: [], // lista de produtos
            active: false,
            icon: 'add',
            radio: 'n'
        }
    },
    props: [
        'idpreprojeto',
        'idplanodistribuicao',
        'idmunicipioibge',
        'iduf',
        'arrayProdutos'
    ],
    computed: {},
    watch: {
        idpreprojeto: function (value) {
            this.fetch(value);
        },
        arrayProdutos: function (value) {
            this.produtos = value;
        }
    },
    mounted: function () {
        if (typeof this.idpreprojeto != 'undefined') {
            this.fetch(this.idpreprojeto);
        }
    },
    methods: {
        fetch: function () {
            let vue = this;

            $3.ajax({
                type: "GET",
                url: "/proposta/visualizar/obter-plano-distribuicacao/idPreProjeto/",
                data: {
                    idPreProjeto: vue.idpreprojeto,
                    idPlanoDistribuicao: vue.idplanodistribuicao
                }
            }).done(function (response) {
                vue.produtos = response.data;
            });
        }
    }
});
