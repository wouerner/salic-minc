<template>
    <v-container>
        <v-layout>
            <v-flex
                class="green lighten-3"
                xs3
            >
                <h3 class="subheading">
                    Saldo declarado
                </h3>
                <span class="font-weight-bold">
                    R$ {{ SaldoDeclarado | filtroFormatarParaReal }}
                </span>
            </v-flex>
            <v-flex
                :class="colorDisponivel"
                xs3
            >
                <h3 class="subheading">
                    Disponível
                </h3>
                <span class="font-weight-bold">
                    R$ {{ SaldoDisponivel | filtroFormatarParaReal }}
                </span>
            </v-flex>
            <v-flex
                :class="colorUtilizado"
                xs3
            >
                <h3 class="subheading">
                    Utilizado
                </h3>
                <span class="font-weight-bold">
                    R$ {{ SaldoUtilizado | filtroFormatarParaReal }}
                </span>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
import { utils } from '@/mixins/utils';

export default {
    name: 'SaldoAplicacaoResumo',
    mixins: [
        utils,
    ],
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
    computed: {
        colorDisponivel() {
            if (this.SaldoDisponivel > 0) {
                return 'green lighten-3'
            }
            return 'red lighten-3';
        },
        colorUtilizado() {
            if (this.SaldoUtilizado < this.SaldoDeclarado) {
                return 'green lighten-3'
            }
            return 'red lighten-3';
        },
    },
};
</script>
