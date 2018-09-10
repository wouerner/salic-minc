<template>
    <div class="conteudo" v-if="dadosProponente">
        <legend>Natureza</legend>
        <table class="tabela" v-if=" dadosProponente.Direito || dadosProponente.Esfera ||
                                dadosProponente.Administracao || dadosProponente.Utilidade ">
            <tr class="destacar">
                <td><b>Natureza</b></td>
                <td><b>Esfera</b></td>
                <td><b>Administra&ccedil;&atilde;o</b></td>
                <td><b>Fins Lucrativos</b></td>
            </tr>
            <tr>
                <td v-if="dadosProponente.Direito">{{dadosProponente.Direito}}</td>
                <td v-else-if="dadosProponente.Natureza">{{dadosProponente.Natureza}}</td>
                <td v-else>Dado não informado!</td>

                <td v-if="dadosProponente.Esfera">{{dadosProponente.Esfera}}</td>
                <td v-else>Dado não informado!</td>

                <td v-if="dadosProponente.Administracao">{{dadosProponente.Administracao}}</td>
                <td v-else>Dado não informado!</td>

                <td v-if="dadosProponente.Utilidade">{{dadosProponente.Utilidade}}</td>
                <td v-else>Dado não informado!</td>
            </tr>
        </table>
        <table class="tabela" v-else>
            <tr>
                <td colspan="2"><em>Dados não informados!</em></td>
            </tr>
        </table>
    </div>
</template>

<script>
    // import { mapGetters } from 'vuex';

    export default {
        props: {
            dadosProponente: {},
        },
    };
</script>
