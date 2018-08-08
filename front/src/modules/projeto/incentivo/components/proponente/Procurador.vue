<template>
    <div class="conteudo">
        <legend>Procurador</legend>
        <table class="tabela" v-if="Object.keys(procuradores).length>0">
            <tr class="destacar">
                <td width="20%" align="center"><b>CPF</b></td>
                <td align="center"><b>Nome</b></td>
            </tr>
            <tr v-for="(procurador, index) in procuradores" v-bind:key="index">
                <td align="center"><SalicFormatarCpfCnpj :cpf="procurador.CNPJCPF" /></td>
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
    import SalicFormatarCpfCnpj from '@/components/SalicFormatarCpfCnpj';

    export default{
        data(){
            return{
                procuradores:[
                    {CNPJCPF:'23524530155', nome:'Alguém'},
                ]
            }
        },
        components:{
            SalicFormatarCpfCnpj,
        },
    }
</script>