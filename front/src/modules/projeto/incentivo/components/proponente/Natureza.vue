<template>
    <div class="conteudo">
        <legend>Natureza</legend>
        <table class="tabela">
            <tr class="destacar">
                <td tabindex="19" class="centro"><b>Natureza</b></td>
                <td tabindex="20" class="centro"><b>Esfera</b></td>
                <td tabindex="21" class="centro"><b>Administra&ccedil;&atilde;o</b></td>
                <td tabindex="22" class="centro"><b>Fins Lucrativos</b></td>
            </tr>
            <tr v-if="tbDados">
                <td tabindex="23" align="center" v-if="Direito=='Publico'">Público</td>
                <td tabindex="23" align="center" v-else-if="Direito=='Privado'">Privado</td>
                <td tabindex="23" align="center" v-else>Dados não informados!</td>

                <td tabindex="24" align="center" v-if="Esfera==3">Municipal</td>
                <td tabindex="24" align="center" v-else-if="Esfera==4">Estadual</td>
                <td tabindex="24" align="center" v-else-if="Esfera==5">Federal</td>
                <td tabindex="24" align="center" v-else>Dados não informados!</td>

                <td tabindex="25" align="center" v-if="Administracao==11">Direta</td>
                <td tabindex="25" align="center" v-else-if="Administracao==12">Indireta</td>
                <td tabindex="25" align="center" v-else>Dados não informados!</td>

                <td tabindex="26" align="center" v-if="Utilidade==1">Fins Lucrativos</td>
                <td tabindex="26" align="center" v-else-if="Utilidade==2">Sem Fins Lucrativos</td>
                <td tabindex="26" align="center" v-else>Dados não informados!</td>
            </tr>

            <tr v-else>
                <td tabindex="27" align="center"><em>Dados n&atilde;o informados!</em></td>
                <td tabindex="28" align="center"><em>Dados n&atilde;o informados!</em></td>
                <td tabindex="29" align="center"><em>Dados n&atilde;o informados!</em></td>
                <td tabindex="30" align="center"><em>Dados n&atilde;o informados!</em></td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default{
        data(){
            return{
                tbDados: false,
                Direito:'Privado',
                Esfera:'4',
                Administracao: '11',
                Utilidade:'',
            }
        }
    }
</script>