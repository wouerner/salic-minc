<template>
    <div class="conteudo">
        <legend>Endereço</legend>
        <table class="tabela">
            <tr class="destacar">
                <td tabindex="12" class="centro"><b>Logradouro</b></td>
                <td tabindex="12" class="centro"><b>Cidade</b></td>
                <td tabindex="13" class="centro"><b>UF</b></td>
                <td tabindex="14" class="centro"><b>CEP</b></td>
            </tr>
            <tr v-for="(endereco, index) in enderecos" v-bind:key="index">
                <td tabindex="10" align="center">{{endereco.Endereco}}</td>
                <td tabindex="15" align="center">{{endereco.Municipio}}</td>
                <td tabindex="16" align="center">{{endereco.UF}}</td>
                <td tabindex="17" align="center"><SalicFormatarCep :cep="endereco.Cep" /></td>
            </tr>
        </table>
    </div>
</template>

<script>
    import SalicFormatarCep from '@/components/SalicFormatarCep';

    export default{
        data(){
            return{
                enderecos:[
                    {Endereco:'Copacabana', Municipio:'Rio de Janeiro', UF:'RJ', Cep:'22010010'},
                ],
            }
        },
        components:{
            SalicFormatarCep,
        },
    };
</script>