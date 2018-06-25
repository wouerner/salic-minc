Vue.component('readequacao-saldo-aplicacao-saldo', {
    template: `
<div class="col s3">
	<template v-if="!disabled">
		<label>Saldo dispon&iacute;vel *</label>
    <input-money
			ref="readequacaoSaldo"
			v-model="valorSaldo"
			@change="alterarSaldo">
		</input-money>
	</template>
	<template v-else>
		<span>Saldo dispon&iacute;vel</span>
		{{readequacao.saldo }}
	</template>
</div>
    `,
    props: [
	'dsSolicitacao',
	'disabled'
    ],
    data: function() {
	return {
	    valorSaldo: ''
	}
    },
    methods: {
	alterarSaldo: function() {
	    this.$emit('eventoAtualizarDsSolicitacao', this.valorSaldo);
	}
    },
    watch: {
	dsSolicitacao: function(valor) {
	    this.valorSaldo = valor;
	}
    }
});
