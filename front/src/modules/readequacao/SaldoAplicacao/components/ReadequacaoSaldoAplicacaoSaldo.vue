<template>
    <div class="col s3">
        <div v-if="!disabled">
            <label>Saldo dispon&iacute;vel *</label>
            <input-money
	      ref="readequacaoSaldo"
	      v-model="saldoDisponivel"
	      v-on:blur.native="alterarSaldo"
	      >
            </input-money>
        </div>
        <div v-else>
            <span>Saldo dispon&iacute;vel</span> {{readequacao.saldo }}
        </div>
    </div>
</template>

<script>
import InputMoney from '@/components/InputMoney';
import { mapActions } from 'vuex';

export default {
    name: 'ReadequacaoSaldoAplicacaoSaldo',
    components: {
        InputMoney,
    },
    props: [
        'dsSolicitacao',
        'disabled',
    ],
    data() {
        return {
            saldoDisponivel: 0,
        };
    },
    methods: {
        alterarSaldo(event) {
            this.updateReadequacaoDsSolicitacao(event.target.value);
        },
        ...mapActions({
            updateReadequacaoDsSolicitacao: 'readequacao/updateReadequacaoSaldoAplicacaoDsSolicitacao',
        }),
    },
    watch: {
        dsSolicitacao(valor) {
            this.saldoDisponivel = valor;
        },
    },
};
</script>
