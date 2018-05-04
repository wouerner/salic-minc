Vue.component('readequacao-plano-distribuicao', {
    template: `
        <div class="readequacao-plano-distribuicao padding10">
            <plano-distribuicao-listagem
                :id-projeto="idPronac"
                :disabled="disabled"
                :array-produtos="produtos"
                :array-detalhamentos="detalhamentos"
                :componente-detalhamento="componenteDetalhamento"
                :array-locais="locais"
            ></plano-distribuicao-listagem>
            
            <div class="center-align">
                <a 
                    class="waves-effect waves-light btn white-text"
                    @click="consolidarPlanoDistribuicao(idPronac)"
                >
                    <i class="material-icons right">send</i>
                    Salvar
                </a>
            </div>
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
    mixins:[utils],
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
            let self = this;
            $3.ajax({
                type: "GET",
                url: "/readequacao/plano-distribuicao/obter-plano-distribuicao-detalhamentos-ajax",
                data: {
                    idPronac: id
                }
            }).done(function (response) {
                let dados = response.data;
                self.produtos = dados.planodistribuicao;
                self.detalhamentos = dados.detalhamentos;
            }).fail(function(response) {
                self.mensagemErro(response.responseJSON.msg)
            });
        },
        obterLocaisRealizacao: function (id) {
            let self = this;
            $3.ajax({
                type: "GET",
                url: "/readequacao/local-realizacao/obter-locais-de-realizacao-ajax",
                data: {
                    idPronac: id
                }
            }).done(function (response) {
                self.locais  = response.data;
            }).fail(function(response) {
              self.mensagemErro(response.responseJSON.msg)
            });
        },
        consolidarPlanoDistribuicao: function(id) {
            let self = this;
            $3.ajax({
                type: "GET",
                url: "/readequacao/plano-distribuicao/consolidar-plano-distribuicao-ajax",
                data: {
                    idPronac: id
                }
            }).done(function (response) {
                self.mensagemSucesso(response.msg)
            }).fail(function(response) {
                self.mensagemErro(response.responseJSON.msg)
            });

        }
    }
});