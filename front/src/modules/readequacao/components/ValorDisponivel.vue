<template>
    <v-layout>
        <v-flex
            xs-10
            offset-xs1
            class="ma-3"
        >
            <span class="headline">R$</span>
            <input-money
                :value="valorLocal"
                class="title"
	            ref="readequacaoSaldo"
                @ev="atualizarForm($event)"
	        />
            </input-money>
            <span
                class="font-italic grey--text text--darken-2"
            >
                Valor total do saldo de aplicações disponível a ser utilizado
            </span>
        </v-flex>
    </v-layout>
</template>
<script>
import InputMoney from '@/components/InputMoney';

export default {
    name: 'ValorDisponivel',
    components: {
        InputMoney,
    },
    props: {
        valor: {
            type: [Number, String],
            default: 0,
        },
    },
    data() {
        return {
            valorLocal: 0,
        };
    },
    watch: {
        valor() {
            this.valorLocal = this.valor;
        },
    },
    created() {
        this.valorLocal = this.valor;
    },
    methods: {
        atualizarForm(value) {
            this.$emit('dados-update', value);
        },        
    },
};
</script>
