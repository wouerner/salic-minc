<template>
    <div class="conteudo">
        <legend>Telefone</legend>
        <table class="tabela">
            <tr class="destacar" v-if="telefoneCadastrado">
                <td tabindex="42" class="centro"><b>Tipo</b></td>
                <td tabindex="43" class="centro"><b>UF</b></td>
                <td tabindex="44" class="centro"><b>DDD</b></td>
                <td tabindex="45" class="centro"><b>N&uacute;mero</b></td>
                <td tabindex="46" class="centro"><b>Divulgar</b></td>
            </tr>
            <tr v-if="telefoneCadastrado">
                <td tabindex="47" align="center">{{tipo}}</td>
                <td tabindex="48" align="center">{{uf}}</td>
                <td tabindex="49" align="center">{{ddd}}</td>
                <td tabindex="50" align="center">{{numero}}</td>
                <td tabindex="51" align="center">{{divulgar}}</td>
            </tr>
            <tr v-if="!telefoneCadastrado">
                <td colspan="5" align="center"><em>N&atilde;o existem telefones cadastrados!</em></td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default{
        data(){
            return{
                telefoneCadastrado: true,
                tipo:'Residencial',
                uf:'Rio de Janeiro',
                ddd:37,
                numero:'3873-1148',
                divulgar:'Sim',
            }
        }
    }
</script>