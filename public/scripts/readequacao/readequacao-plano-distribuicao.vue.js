Vue.component('readequacao-plano-distribuicao', {
    template: `
        <div class="readequacao-plano-distribuicao">
            <plano-distribuicao-listagem
                :id-projeto="idPronac"
                :disabled="disabled"
                :array-produtos="produtos"
                :array-detalhamentos="detalhamentos"
                :componente-detalhamento="componenteDetalhamento"
                :array-locais="locais"
            ></plano-distribuicao-listagem>
        </div>
    `,
    data: function () {
        return {
            produtos: {},
            detalhamentos: {},
            locais: {},
            disabled: false,
            componenteDetalhamento: "readequacao-plano-distribuicao-detalhamentos"
        }
    },
    props: [
        'idPronac'
    ],
    watch: {
        idPronac: function (value) {
            this.fetch(value);
        }
    },
    mounted: function () {
        if (typeof this.idPronac != 'undefined') {
            this.obterPlanoDistribuicao(this.idPronac);
            this.obterLocaisRealizacao(this.idPronac);
        }
    },
    methods: {
        obterPlanoDistribuicao: function (id) {
            let vue = this;
            $3.ajax({
                type: "GET",
                url: "/readequacao/plano-distribuicao/obter-plano-distribuicao-detalhamentos-ajax",
                data: {
                    idPronac: id
                }
            }).done(function (response) {
                let dados = response.data;
                vue.produtos = dados.planodistribuicao;
                vue.detalhamentos = dados.detalhamentos;
            });
        },
        obterLocaisRealizacao: function (id) {
            let vue = this;
            $3.ajax({
                type: "GET",
                url: "/readequacao/local-realizacao/obter-locais-de-realizacao-ajax",
                data: {
                    idPronac: id
                }
            }).done(function (response) {
                vue.locais  = response.data;
            });
        }
    }
});