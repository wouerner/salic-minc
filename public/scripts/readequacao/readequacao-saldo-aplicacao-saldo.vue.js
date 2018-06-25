Vue.component('readequacao-saldo-aplicacao-saldo', {
    template: `
<div class="col s3">
	<template v-if="!disabled">
		<label>Saldo dispon&iacute;vel *</label>
    <input-money
			ref="readequacaoSaldo"
			v-model="dsSolicitacao"
			v-on:ev="alterarSaldo">
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
    mounted: function() {
	this.$refs.readequacaoSaldo.updateMoney(this.dsSolicitacao);
    },
    methods: {
	alterarSaldo: function(valor) {
	    this.$emit('eventoAtualizarDsSolicitacao', valor);
	}
    }
});
