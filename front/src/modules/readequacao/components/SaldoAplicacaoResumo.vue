<template>
    <v-container>
        <v-layout>
            <v-flex xs3>
                <h3 class="subheading">
                    Saldo declarado
                </h3>
                <span class="font-weight-bold">
                    R$ {{ SaldoDeclarado }}
                </span>
            </v-flex>
            <v-flex xs3>
                <h3 class="subheading">
                    Disponível
                </h3>
                <span class="font-weight-bold">
                    R$ {{ SaldoDisponivel }}
                </span>
            </v-flex>
            <v-flex xs3>
                <h3 class="subheading">
                    Utilizado
                </h3>
                <span class="font-weight-bold">
                    R$ {{ SaldoUtilizado }}
                </span>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
export default {
    name: 'SaldoAplicacaoResumo',
    props: {
        SaldoDeclarado: {
            type: [Number, String],
            default: 0,
        },
        SaldoDisponivel: {
            type: [Number, String],
            default: 0,
        },
        SaldoUtilizado: {
            type: [Number, String],
            default: 0,
        },
    },
    data() {
        return {
            
        };
    },
};
</script>
