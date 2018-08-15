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
            <tr v-for="endereco in dadosProponente.enderecos" v-bind:key="endereco.idEndereco">
                <td tabindex="10" align="center">{{endereco.Logradouro}}</td>
                <td tabindex="15" align="center">{{endereco.municipio}}</td>
                <td tabindex="16" align="center">{{endereco.uf}}</td>
                <td tabindex="17" align="center"><SalicFormatarCep :cep="endereco.Cep" /></td>
            </tr>
        </table>
    </div>
</template>

<script>
    import SalicFormatarCep from '@/components/SalicFormatarCep';
    import { mapGetters } from 'vuex';

    export default{
        components:{
            SalicFormatarCep,
        },
        computed: {
            ...mapGetters({
                dadosProponente: 'projeto/proponente',
            }),
        }
    };
</script>