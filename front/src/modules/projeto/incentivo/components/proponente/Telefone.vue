<template>
    <div class="conteudo">
        <legend>Telefone</legend>
        <table class="tabela" v-if="Object.keys(telefones).length>0">
            <tr class="destacar">
                <td tabindex="42" class="centro"><b>Tipo</b></td>
                <td tabindex="43" class="centro"><b>UF</b></td>
                <td tabindex="44" class="centro"><b>DDD</b></td>
                <td tabindex="45" class="centro"><b>N&uacute;mero</b></td>
                <td tabindex="46" class="centro"><b>Divulgar</b></td>
            </tr>
            <tr v-for="(telefone, index) in telefones" v-bind:key="index">
                <td tabindex="47">{{telefone.TipoTelefone}}</td>
                <td tabindex="48">{{telefone.UF}}</td>
                <td tabindex="49">{{telefone.DDDTelefone}}</td>
                <td tabindex="50">{{telefone.NumeroTelefone}}</td>
                <td tabindex="51">{{telefone.Divulgar}}</td>
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
    export default{
        data(){
            return{
                telefones:[
                    {TipoTelefone:'Residencial', UF:'Rio de Janeiro', DDDTelefone:'37',
                     NumeroTelefone:'3873-1148', Divulgar:'Não'},
                ],
            }
        }
    }
</script>