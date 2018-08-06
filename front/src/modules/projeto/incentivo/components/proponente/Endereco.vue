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
            <tr>
                <td tabindex="10" align="center">{{logradouro}}</td>
                <td tabindex="15" align="center">{{cidade}}</td>
                <td tabindex="16" align="center">{{uf}}</td>
                <td tabindex="17" align="center">{{cep}}</td>
            </tr>
        </table>
    </div>
</template>

<script>

    export default{
        data(){
            return{
                logradouro:'Copacabana',
                cidade:'Rio de Janeiro',
                uf:'',
                cep:'22.010.010',
            }
        }
    };
</script>