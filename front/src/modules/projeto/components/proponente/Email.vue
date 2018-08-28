<template>
    <div class="conteudo">
        <legend>E-mail</legend>
        <table class="tabela" v-if="Object(dadosProponente.emails).length > 0">
            <tr class="destacar">
                <td width="25%"><b>Tipo</b></td>
                <td><b>E-mail</b></td>
            </tr>
            <tr v-for="email in dadosProponente.emails" v-bind:key="email.idInternet">
                <td>{{email.tipo}}</td>
                <td>{{email.descricao}}</td>
            </tr>
        </table>
        <table class="tabela" v-else>
            <td colspan="2" align="center"><em>N&atilde;o existe email cadastrado!</em></td>
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
        },
    };
</script>

