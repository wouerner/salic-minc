new Vue({
    el: '#vue-container',
    data: {
	projeto: {
	    idPronac: null,
	    nomeProjeto: '',
	    tipoTransferencia: '',
	    valorRecebido: 0.00
	},
	readequacao:  {
	    justificativa: '',
	    idReadequacao: null
	},
	projetoRecebedor: {},
	projetosRecebedores: []
    },
    created: function() {
	this.obterDadosProjeto();
	//this.obterDadosReadequacao();
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
	    if (this.projetoRecebedor.tipoTransferencia == '' ||
		this.projetoRecebedor.tipoTransferencia == undefined
	    ) {
		this.mensagemAlerta("\xC9 obrigat\xF3rio informar o tipo da transfer\xEAncia!");
		this.$refs.projetoRecebedorTipoTransferencia.focus();
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
	    this.projetoRecebedor = {};
	    // persistir dado ajax
	},
	excluirRecebedor: function(id) {
	    Vue.delete(this.projetosRecebedores, id);
	    // remover dado ajax
	},
	salvarReadequacao: function() {
	    if (this.readequacao.justificativa.length > 1) {
		this.obterDadosReadequacao();
		// adicionar via ajax
		
	    } else {
		this.mensagemAlerta("\xC9 obrigat\xF3rio preencher a justificativa da readequa\xE7\xE3o!");
		this.$refs.readequacaoJustificativa.focus();		     
		return;
	    }
	},
	finalizarReadequacao: function() {
	},
	obterDadosProjeto: function() {
	    // obtem dados via ajax
	    this.projeto = {
		pronac: 164783,
		idPronac: 289999,
		nomeProjeto: 'Expedição gastronimica',
		valorComprovar: 1234.00,
		saldoDisponivel: 1234.00
	    };
	},
	obterDadosReadequacao: function(idPronac) {    
	    this.readequacao = {
		idReadequacao: 2345,
		idTipoReadequacao: 23
	    };
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
	    console.log(this.readequacao);
	    if (this.readequacao.idReadequacao != null) {
		return true;
	    } else {
		return false;
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
