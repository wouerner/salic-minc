Vue.component('salic-proposta-plano-distribuicao', {
    template: `
    <div class="plano-distribuicao card" v-if="produtos">
        <div v-if="produtos.length <= 0" class="padding10">
            <b>Aguarde! Carregando....</b>
        </div>
        <ul class="collapsible collapsible-produto no-padding" data-collapsible="expandable">
            <li v-for="produto of produtos">
                <div class="collapsible-header green-text">
                    <i class="material-icons">perm_media</i> {{produto.Produto}}
                </div>
                <div class="collapsible-body no-padding margin10 scroll-x">
                    <table class="bordered">
                        <thead>
                           <tr>
                                <th>&Aacute;rea</th>
                                <th>Segmento</th>
                                <th>Principal</th>
                                <th>Canal aberto?</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{produto.DescricaoArea}}</td>
                                <td>{{produto.DescricaoSegmento}}</td>
                                <td>{{label_sim_ou_nao(produto.stPrincipal)}}</td>
                                <td>{{label_sim_ou_nao(produto.canalAberto)}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="bordered">
                        <thead>
                            <tr>
                                <th colspan="3" class="center-align gratuito padding10">Quantidade Distribui&ccedil;&atilde;o Gratuita</th>
                            </tr>
                            <tr>
                                <td class="gratuito">Divulga&ccedil;&atilde;o</td>
                                <td class="gratuito">Patrocinador</td>
                                <td class="gratuito">Popula&ccedil;&atilde;o</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="gratuito">{{produto.QtdeProponente}}</td>
                                <td class="gratuito">{{produto.QtdePatrocinador}}</td>
                                <td class="gratuito">{{produto.QtdeOutros}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="bordered">
                        <thead>
                            <tr>
                                <th colspan="3" class="center-align popular padding10">Pre&ccedil;o Popular</th>
                            </tr>
                            <tr>
                                <td class="popular">Quantidade Inteira</td>
                                <td class="popular">Quantidade Meia</td>
                                <td class="popular">Valor m&eacute;dio</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="popular">{{produto.QtdeVendaPopularNormal}}</td>
                                <td class="popular">{{produto.QtdeVendaPopularPromocional}}</td>
                                <td class="popular">{{produto.ReceitaPopularNormal}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="bordered">
                        <thead>
                            <tr>
                                <th colspan="3" class="center-align proponente padding10">Proponente</th>
                            </tr>
                            <tr>
                                <td class="proponente">Quantidade Inteira</td>
                                <td class="proponente">Quantidade Meia</td>
                                <td class="proponente">Valor m&eacute;dio</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="proponente">{{produto.QtdeVendaNormal}}</td>
                                <td class="proponente">{{produto.QtdeVendaPromocional}}</td>
                                <td class="proponente">{{produto.PrecoUnitarioNormal}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="bordered">
                        <thead>
                           <tr>
                                <th class="center-align">Quantidade Total</th>
                                <th class="center-align">Receita Prevista Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="right-align">{{produto.QtdeProduzida}}</td>
                                <td class="right-align">{{produto.Receita}}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <salic-proposta-detalhamento-plano-distribuicao 
                        :arrayDetalhamentos="detalhamentosByID(detalhamentos, produto.idPlanoDistribuicao)">
                    </salic-proposta-detalhamento-plano-distribuicao>
                </div>
            </li>
        </ul>
    </div>
    `,
    data: function () {
        return {
            produtos: [],
            detalhamentos: [],
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
        'arrayProdutos',
        'arrayDetalhamentos'
    ],
    computed: {

    },
    watch: {
        idpreprojeto: function (value) {
            this.fetch(value);
        },
        arrayProdutos: function (value) {
            this.produtos = value;
        },
        arrayDetalhamentos: function (value) {
            this.detalhamentos = value;
        }
    },
    mounted: function () {
        if (typeof this.idpreprojeto != 'undefined') {
            this.fetch(this.idpreprojeto);
        }

        if (typeof this.arrayProdutos != 'undefined') {
            this.produtos = this.arrayProdutos;
        }

        if (typeof this.arrayDetalhamentos != 'undefined') {
            this.detalhamentos = this.arrayDetalhamentos;
        }

        this.iniciarCollapsible();
    },
    methods: {
        fetch: function () {
            let vue = this;

            $3.ajax({
                type: "GET",
                url: "/proposta/visualizar/obter-plano-distribuicacao",
                data: {
                    idPreProjeto: vue.idpreprojeto
                }
            }).done(function (response) {
                let dados = response.data;
                vue.produtos = dados.planodistribuicaoproduto;
                vue.detalhamentos = dados.tbdetalhaplanodistribuicao;
            });
        },
        detalhamentosByID: function (lista, id) {

            let novaLista = [];

            if(typeof lista != 'undefined') {
                Object.keys(lista)
                    .map(function(key) {
                        if(lista[key].idPlanoDistribuicao == id) {
                            novaLista.push(lista[key]);
                        }
                    });

                return novaLista;
            }
            return lista;
        },
        label_sim_ou_nao: function (valor) {
            if (valor == 1)
                return 'Sim';
            else
                return 'N\xE3o';
        },
        iniciarCollapsible: function () {
            $3('.collapsible').each(function () {
                $3(this).collapsible();
            });
        },
    }
});
