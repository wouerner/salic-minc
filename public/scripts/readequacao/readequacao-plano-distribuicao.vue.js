Vue.component('readequacao-plano-distribuicao', {
    template: `
        <div class="readequacao-plano-distribuicao">
            <div v-show="!mostrarFormulario" id="mensagem" class="card">
                <div class="card-content">
                    <p class="center-align">Aqui você pode readequar os detalhamentos do seu plano de
                        distribuição.</p>
                    <br>
                    <p class="center-align bold">
                        <a class="waves-effect waves-light btn white-text btn-incluir-novo-item"
                           @click="mostrarFormulario = !mostrarFormulario"
                           >
                            <i class="material-icons left">add</i>
                            <strong>Iniciar readequa&ccedil;&atilde;o</strong>
                        </a>
                    </p>
                </div>
            </div>
            <ul v-if="mostrarFormulario" class="collapsible no-padding" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header active"><i class="material-icons">edit</i>Alterar Plano de Distribui&ccedil;&atilde;o</div>
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
                    <div class="collapsible-header"><i class="material-icons">assignment</i>Salvar Solicita&ccedil;&atilde;o</div>
                    <div class="collapsible-body padding10">
                        <readequacao-formulario
                            v-if="mostrarFormulario"
                            :disabled="disabled"
                            ref="formulario"
                            :id-pronac="idPronac"
                            :id-tipo-readequacao="idTipoReadequacao"
                            v-on:eventoSalvarReadequacao="salvarReadequacao"
                        ></readequacao-formulario>
                    </div>
                </li>
            </ul>
            <readequacao-botoes-footer
                v-if="mostrarFormulario"
                :disabled="disabled"
                :active="active"
                :id-pronac="idPronac"
                :id-tipo-readequacao="idTipoReadequacao"
                v-on:eventoBotoes="tratarEventoBotoes"
            ></readequacao-botoes-footer>
        </div>
    `,
    data: function () {
        return {
            produtos: {},
            detalhamentos: {},
            locais: {},
            active: true,
            mostrarFormulario: false,
            idTipoReadequacao: 11,
            componenteDetalhamento: "readequacao-plano-distribuicao-detalhamentos"
        }
    },
    props: {
        'idPronac': '',
        'idReadequacao': '',
        'disabled': false
    },
    mixins: [utils],
    watch: {
        mostrarFormulario: function (value) {
            if (value === true) {
                this.obterPlanoDistribuicao(this.idPronac);
                this.obterLocaisRealizacao(this.idPronac);
            }
        }
    },
    created: function () {
        let self = this;
        detalhamentoEventBus.$on('busAtualizarProdutos', function (response) {
            self.obterPlanoDistribuicao(self.idPronac);
        });

        if (this.idReadequacao != '') {
            console.log('teste');
            this.mostrarFormulario = true;
        }

        $3(document).ajaxStart(function () {
            $3('#container-loading').fadeIn('slow');
        });
        $3(document).ajaxComplete(function () {
            $3('#container-loading').fadeOut('slow');
        });
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
            }).fail(function (response) {
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
                self.locais = response.data;
            }).fail(function (response) {
                self.mensagemErro(response.responseJSON.msg)
            });
        },
        salvarReadequacao: function (readequacao) {
            console.log(readequacao);
        },
        tratarEventoBotoes: function () {
            console.log('eventooo');
        }
    }
});

Vue.component('readequacao-botoes-footer', {
    template: `
        <div class="readequacao-plano-distribuicao padding20 center-align">
            <a
                href="javascript:void(0)"
                class="btn waves-effect waves-light btn-danger btn-excluir"
                title="Excluir readequa&ccedil;&atilde;o"
                readequacao="<?php echo $this->readequacao->idReadequacao; ?>"
            >Excluir <i class="material-icons right">delete</i>
            </a>
            <a
                href="javascript:void(0)"
                class="waves-effect waves-light btn btn-secondary"
                id="btn_finalizar"
            >
                <i class="material-icons right">send</i>Finalizar
            </a>
        </div>
    `,
    props: {
        'idPronac': '',
        'disabled': false
    }
});