<template>
    <div class="conteudo">
        <legend>Telefone</legend>
        <table class="tabela" v-if="Object(dadosProponente.telefones).length > 0">
            <tr class="destacar">
                <td class="centro"><b>Tipo</b></td>
                <td class="centro"><b>UF</b></td>
                <td class="centro"><b>N&uacute;mero</b></td>
                <td class="centro"><b>Divulgar</b></td>
            </tr>
            <tr v-for="telefone in dadosProponente.telefones" v-bind:key="telefone.idTelefone">
                <td>{{telefone.dstelefone}}</td>
                <td>{{telefone.ufsigla}}</td>
                <td>({{telefone.ddd}}) {{telefone.numero}}</td>
                <td>{{label_sim_ou_nao(telefone.divulgar)}}</td>
            </tr>
        </table>
        <table class='tabela' v-else>
            <tr>
                <td colspan="5"><em>N&atilde;o existe telefone cadastrado!</em></td>
            </tr>
        </table>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import { utils } from '@/mixins/utils.js';

    export default{
        computed: {
            ...mapGetters({
                dadosProponente: 'projeto/proponente',
            }),
        },
        mixins:[utils]
    }
</script>