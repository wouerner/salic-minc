<template>
    <div class="conteudo">
        <legend>Natureza</legend>
        <table class="tabela" v-if="dadosProponente.dados.Direito == null && dadosProponente.dados.Esfera == null && 
                                    dadosProponente.dados.Administracao == null && dadosProponente.dados.Utilidade == null">
            <tr>
                <td colspan="2"><em>Dados não informados!</em></td>
            </tr>
        </table>
        <table class="tabela" v-else>
            <tr class="destacar">
                <td tabindex="19" class="centro"><b>Natureza</b></td>
                <td tabindex="20" class="centro"><b>Esfera</b></td>
                <td tabindex="21" class="centro"><b>Administra&ccedil;&atilde;o</b></td>
                <td tabindex="22" class="centro"><b>Fins Lucrativos</b></td>
            </tr>
            <tr>
                <td tabindex="23" v-if="dadosProponente.dados.Direito">{{dadosProponente.dados.Direito}}</td>
                <td tabindex="23" v-else>Dados não informados!</td>

                <td tabindex="24" v-if="dadosProponente.dados.Esfera">{{dadosProponente.dados.Esfera}}</td>
                <td tabindex="24" v-else>Dados não informados!</td>

                <td tabindex="25" v-if="dadosProponente.dados.Administracao">{{dadosProponente.dados.Administracao}}</td>
                <td tabindex="25" v-else>Dados não informados!</td>

                <td tabindex="26" v-if="dadosProponente.dados.Utilidade">{{dadosProponente.dados.Utilidade}}</td>
                <td tabindex="26" v-else>Dados não informados!</td>
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