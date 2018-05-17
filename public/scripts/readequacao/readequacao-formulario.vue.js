Vue.component('readequacao-formulario', {
    template: `
    <div class="card">
        <div class="card-content">
            <span class="card-title">Solicita&ccedil;&atilde;o de readequa&ccedil;&atilde;o</span>
            <input type="hidden" v-model="readequacao.idReadequacao"/>
            <div class="row">
                <div class="input-field col s12">
                    <textarea
                        id="textarea1"
                        class="materialize-textarea"
                        ref="readequacaoJustificativa"
                        v-model="readequacao.justificativa"></textarea>
                    <label for="textarea1">Justificativa *</label>
                </div>
            </div>
            <component
                v-bind:is="componenteDsSolicitacao"
                :ds-solicitacao="readequacao.dsSolicitacao"
                v-on:eventoAtualizarDsSolicitacao="readequacao.dsSolicitacao=$event"
            ></component>
            <div class="row">
                <div class="col s12">
                    <span>Anexar arquivo</span>
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>File</span>
                            <input type="file" name="arquivo" id="arquivo">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    <a v-bind:href="'/upload/abrir?id=' + readequacao.idDocumento" v-if="readequacao.idDocumento !=''">
                        {{readequacao.nomeArquivo }} 
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="center-align padding20 col s12">
                    <button
                        v-on:click="salvarReadequacao"
                        class="waves-effect waves-light btn btn-primary">
                        <i class="material-icons right">save</i>Salvar
                    </button>
                </div>
            </div>
        </div>
    </div>
    `,
    data: function () {
        return {
            readequacao: {
                'idPronac': null,
                'idReadequacao': null,
                'justificativa': '',
                'arquivo': null,
                'idTipoReadequacao': null,
                'dsSolicitacao': '',
                'idDocumento': null,
                'nomeArquivo': null
            }
        }
    },
    props: {
        'idPronac': '',
        'idTipoReadequacao': '',
        'componenteDsSolicitacao': ''
    },
    mixins: [utils],
    created: function () {
        this.obterDadosReadequacao();
    },
    methods: {
        obterDadosReadequacao: function (idPronac) {
            let self = this;
            $3.ajax({
                type: "GET",
                url: "/readequacao/readequacoes/obter-dados-readequacao",
                data: {
                    idTipoReadequacao: self.idTipoReadequacao,
                    idPronac: self.idPronac
                }
            }).done(function (response) {
                self.readequacao = response.readequacao;
            });
        },
        salvarReadequacao: function () {
            if (this.readequacao.justificativa.length == 0) {
                this.mensagemAlerta("\xC9 obrigat\xF3rio preencher a justificativa da readequa\xE7\xE3o!");
                this.$refs.readequacaoJustificativa.focus();
                return;
            }

            this.$emit('eventoSalvarReadequacao', this.readequacao);
        }
    }
});
