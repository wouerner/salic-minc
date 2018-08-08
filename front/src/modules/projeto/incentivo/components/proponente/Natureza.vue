<template>
    <div class="conteudo">
        <legend>Natureza</legend>
        <table class="tabela" v-if="Object.keys(natureza).length>0">
            <tr class="destacar">
                <td tabindex="19" class="centro"><b>Natureza</b></td>
                <td tabindex="20" class="centro"><b>Esfera</b></td>
                <td tabindex="21" class="centro"><b>Administra&ccedil;&atilde;o</b></td>
                <td tabindex="22" class="centro"><b>Fins Lucrativos</b></td>
            </tr>
            <tr v-for="(item, index) in natureza" v-bind:key="index">
                <td tabindex="23" v-if="item.direito">{{item.direito}}</td>
                <td tabindex="23" v-else>Dados não informados!</td>

                <td tabindex="24" v-if="item.esfera">{{item.esfera}}</td>
                <td tabindex="24" v-else>Dados não informados!</td>

                <td tabindex="25" v-if="item.administracao">{{item.administracao}}</td>
                <td tabindex="25" v-else>Dados não informados!</td>

                <td tabindex="26" v-if="item.utilidade">{{item.utilidade}}</td>
                <td tabindex="26" v-else>Dados não informados!</td>
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
    export default{
        data(){
            return{
                natureza:[
                    {direito:'Direito Privado', esfera:'Estadual',
                     administracao:'Indireta', utilidade:'Sem Fins Lucrativos'},
                ]
            }
        }
    }
</script>