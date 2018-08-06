<template>
    <div id="conteudo">
        <legend>E-mail</legend>
        <table class="tabela">
            <tr class="destacar">
                <td width="25%" align="center"><b>Tipo</b></td>
                <td><b>E-mail</b></td>
            </tr>
            <tr v-if="Object.keys(emails)>'0'" v-for="email in emails" v-bind:key="email.idInternet">
                <td align="center">{{email.TipoInternet}}</td>
                <td align="center">{{email.Descricao}}</td>
            </tr>
            <tr v-else>
                <td colspan="2" align="center"><em>N&atilde;o existem emails cadastrados!</em></td>
            </tr>
        </table>
    </div>
</template>
<script>
    export default{
        data(){
            return{
                emailCadastrado: true,
                emails:[
                    {idInternet:'47671', TipoInternet:'Email Particular', Descricao:'salicweb@gmail.com'},
                    {idInternet:'47672', TipoInternet:'Email Empresarial', Descricao:'salicweb@gmail.com'},
                ]
            }
        }
    }
</script>