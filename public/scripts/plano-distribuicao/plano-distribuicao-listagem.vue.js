Vue.component('plano-distribuicao-listagem', {
    template: `
    <div class="plano-distribuicao-listagem card" v-if="produtos">
        <div v-if="produtos.length <= 0" class="padding10">
            <b>Aguarde! Carregando....</b>
        </div>
        <ul class="collapsible collapsible-produto no-padding" data-collapsible="expandable">
            <li v-for="produto of produtos">
                <div class="collapsible-header green-text">
                    <i class="material-icons">perm_media</i> {{produto.Produto}}
                </div>
                <div class="collapsible-body no-padding margin10 scroll-x">
                    <ul class="collapsible collapsible-locais no-padding" data-collapsible="expandable">
                        <li v-for="local of locais">
                            <div class="collapsible-header black-text">
                                <i class="material-icons">place</i> {{local.uf}} - {{local.cidade}}
                            </div>
                            <div class="collapsible-body no-padding margin10 scroll-x">
                                <component
                                    v-bind:is="componenteProdutoCabecalho"
                                    :produto="produto"
                                ></component>
                                <component
                                    v-bind:is="componenteDetalhamento"
                                    :disabled="disabled"
                                    :produto="produto"
                                    :local="local"
                                    :array-detalhamentos="detalhamentosByID(detalhamentos, produto.idPlanoDistribuicao)"
                                ></component>
                                <component
                                    v-bind:is="componenteProdutoRodape"
                                    :produto="produto"
                                ></component>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    `,
    data: function () {
        return {
            produtos: [],
            detalhamentos: [],
            locais: [],
            active: false,
            icon: 'add',
            radio: 'n'
        }
    },
    props: {
        'idProjeto': null,
        'arrayProdutos': {},
        'arrayDetalhamentos': {},
        'arrayLocais': {},
        'componenteDetalhamento': {
            default: 'salic-proposta-detalhamento-plano-distribuicao',
            type: String
        },
        'componenteProdutoCabecalho': {
            default: 'plano-distribuicao-visualizar-produto-cabecalho',
            type: String
        },
        'componenteProdutoRodape': {
            default: '',
            type: String
        },
        'disabled': false
    },
    computed: {
    },
    watch: {
        arrayProdutos: function (value) {
            this.produtos = value;
        },
        arrayDetalhamentos: function (value) {
            this.detalhamentos = value;
        },
        arrayLocais: function (value) {
            this.locais = value;
        }
    },
    updated: function(){
        this.iniciarCollapsible();
    },
    mounted: function () {
        if (typeof this.arrayProdutos != 'undefined') {
            this.produtos = this.arrayProdutos;
        }

        if (typeof this.arrayDetalhamentos != 'undefined') {
            this.detalhamentos = this.arrayDetalhamentos;
        }

        if (typeof this.arrayLocais != 'undefined') {
            this.locais = this.arrayLocais;
        }
    },
    methods: {
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
