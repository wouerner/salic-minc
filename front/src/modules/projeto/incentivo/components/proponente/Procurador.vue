<template>
    <div class="conteudo">
        <legend>Procurador</legend>
        <table class="tabela" v-if="Object.keys(procuradores)>'0'">
            <tr class="destacar">
                <td width="20%" align="center"><b>CPF</b></td>
                <td align="center"><b>Nome</b></td>
            </tr>
            <tr v-for="procurador in procuradores" v-bind:key="procurador.id">
                <td align="center">{{procurador.CNPJCPF}}</td>
                <td align="left">{{procurador.nome}}</td>
            </tr>
        </table>
        <table class="tabela" v-else>
            <tr>
                <td colspan="2" align="center"><em>N&atilde;o existe Procurador cadastrado</em></td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default{
        data(){
            return{
                procuradores:[
                    {id:'21', CNPJCPF:'235.245.301-55', nome:'Alguém'},
                ]

            }
        }
    }
</script>