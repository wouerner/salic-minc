Vue.component('readequacao-plano-distribuicao-detalhamentos', {
    template: `
        <div class="readequacao-plano-distribuicao-detalhamentos">
            <plano-distribuicao-detalhamentos-listagem
                :disabled="disabled"
                :idplanodistribuicao="idplanodistribuicao"
                :idpreprojeto="idpreprojeto"
                :iduf="iduf"
                :idmunicipioibge="idmunicipioibge"
                :detalhamentos="detalhamentos"
                :canalaberto="canalaberto"
                 v-on:eventoRemoverDetalhamento="removerDetalhamento"
                 v-on:eventoEditarDetalhamento="editarDetalhamento"
                >
            </plano-distribuicao-detalhamentos-listagem>
            <plano-distribuicao-detalhamentos-formulario
                :disabled="disabled"
                :idplanodistribuicao="idplanodistribuicao"
                :idpreprojeto="idpreprojeto"
                :iduf="iduf"
                :idmunicipioibge="idmunicipioibge"
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
        'idpreprojeto',
        'idplanodistribuicao',
        'idmunicipioibge',
        'iduf',
        'disabled',
        'canalaberto',
        'arrayDetalhamentos'
    ],
    mounted: function () {
        this.obterDetalhamentos();
    },
    methods: {
        removerDetalhamento(detalhamento, index) {
            var vue = this;
            if (confirm("Tem certeza que deseja deletar o item?")) {
                $3.ajax({
                    type: "POST",
                    url: "/proposta/plano-distribuicao/detalhar-excluir/idPreProjeto/" + this.idpreprojeto,
                    data: {
                        idDetalhaPlanoDistribuicao: detalhamento.idDetalhaPlanoDistribuicao,
                        idPlanoDistribuicao: this.idplanodistribuicao
                    }
                }).done(function (response) {
                    if (response.success == 'true') {
                        Vue.delete(vue.detalhamentos, index);
                        vue.mensagemSucesso(response.msg);
                    }
                }).fail(function (response) {
                    vue.mensagemErro(response.responseJSON.msg);
                });
            }
        },
        editarDetalhamento(detalhamento, index) {
            this.detalhamento = detalhamento;
        },
        salvarDetalhamento(detalhamento) {

            let vue = this;
            $3.ajax({
                type: "POST",
                url: "/proposta/plano-distribuicao/detalhar-salvar/idPreProjeto/" + this.idpreprojeto,
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

            // url = "/proposta/plano-distribuicao/obter-detalhamentos/idPreProjeto/" + this.idpreprojeto + "?idPlanoDistribuicao=" + this.idplanodistribuicao + "&idMunicipio=" + this.idmunicipioibge + "&idUF=" + this.iduf
            // $3.ajax({
            //     type: "GET",
            //     url: url
            // }).done(function (data) {
            //     vue.$data.detalhamentos = data.data;
            // }).fail(function () {
            //     vue.mensagemErro('Erro ao buscar detalhamento');
            // });
            vue.$data.detalhamentos =  this.arrayDetalhamentos;
        }
    }
});

var detalhamentoEventBus = new Vue();