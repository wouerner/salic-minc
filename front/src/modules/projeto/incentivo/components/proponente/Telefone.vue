<template>
    <div class="conteudo">
        <legend>Telefone</legend>
        <table class="tabela" v-if="Object(dadosProponente.telefones).length > 0">
            <tr class="destacar">
                <td tabindex="42" class="centro"><b>Tipo</b></td>
                <td tabindex="43" class="centro"><b>UF</b></td>
                <td tabindex="44" class="centro"><b>DDD</b></td>
                <td tabindex="45" class="centro"><b>N&uacute;mero</b></td>
                <td tabindex="46" class="centro"><b>Divulgar</b></td>
            </tr>
            <tr v-for="telefone in dadosProponente.telefones" v-bind:key="telefone.idTelefone">
                <td tabindex="47">{{telefone.dsTelefone}}</td>
                <td tabindex="48">{{telefone.uf}}</td>
                <td tabindex="49">{{telefone.ddd}}</td>
                <td tabindex="50">{{telefone.numero}}</td>
                <td tabindex="51">{{telefone.divulgar}}</td>
            </tr>
        </table>
        <table class='tabela' v-else>
            <tr>
                <td colspan="5"><em>N&atilde;o existem telefones cadastrados!</em></td>
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