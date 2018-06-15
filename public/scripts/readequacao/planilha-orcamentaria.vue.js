Vue.component('planilha-orcamentaria', {
    template: `
	<div id="planilhaOrcamentariaMontada">
	    <component
		v-bind:is="componentePlanilha"
		:objPlanilha="planilhaOrcamentaria"
		:perfil="perfil"
		:link="link"
		:disponivelParaAdicaoItensReadequacaoPlanilha="disponivelParaAdicaoItensReadequacaoPlanilha"
		:disponivelParaEdicaoReadequacaoPlanilha="disponivelParaEdicaoReadequacaoPlanilha"
		>
	    </component>
	</div>
    `,
    props: {
	idPronac: '',
	tipoPlanilha: '',
	link: false,
	componentePlanilha: '',
	perfil: '',
	disponivelParaAdicaoItensReadequacaoPlanilha: '',
	disponivelParaEdicaoReadequacaoPlanilha: ''
    },
    data: function() {
	return {
	    planilhaOrcamentaria: []
	}
    },
    created: function() {
	this.montarPlanilhaOrcamentaria();
    },
    methods: {
	montarPlanilhaOrcamentaria: function() {
	    let self = this;
	    $3.ajax({
		type: 'GET',
		url: '/readequacao/readequacoes/obter-planilha-orcamentaria',
		data: {
		    idPronac: self.idPronac,
		    tipoPlanilha: self.tipoPlanilha,
		    link: self.link
		}
	    }).done(function(response) {
		self.planilhaOrcamentaria = response.planilhaOrcamentaria;
	    });
	}
    }
});
