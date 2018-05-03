new Vue({
    el: '#vue-container',
    data: {
	projeto: {
	},
	readequacao: {
	    justificativa: '',
	    idReadequacao: null
	},
	projetoRecebedor: {
	    idPronac: null,
	    nomeProjeto: '',
	    tipoTransferencia: '',
	    valorRecebido: 0.00
	},
	projetosRecebedores: []
    },
    created: function() {
	this.obterDadosProjeto();
	this.obterDadosReadequacao();
    },
    mounted: function() {
    },
    methods: {
	incluirRecebedor: function() {
	    if (
		this.projetosRecebedores.idPronac != '' &&
		    this.projetosRecebedores.nomeProjeto != '' &&
		    this.projetosRecebedores.tipoTransferencia != ''
	    ) {
		this.projetosRecebedores.push(
		    this.projetoRecebedor
		);
		this.projetoRecebedor = {
		    idPronac: null,
		    nomeProjeto: '',
		    tipoTransferencia: '',
		    valorRecebido: 0.00
		};
		// persistir dado ajax
	    } else {
		this.mensagemAlerta("\xC9 obrigat\xF3rio informar todos os dados");
                this.$refs.dsProduto.focus();
                return;
	    }
	},
	excluirRecebedor: function(id) {
	    Vue.delete(this.projetosRecebedores, id);
	    // remover dado ajax
	},
	salvarReadequacao: function() {
	    this.readequacao.idReadequacao = 1234;
	    // adicionar via ajax
	},
	finalizarReadequacao: function() {
	},
	obterDadosProjeto: function() {
	    // obtem dados via ajax
	    this.projeto = {
		pronac: 164783,
		idPronac: 289999,
		nomeProjeto: 'Expedição gastronimica',
		valorComprovar: 1234,
		saldoDisponivel: 1234
	    };
	},
	obterDadosReadequacao: function() {
	    this.readequacao = {};
	}
    },
    mixins: [utils],
    computed: {
	totalRecebido: function() {
	    return this.projetosRecebedores.reduce(function (total, projeto) {
                return total + parseFloat(projeto.valorRecebido);
            }, 0);
	},
	saldoDisponivel: function() {
	    return this.projeto.valorComprovar - this.totalRecebido;
	},
	disponivelAdicionarRecebedores: function() {
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
	}
    }
})
