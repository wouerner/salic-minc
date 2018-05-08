Vue.component('readequacao-transferencia-recursos', {
    template: `
<div class='readequacao-transferencia-recursos'>
            <div class="card">
                <div class="card-content">
		    <span class="card-title">Projeto transferidor</span>
                    <div class="row">
                        <div class="col s3">
                            <b>Pronac: </b>{{ projeto.pronac }}<br>
                        </div>
                        <div class="col s3">
                            <b>Projeto: </b><span v-html="projeto.nomeProjeto"></span>
                        </div>
                        <div class="col s3">
                            <b>Vl. a Comprovar: </b>{{ projeto.valorComprovar }}
                        </div>
                        <div class="col s3">
                            <b>Saldo dispon&iacute;vel: </b>R$ {{ saldoDisponivel }}
                        </div>
                    </div>
		</div>
            </div>
	    
	    <div class="card">		
		<div class="card-content">
		    <span class="card-title">Solicita&ccedil;&atilde;o de readequa&ccedil;&atilde;o</span>
                    <input type="hidden" v-model="readequacao.idReadequacao" />
		    <div class="row">
			<div class="input-field col s12">
			    <textarea
				id="textarea1"
				class="materialize-textarea"
				ref="readequacaoJustificativa"
				v-model="readequacao.justificativa"></textarea>
			    <label for="textarea1">Justificativa</label>
			</div>
		    </div>
		    <div class="row">
			<div class="col s3">
			    <span>Tipo de transfer&ecirc;ncia</span>
			    <select
				class="browser-default"
				       ref="readequacaoTipoTransferencia"
				       v-model="readequacao.tipoTransferencia">
				<option v-for="tipo in tiposTransferencia" v-bind:value="tipo.id">{{tipo.nome}}</option>
			    </select>
			</div>
			<div class="col s3">
                            <span>Anexar arquivo</span>
			    <div class="file-field input-field">
				<div class="btn">
				    <span>File</span>
				    <input type="file">
				</div>
				<div class="file-path-wrapper">
				    <input class="file-path validate" type="text">
				</div>
			    </div>
			</div>
		    </div>
		    <div class="row">
			<div class="center-align padding20 col s6">
			    <button
				v-on:click="salvarReadequacao"
			       class="btn">Salvar</button>
			</div>
			<div class="center-align padding20 col s6">
			    <button
				v-on:click="finalizarReadequacao"
					    :disabled="!disponivelFinalizar"
					    class="btn">Finalizar</button>
			</div>

		    </div>
		</div>
	    </div>
	    
	    <div class="card"
		 v-show="disponivelAdicionarRecebedores">
		<div class="card-content">
		    <span class="card-title">Projetos recebedores</span>
		    <table v-show="exibeProjetosRecebedores">
			<thead>
			    <th>Pronac</th>
			    <th>Nome do projeto</th>
			    <th>Vl. transfer&ecirc;ncia</th>
			</thead>
			<tbody>
			    <tr v-for="(projeto, index) in projetosRecebedores">
				<td>{{ projeto.idPronac }}</td>
				<td>{{ projeto.nomeProjeto}}</td>
				<td>R$ {{ projeto.valorRecebido}}</td>
				<td>
				    <a href="javascript:void(0)"
				       v-on:click="excluirRecebedor(index)"
				       class="btn small">
					<i class="material-icons">delete</i>					
				    </a>
				</td>
			    </tr>
			</tbody>
			<tfoot>
			    <tr>
				<td colspan="2"></td>
				<td class="right">Total transferido: </td>
				<td>R$ {{ totalRecebido }} </td>
			    </tr>
			</tfoot>
		    </table>
		    
		    <form class="row">
			<div class="col s6">
			    <label>Projeto recebedor</label>
			    <select class="browser-default"
				    v-model="projetoRecebedor.idPronac"
				    ref="projetoRecebedorIdPronac"
				    :disabled="!disponivelAdicionarRecebedor">
				<option value="" disabled selected>Selecione o projeto</option>
				<option value="173321">173321 - Projeto abc</option>
				<option value="163321">163321 - Projeto def</option>
				<option value="153321">153321 - Projeto gehehe</option>
			    </select>
			</div>
 			<div class="input-field col s3">
			    <input-money
				ref="projetoRecebedorValorRecebido"
                                v-on:ev="projetoRecebedor.valorRecebido = $event"
                                v-bind:value="projetoRecebedor.valorRecebido"
				:disabled="!disponivelAdicionarRecebedor">
			    </input-money>
			    <label for="valor_recebido">Valor recebido</label>
			</div>		
			<div class="center-align padding20 col s3">
			    <a href="javascript:void(0)"
			       v-on:click="incluirRecebedor"
			       :disabled="!disponivelAdicionarRecebedor"
			       class="btn">Adicionar recebedor</a>
			</div>
		    </form>
		</div>
	    </div>
</div>
	    `,
    props: [
	'id-pronac',
	'id-tipo-readequacao'	
    ],
    data: function() {
	var projeto = {};
	var readequacao = {};
	var projetoRecebedor =  {};
	var projetosRecebedores = [];
	var tiposTransferencia = [
	    {
		'id': 1,
		'nome': 'N\xE3o homologados'
	    },
	    {
		'id': 2,
		'nome': 'Homologados'
	    },
	    {
		'id': 3,
		'nome': 'Recursos remanescentes'
	    }
	];

	return {
	    projeto,
	    readequacao,
	    projetoRecebedor,
	    projetosRecebedores,
	    tiposTransferencia
	}	
    },
    created: function() {
	this.obterDadosProjeto();
	this.obterDadosReadequacao();
    },
    mounted: function() {
    },
    methods: {
	incluirRecebedor: function() {
	    if (this.projetoRecebedor.idPronac == '' ||
		this.projetoRecebedor.idPronac == undefined
	    ) {
		this.mensagemAlerta("\xC9 obrigat\xF3rio informar o projeto recebedor!");
		this.$refs.projetoRecebedorIdPronac.focus();
                return;		
	    }
	    if (this.projetoRecebedor.valorRecebido == '' ||
		this.projetoRecebedor.valorRecebido == undefined
	    ) {
		this.mensagemAlerta("\xC9 obrigat\xF3rio informar o valor a ser recebido pelo projeto!");
		this.$refs.projetoRecebedorValorRecebido.$refs.input.focus();		
                return;
	    }
	    
	    var valorRecebido = parseFloat(this.projetoRecebedor.valorRecebido.replace(",", "."));
	    valorRecebido = valorRecebido.toFixed(2);
	    this.projetoRecebedor.valorRecebido = valorRecebido.replace(".", ",");
	    
	    var somaTransferencia = parseFloat(this.projetoRecebedor.valorRecebido.replace(",", ".")) + parseFloat(this.totalRecebido);
	    somaTransferencia = somaTransferencia.toFixed(2);
	    var saldoDisponivel = parseFloat(this.projeto.saldoDisponivel);
	    saldoDisponivel = saldoDisponivel.toFixed(2)
	    
	    if (parseFloat(somaTransferencia) > parseFloat(this.projeto.saldoDisponivel)) {
		this.mensagemAlerta("Voc\xEA ultrapassou o saldo dispon\xEDvel para transfer\xEAncia, que \xE9 de R$ " + saldoDisponivel + "!");
		this.$refs.projetoRecebedorValorRecebido.$refs.input.focus();
                return;
	    }
	    this.projetosRecebedores.push(
		this.projetoRecebedor
	    );

	    this.projetoRecebedor = {
		idPronac: null,
		valorRecebido: 0.00 		
	    };
	    // persistir dado ajax
	},
	excluirRecebedor: function(id) {
	    Vue.delete(this.projetosRecebedores, id);
	    // remover dado ajax
	},
	salvarReadequacao: function() {
	    if (this.readequacao.tipoTransferencia == '' ||
		this.readequacao.tipoTransferencia == undefined
	    ) {
		this.mensagemAlerta("\xC9 obrigat\xF3rio informar o tipo da transfer\xEAncia!");
		this.$refs.readequacaoTipoTransferencia.focus();
                return;		
	    }
	    
	    if (this.readequacao.justificativa.length == 0) {
		this.mensagemAlerta("\xC9 obrigat\xF3rio preencher a justificativa da readequa\xE7\xE3o!");
		this.$refs.readequacaoJustificativa.focus();		     
		return;
	    }

	    let vue = this;
	    
            $3.ajax({
                type: "POST",
                url: "/readequacao/transferencia-recursos/salvar-readequacao",
		data: {
		    idPronac: this.idPronac,
		    idReadequacao: this.readequacao.idReadequacao,
		    justificativa: this.readequacao.justificativa,
		    tipoTransferencia: this.readequacao.tipoTransferencia
		}
            }).done(function (response) {
                vue.readequacao = response.readequacao;
            });
	},
	finalizarReadequacao: function() {
	},
	obterDadosProjeto: function() {
	    let vue = this;
            $3.ajax({
                type: "GET",
                url: "/readequacao/transferencia-recursos/dados-projeto-transferidor",
		data: {
		    idPronac: this.idPronac
		}
            }).done(function (response) {
                vue.projeto = response.projeto;
            });
	},
	obterDadosReadequacao: function(idPronac) {
	    let vue = this;
            $3.ajax({
                type: "GET",
                url: "/readequacao/transferencia-recursos/dados-readequacao",
		data: {
		    idPronac: this.idPronac
		}
            }).done(function (response) {
                vue.readequacao = response.readequacao;
            });
	}
    },
    mixins: [utils],
    computed: {
	totalRecebido: function() {
	    return this.projetosRecebedores.reduce(function (total, projeto) {
                var resultado = parseFloat(total) + parseFloat(projeto.valorRecebido);
		return resultado.toFixed(2);
            }, 0);
	},
	saldoDisponivel: function() {
	    var saldo = parseFloat(this.projeto.valorComprovar) - parseFloat(this.totalRecebido);
	    return saldo.toFixed(2);
	},
	disponivelAdicionarRecebedores: function() {
	    if (this.readequacao.idReadequacao != null) {
		return true;
	    } else {
		return true;
	    }
	},
	disponivelFinalizar: function() {
	    if (this.projetosRecebedores.length > 0 &&
		this.totalRecebido <= this.projeto.saldoDisponivel
	    ) {
		return true;
	    } else {
		return false;
	    }
	},
	disponivelAdicionarRecebedor: function() {
	    if (this.totalRecebido == this.projeto.saldoDisponivel) {
		return false;
	    } else {
		return true;
	    }
	},
	exibeProjetosRecebedores: function() {
	    if (this.projetosRecebedores.length > 0) {
		return true;
	    } else {
		return false;
	    }
	}
    }
})
