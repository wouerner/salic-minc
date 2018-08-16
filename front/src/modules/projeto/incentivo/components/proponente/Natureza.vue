<template>
    <div class="conteudo" v-if="dadosProponente.dados">
        <legend>Natureza</legend>
        <table class="tabela" v-if=" dadosProponente.dados.Direito || dadosProponente.dados.Esfera || 
                                dadosProponente.dados.Administracao || dadosProponente.dados.Utilidade ">
            <tr class="destacar">
                <td class="centro"><b>Natureza</b></td>
                <td class="centro"><b>Esfera</b></td>
                <td class="centro"><b>Administra&ccedil;&atilde;o</b></td>
                <td class="centro"><b>Fins Lucrativos</b></td>
            </tr>
            <tr>
                <td v-if="dadosProponente.dados.Direito">{{dadosProponente.dados.Direito}}</td>
                <td v-else>Dado não informado!</td>

                <td v-if="dadosProponente.dados.Esfera">{{dadosProponente.dados.Esfera}}</td>
                <td v-else>Dado não informado!</td>

                <td v-if="dadosProponente.dados.Administracao">{{dadosProponente.dados.Administracao}}</td>
                <td v-else>Dado não informado!</td>

                <td v-if="dadosProponente.dados.Utilidade">{{dadosProponente.dados.Utilidade}}</td>
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
    import { mapGetters } from 'vuex';

    export default{
        computed: {
            ...mapGetters({
                dadosProponente: 'projeto/proponente',
            }),
        }
    }
</script>