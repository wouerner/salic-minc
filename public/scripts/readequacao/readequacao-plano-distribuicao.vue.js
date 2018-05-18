Vue.component('readequacao-plano-distribuicao', {
    template: `
        <div class="readequacao-plano-distribuicao">
            <div v-if="mostrarMensagem" id="mensagem" class="card">
                <div class="card-content">
                    <p class="center-align">Aqui voc&ecirc; pode readequar os detalhamentos do seu plano de
                        distribui&ccedil;&atilde;o.</p>
                    <br>
                    <p class="center-align bold">
                        <a class="waves-effect waves-light btn white-text btn-incluir-novo-item"
                           @click.prevent="criarReadequacao"
                           >
                            <i class="material-icons left">add</i>
                            <strong>Iniciar readequa&ccedil;&atilde;o</strong>
                        </a>
                    </p>
                </div>
            </div>
            <ul v-if="mostrarFormulario" class="collapsible no-padding" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header active"><i class="material-icons">edit</i>Readequar Plano de Distribui&ccedil;&atilde;o</div>
                    <div class="collapsible-body padding10">
                        <plano-distribuicao-listagem
                            :id-projeto="idPronac"
                            :disabled="disabled"
                            :active="active"
                            :array-produtos="produtos"
                            :array-detalhamentos="detalhamentos"
                            :componente-detalhamento="componenteDetalhamento"
                            :array-locais="locais"
                        ></plano-distribuicao-listagem>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">assignment</i>Justificar readequa&ccedil;&atilde;o</div>
                    <div class="collapsible-body padding10">
                        <readequacao-formulario
                            v-if="mostrarFormulario"
                            :disabled="disabled"
                            ref="formulario"
                            :id-pronac="idPronac"
                            :id-tipo-readequacao="idTipoReadequacao"
                            v-on:eventoSalvarReadequacao="atualizarReadequacao"
                        ></readequacao-formulario>
                    </div>
                </li>
            </ul>
            <div v-if="mostrarFormulario" class="readequacao-plano-distribuicao padding20 center-align">
                <a
                    href="javascript:void(0)"
                    class="btn waves-effect waves-light btn-danger btn-excluir"
                    title="Excluir readequa\u00E7\u00E3o"
                    @click="excluirReadequacao"
                >Excluir <i class="material-icons right">delete</i>
                </a>
                <a
                    href="javascript:void(0)"
                    class="waves-effect waves-light btn btn-secondary"
                    title="Finalizar readequa\u00E7\u00E3o e enviar para o MinC"
                    @click="finalizarReadequacao"
                >Finalizar<i class="material-icons right">send</i>
                </a>
            </div>
        </div>
    `,
    data: function () {
        return {
            produtos: {},
            detalhamentos: {},
            locais: {},
            active: true,
            mostrarFormulario: false,
            mostrarMensagem: false,
            idTipoReadequacao: 11,
            componenteDetalhamento: "readequacao-plano-distribuicao-detalhamentos"
        }
    },
    props: {
        'idPronac': '',
        'disabled': false
    },
    mixins: [utils],
    watch: {
        produtos: function (value) {
            if (value.length > 0) {
                this.mostrarFormulario = true;
                this.obterLocaisRealizacao()
            } else {
                this.mostrarMensagem = true;
            }
        }
    },
    created: function () {
        let self = this;
        detalhamentoEventBus.$on('busAtualizarProdutos', function (response) {
            self.obterPlanoDistribuicao();
        });

        this.obterPlanoDistribuicao();

        $3(document).ajaxStart(function () {
            $3('#container-loading').fadeIn('slow');
        });
        $3(document).ajaxComplete(function () {
            $3('#container-loading').fadeOut('slow');
        });
    },
    methods: {
        criarReadequacao: function () {
            let self = this;
            $3.ajax({
                type: "GET",
                url: "/readequacao/plano-distribuicao/criar-readequacao-ajax",
                data: {
                    idPronac: self.idPronac
                }
            }).done(function (response) {
                self.obterPlanoDistribuicao(self.idPronac);
                self.mostrarMensagem = false;
                self.mostrarFormulario = true;
            }).fail(function (response) {
                self.mensagemErro(response.responseJSON.msg)
            });
        },
        atualizarReadequacao: function (readequacao) {
            let self = this;
            $3.ajax({
                type: "POST",
                url: "/readequacao/plano-distribuicao/atualizar-readequacao-ajax",
                data: readequacao
            }).done(function (response) {
                self.mensagemSucesso(response.msg);
            }).fail(function (response) {
                self.mensagemErro(response.responseJSON.msg)
            });
        },
        obterPlanoDistribuicao: function () {
            let self = this;
            $3.ajax({
                type: "GET",
                url: "/readequacao/plano-distribuicao/obter-plano-distribuicao-detalhamentos-ajax",
                data: {
                    idPronac: self.idPronac
                }
            }).done(function (response) {
                let dados = response.data;
                self.produtos = dados.planodistribuicao;
                self.detalhamentos = dados.detalhamentos;
            }).fail(function (response) {
                self.mensagemErro(response.responseJSON.msg)
            });
        },
        obterLocaisRealizacao: function () {
            let self = this;
            $3.ajax({
                type: "GET",
                url: "/readequacao/local-realizacao/obter-locais-de-realizacao-ajax",
                data: {
                    idPronac: self.idPronac
                }
            }).done(function (response) {
                self.locais = response.data;
            }).fail(function (response) {
                self.mensagemErro(response.responseJSON.msg)
            });
        },
        excluirReadequacao: function () {
            let self = this;
            $3.ajax({
                type: "GET",
                url: "/readequacao/plano-distribuicao/excluir-readequacao-plano-distribuicao-ajax",
                data: {
                    idPronac: self.idPronac
                }
            }).done(function (response) {
                self.restaurarFormulario();
                self.mensagemSucesso(response.msg);
            }).fail(function (response) {
                self.mensagemErro(response.responseJSON.msg)
            });
        },
        finalizarReadequacao: function () {
            let self = this;
            $3.ajax({
                type: "GET",
                url: "/readequacao/plano-distribuicao/finalizar-readequacao-plano-distribuicao-ajax",
                data: {
                    idPronac: self.idPronac,
                    idTipoReadequacao: self.idTipoReadequacao
                }
            }).done(function (response) {
                self.mensagemSucesso(response.msg);
                self.active = false;
                self.mostrarFormulario = false;
            }).fail(function (response) {
                self.mensagemErro(response.responseJSON.msg)
            });
        },
        restaurarFormulario: function () {
            Object.assign(this.$data, this.$options.data.apply(this))
        }
    }
});