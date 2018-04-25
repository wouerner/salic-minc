Vue.component('readequacao-plano-distribuicao', {
    template: `
        <div class="readequacao-plano-distribuicao">
            <plano-distribuicao-listagem
                :id-projeto="idPronac"
                :disabled="disabled"
                :array-produtos="produtos"
                :array-detalhamentos="detalhamentos"
                :componente-filho="componenteDetalhamento"
            ></plano-distribuicao-listagem>
        </div>
    `,
    data: function () {
        return {
            produtos: {},
            detalhamentos: {},
            disabled: false,
            componenteDetalhamento: "readequacao-plano-distribuicao-detalhamentos"
        }
    },
    props: [
        'idPronac'
    ],
    watch: {
        idPronac: function (value) {
            console.log('id', value);
            this.fetch(value);
        }
    },
    mounted: function () {
        if (typeof this.idPronac != 'undefined') {
            this.fetch(this.idPronac);
        }
    },
    methods: {
        fetch: function (id) {
            let vue = this;

            $3.ajax({
                type: "GET",
                url: "/proposta/visualizar/obter-plano-distribuicacao",
                data: {
                    idPreProjeto: id
                }
            }).done(function (response) {
                let dados = response.data;
                vue.produtos = dados.planodistribuicaoproduto;
                vue.detalhamentos = dados.tbdetalhaplanodistribuicao;
            });
        }
    }
});