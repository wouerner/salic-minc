<template>
    <div class="col s3">
        <div v-if="!disabled">
            <label>Saldo dispon&iacute;vel *</label>
            <input-money ref="readequacaoSaldo" v-model="saldoDisponivel" v-on:ev="alterarSaldo">
            </input-money>
        </div>
        <div v-else>
            <span>Saldo dispon&iacute;vel</span> {{readequacao.saldo }}
        </div>
    </div>
</template>

<script>
    import {
        utils
    } from '@/mixins/utils';
    import InputMoney from '@/components/InputMoney';

    export default {
        name: 'ReadequacaoSaldoAplicacaoSaldo',
        components: {
            InputMoney,
        },
        props: [
            'dsSolicitacao',
            'disabled'
        ],
        data: function() {
            return {
                saldoDisponivel: 0
            }
        },
        methods: {
            alterarSaldo: function(valor) {
                this.$emit('eventoAtualizarDsSolicitacao', valor);
            }
        },
        watch: {
            dsSolicitacao: function(valor) {
                this.saldoDisponivel = valor;
            }
        }
    }
</script>
