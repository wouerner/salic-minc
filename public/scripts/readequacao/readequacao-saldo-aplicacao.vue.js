Vue.component('readequacao-saldo-aplicacao', {
    template: `
	<div class='readequacao-saldo-aplicacao'>
	    <div class="card">
		<div class="card-content">
		    <div class="col s2">
			<b>Pronac: </b>{{ pronac }}<br>
		    </div>
			    <div class="col s8">
				<b>Projeto: </b><span v-html="nomeProjeto"></span>
			    </div>
				    <br/>
		</div>
	    </div>
				    
				    <div v-show="exibirBotaoSolicitarUsoreadequacaoObtida">
					<button class="waves-effect waves-light btn btn-primary small btn-novaproposta"
						name=""
					    v-on:click="solicitarUsoSaldo()"
						id="novo">
					    <i class="material-icons left">border_color</i>Solicitar uso do saldo de aplica&ccedil;&atilde;o
					</button>
				    </div>
						
						<ul v-if="!disabled"  class="collapsible" v-show="solicitacaoIniciada">
						    <li id="collapsible-first">
							<div class="collapsible-header active"><i class="material-icons">assignment</i>Solicita&ccedil;&atilde;o de readequa&ccedil;&atilde;o</div>
							    <div class="collapsible-body">
								<readequacao-formulario
									    ref="formulario"
								    :id-pronac="idPronac"
								    :disabled="disabled"
								    :id-tipo-readequacao="idTipoReadequacao"
								    :componente-ds-solicitacao='componente'
								    :objReadequacao="readequacao"
								    v-on:eventoAtualizarReadequacao="atualizarReadequacao"
								    v-on:eventoSalvarReadequacao="salvarReadequacao"
								    >
								</readequacao-formulario>
							    </div>
						    </li>
								    <li>
									<div class="collapsible-header"><i class="material-icons">list</i>Editar planilha or&ccedil;ament&aacute;ria</div>
									    <div class="collapsible-body card" >
										<div class="card-content">
										</div>	
									    </div>
								    </li>
						</ul>
	</div>
    `,
    props: {
	'idPronac': '',
	'idTipoReadequacao': '',
	'nomeProjeto': '',
	'pronac' : '',
	'siEncaminhamento': '',
	'disabled': false
    },
    mixins: [utils],
    data: function() {
	var readequacao = {
	    'idPronac': null,
	    'idReadequacao': null,
	    'justificativa': '',
	    'arquivo': null,
	    'idTipoReadequacao': null,
	    'dsSolicitacao': '',
	    'idArquivo' : null,
	    'nomeArquivo': null
	};
	
	return {
	    readequacao,
	    solicitacaoIniciada: false,
	    componente: 'readequacao-saldo-aplicacao-saldo'
	}
    },
    created: function() {
	this.obterDadosReadequacao();
    },
    mounted: function() {
    },
    methods: {
        obterDadosReadequacao: function () {
            let self = this;
            $3.ajax({
                type: "GET",
                url: "/readequacao/readequacoes/obter-dados-readequacao",
                data: {
                    idTipoReadequacao: self.idTipoReadequacao,
                    idPronac: self.idPronac,
		    siEncaminhamento: self.siEncaminhamento
                }
            }).done(function (response) {
		if (_.isObject(response.readequacao)) {
                    self.readequacao = response.readequacao;
		    if (typeof response.readequacao.idReadequacao != 'undefined') {
			self.solicitacaoIniciada = true;
		    }
		}
            });
        },
	solicitarUsoSaldo: function() {
	    self = this;
	    this.solicitacaoIniciada = true;
	    
	    $3.ajax({
		url: "/readequacao/saldo-aplicacao/solicitar-uso-saldo",
		type: 'POST',
		data: {
		    idPronac: self.idPronac
		},
		done: function(data) {
		    self.readequacao = data.readequacao;
		}
	    });
	    
	},
	salvarReadequacao: function(readequacao) {
	    if (readequacao.dsSolicitacao == '' ||
		readequacao.dsSolicitacao == undefined
	    ) {
		this.mensagemAlerta("\xC9 obrigat\xF3rio informar o saldo dispon\xEDvel.!");
		this.$refs.formulario.$children[0].$refs.readequacaoSaldo.focus();
		return;		
	    }
	    
	    if (readequacao.justificativa.length == 0) {
		this.mensagemAlerta("\xC9 obrigat\xF3rio preencher a justificativa da readequa\xE7\xE3o!");
		this.$refs.formulario.$refs.readequacaoJustificativa.focus();
		
		return;
	    }
	    
	    let self = this;
            $3.ajax({
                type: "POST",
                url: "/readequacao/saldo-aplicacao/salvar-readequacao",
		data: {
		    idPronac: this.idPronac,
		    idReadequacao: readequacao.idReadequacao,
		    justificativa: readequacao.justificativa,
		    dsSolicitacao: readequacao.dsSolicitacao
		}
            }).done(function (response) {
		$3('.collapsible').collapsible('close', 0);
		$3('.collapsible').collapsible('open', 1);
		self.readequacao = readequacao;
                self.mensagemSucesso(response.msg);
            });
	},
	atualizarReadequacao: function (readequacao) {
            this.readequacao = readequacao;
        }
    },
    computed: {
	exibirBotaoSolicitarUsoreadequacaoObtida: function() {
	    if ((typeof this.readequacao.idReadequacao == 'null'
	       ||typeof this.readequacao.idReadequacao == 'undefined'
	    )
		&& (!this.solicitacaoIniciada)) {
		return true;
	    }
	}
    }
});
