Vue.component('readequacao-plano-distribuicao-detalhamentos', {
    template: `
        <div class="readequacao-plano-distribuicao-detalhamentos">
            <plano-distribuicao-detalhamentos-listagem
                :disabled="disabled"
                :detalhamentos="detalhamentos"
                :canalaberto="produto.canalAberto"
                :local="local"
                 v-on:eventoRemoverDetalhamento="removerDetalhamento"
                 v-on:eventoEditarDetalhamento="editarDetalhamento"
                >
            </plano-distribuicao-detalhamentos-listagem>
            <plano-distribuicao-detalhamentos-formulario
                :disabled="disabled"
                :idplanodistribuicao="produto.idPlanoDistribuicao"
                :local="local"
                :editarDetalhamento="detalhamento"
                v-on:eventoSalvarDetalhamento="salvarDetalhamento"
                >
            </plano-distribuicao-detalhamentos-formulario>
        </div>
    `,
    data: function () {
        return {
            detalhamentos: [],
            detalhamento: {}
        }
    },
    mixins: [utils],
    props: [
        'id',
        'produto',
        'local',
        'arrayDetalhamentos',
        'disabled'
    ],
    mounted: function () {
        this.obterDetalhamentos();
    },
    methods: {
        removerDetalhamento(detalhamento, index) {
            let vue = this;
            $3.ajax({
                type: "POST",
                url: "/readequacao/plano-distribuicao/excluir-detalhamento-ajax/idPronac/" + vue.id,
                data: detalhamento
            }).done(function (response) {
                if (response.success == 'true') {
                    let index = vue.$data.detalhamentos.map(item => item.idDetalhaPlanoDistribuicao).indexOf(response.data.idDetalhaPlanoDistribuicao);
                    Vue.delete(vue.detalhamentos, index);
                    vue.$data.detalhamentos.push(response.data);
                    vue.mensagemSucesso(response.msg);
                    detalhamentoEventBus.$emit('callBackSalvarDetalhamento', true);
                }
            }).fail(function (response) {
                vue.mensagemErro(response.responseJSON.msg);
            });
        },
        editarDetalhamento(detalhamento, index) {
            this.detalhamento = detalhamento;
        },
        salvarDetalhamento(detalhamento) {
            let vue = this;
            $3.ajax({
                type: "POST",
                url: "/readequacao/plano-distribuicao/salvar-detalhamento-ajax/idPronac/" + vue.id,
                data: detalhamento
            }).done(function (response) {
                if (response.success == 'true') {
                    let index = vue.$data.detalhamentos.map(item => item.idDetalhaPlanoDistribuicao).indexOf(response.data.idDetalhaPlanoDistribuicao);
                    Vue.delete(vue.detalhamentos, index);
                    vue.$data.detalhamentos.push(response.data);
                    vue.mensagemSucesso(response.msg);
                    detalhamentoEventBus.$emit('callBackSalvarDetalhamento', true);
                }
            }).fail(function (response) {
                vue.mensagemErro(response.responseJSON.msg);
            });
        },
        obterDetalhamentos: function () {
            var vue = this;
            vue.$data.detalhamentos =  this.arrayDetalhamentos;
        }
    }
});

var detalhamentoEventBus = new Vue();