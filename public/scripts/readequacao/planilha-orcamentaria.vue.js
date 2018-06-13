Vue.component('planilha-orcamentaria', {
    template: `
	<div id="planilhaOrcamentariaMontada"></div>
    `,
    props: {
	idPronac: '',
	tipoPlanilha: '',
	link: false
    },
    created: function() {
	this.montarPlanilhaOrcamentaria();
    },
    methods: {
	montarPlanilhaOrcamentaria: function() {
	    let self = this;
	    $3.ajax({
		type: 'GET',
		url: '/index/montar-planilha-orcamentaria',
		data: {
		    idPronac: self.idPronac,
		    tipoPlanilha: self.tipoPlanilha,
		    link: self.link
		}
	    }).done(function(response) {
		$3('#planilhaOrcamentariaMontada').html(response);
	    });
	}
    }
});
