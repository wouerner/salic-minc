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
				<input type="file" 
				       name="arquivo" 
				       id="arquivo"
				@change="subirDocumento">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
		    <div class="col s1">
			<a
			  v-show="readequacao.idDocumento"
			    v-on:click="excluirDocumento"
			  class="btn small waves-effect waves-light btn-danger">
			    <i class="material-icons">delete</i>Salvar
			</a>		
		    </div>
                    <div class="col s11">
			<a v-bind:href="'/upload/abrir?id=' + readequacao.idDocumento" v-if="readequacao.idDocumento !=''">
                            {{readequacao.nomeArquivo }} 
			</a>
		    </div>
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
            },
	    arquivo: {
		tamanhoMaximo: 500000,
		tiposAceitos: ['pdf']
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
        },
	subirDocumento: function() {
	    let arquivo = $('#arquivo')[0].files[0],
		self = this;
	    
	    if (!this.validarDocumento(arquivo)) {
		return;
	    }
	    
	    var formData = new FormData();
	    formData.append('arquivo', arquivo);
	    formData.append('idPronac', self.idPronac);
	    formData.append('idReadequacao', self.readequacao.idReadequacao);
	    formData.append('idDocumentoAtual', self.arquivo.idDocumento);
	    formData.append('idTipoReadequacao', self.readequacao.idTipoReadequacao);
	    
	    $3.ajax(
		Object.assign(
		    {},
		    {
			type: "POST",
			url: "/readequacao/readequacoes/salvar-arquivo/idPronac/" + self.idPronac,
			processData: false, 
			contentType: false, 			
		    },
		    {
			data: formData,
		    }
		)
	    ).done(function(response) {
		self.readequacao.idDocumento = response.documento.idDocumento;
		self.readequacao.nomeArquivo = response.documento.nomeArquivo;
		self.readequacao.idReadequacao = response.readequacao.idReadequacao;
	    });
	},
	excluirDocumento: function() {
	    
	},
	validarDocumento: function(arquivo) {
	    if (!this.arquivo.tiposAceitos.includes(arquivo.name.split(".").pop().toLowerCase())) {
		this.mensagemAlerta("Extens\xE3o de arquivo inv\xE1lida. Envie arquivos nos tipos: " + this.arquivo.tiposAceitos.join(','));
		return;
	    }
	    
	    if (arquivo.size > this.arquivo.tamanhoMaximo) {
		this.mensagemAlerta("Arquivo ultrapassou o limite de " + this.arquivo.tamanhoMaximo);
		return;
	    }
	    
	    return true;
	}
    },
});
