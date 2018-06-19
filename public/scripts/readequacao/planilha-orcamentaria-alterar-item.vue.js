Vue.component('planilha-orcamentaria-alterar-item', {
    template: `
<div>
	<table class="bordered">
		<thead>
			<tr>
				<th class="center-align">Produto</th>
				<th class="center-align">Etapa</th>
				<th class="center-align">Item</th>
				<th class="center-align">Vl. Comprovado</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{dadosPlanilhaAtiva.descProduto}}</td>
				<td>{{dadosPlanilhaAtiva.descEtapa}}</td>
				<td>{{dadosPlanilhaAtiva.descItem}}</td>
				<td>{{valoresDoItem.vlComprovadoDoItem}}</td>
			</tr>
		</tbody>
	</table>

	<br/>
	<h6>Valores solicitados</h6>
	<table class="bordered">
		<thead>
			<tr>
				<th class="center-align"Unidade></th>
				<th class="center-align">Qtd</th>
				<th class="center-align">Ocorr&ecirc;ncia</th>
				<th class="center-align">Vl. Unit&aacute;rio</th>
				<th class="center-align">Dias</th>
				<th class="center-align">Total</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td id="vlSolUnidade">{{dadosPlanilhaAtiva.descUnidade}}</td>
				<td id="vlSolQtd">{{dadosPlanilhaAtiva.Quantidade}}</td>
				<td id="vlSolOcor">{{dadosPlanilhaAtiva.Ocorrencia}}</td>
				<td id="vlSolVlUnit">{{dadosPlanilhaAtiva.ValorUnitario}}</td>
				<td id="vlSolDias">{{dadosPlanilhaAtiva.QtdeDias}}</td>
				<td id="vlSolTotal">{{dadosPlanilhaAtiva.TotalSolicitado}}</td>
			</tr>
		</tbody>
	</table>

	<br/>
	<h6>Dados para a readequa&ccedil;&atilde;o</h6>
	<form class="col s12">
		<div class="row">
			<div class="input-field col s3">
				<input placeholder="Unidade" id="unidade" type="text" class="validate" v-model="dadosPlanilhaEditavel.idUnidade">
				<label for="unidade">Unidade</label>
			</div>	

			<div class="input-field col s2">
				<input placeholder="Qtd" id="qtd" type="text" class="validate" v-model="dadosPlanilhaEditavel.Quantidade">
				<label for="qtd">Qtd</label>
			</div>
			
			<div class="input-field col s2">
				<input placeholder="Ocorr\xEAncia" id="ocorrencia" type="text" class="validate" v-model="dadosPlanilhaEditavel.Ocorrencia">
				<label for="ocorrencia">Ocorr&ecirc;ncia</label>
			</div>
			
			<div class="input-field col s2">
        <input-money
          v-bind:value="dadosPlanilhaEditavel.ValorUnitario"
					v-on:ev="dadosPlanilhaEditavel.ValorUnitario = $event">
        </input-money>
				<label for="vl_unitario">Vl. Unit&atilde;rio</label>
			</div>
			
			<div class="input-field col s1">
				<input placeholder="Dias" id="dias" type="text" class="validate" v-model="dadosPlanilhaEditavel.QtdeDias">
				<label for="dias">Dias</label>
			</div>
			
			<div class="input-field col s2">
				<span>Total</span><br/>
				<span>R$ {{totalItemFormatado}}</span>
			</div>
			
		</div>
		<div class="row">
			<div class="input-field col s12">
				<textarea id="dsJustificativa" class="materialize-textarea"></textarea>
				<label for="dsJustificativa">Justificativa</label>
			</div>
		</div>
		
		<div class="row">
			<div class="right-align padding20 col s12">
				<button
					class="btn">Finalizar</button>
			</div>
		</div>				
	</form>
</div>
	`,
    props: {
	idPronac: '',
	idPlanilhaAprovacao: ''
    },
    data: function() {
	return {
	    dadosPlanilhaAtiva: {
		Justificativa: '',
		Ocorrencia: '',
		QtdeDias: '',
		Quantidade: '',
		TotalSolicitado: '',
		ValorUnitario: '',
		descEtapa: '',
		descItem: '',
		descProduto: '',
		descUnidade: '',
		idEtapa: '',
		idPlanilhaAprovacao: '',
		idPlanilhaItem: '',
		idProduto: '',
		idUnidade: '',
	    },
	    dadosPlanilhaEditavel: {
		Justificativa: '',
		Ocorrencia: 0,
		QtdeDias: '',
		Quantidade: 0,
		TotalSolicitado: 0,
		ValorUnitario: '',
		descEtapa: '',
		descItem: '',
		descProduto: '',
		descUnidade: '',
		idAgente: '',
		idEtapa: '',
		idPlanilhaAprovacao: '',
		idPlanilhaItem: '',
		idProduto: '',
		idUnidade: '',
	    },
	    dadosProjeto: {
		IdPRONAC: '',
		NomePRojeto: '',
		PRONAC: ''
	    },
	    valoresDoItem: {
		vlComprovadoDoItem: '',
		vlComprovadoDoItemValidacao: ''
	    }
	}
    },
    mixins: [utils],
    methods: {
	obterDadosItem: function() {
	    let self = this;
	    $3.ajax({
		type: 'POST',
		url: '/readequacao/readequacoes/alterar-item-solicitacao',
		data: {
		    idPronac: self.idPronac,
		    idPlanilha: self.idPlanilhaAprovacao
		}
	    }).done(function(response) {
		self.dadosPlanilhaAtiva = response.dadosPlanilhaAtiva;
		self.dadosPlanilhaEditavel = response.dadosPlanilhaEditavel;
		self.dadosProjeto = response.dadosProjeto;
		self.valoresDoItem = response.valoresDoItem;
	    });
	}
    },
    watch: {
	idPlanilhaAprovacao: function() {
	    if (this.idPlanilhaAprovacao != '') {
		this.obterDadosItem();
	    }
	}
    },
    computed: {
	totalItem: function() {
	    if (this.dadosPlanilhaEditavel.Ocorrencia > 0
		&& this.dadosPlanilhaEditavel.Quantidade > 0
		&& this.dadosPlanilhaEditavel.ValorUnitario != ''
	    ) {
		return this.dadosPlanilhaEditavel.Ocorrencia * this.dadosPlanilhaEditavel.Quantidade * numeral(this.dadosPlanilhaEditavel.ValorUnitario).value();
	    } else {
		return 0;
	    }
	},
	totalItemFormatado: function() {
	    return this.converterParaMoedaPontuado(this.totalItem);
	}
    }
});
