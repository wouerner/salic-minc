<template>
    <div class="conteudo">
        <legend>Endereço</legend>
        <table class="tabela">
            <tr class="destacar">
                <td class="centro"><b>Logradouro</b></td>
                <td class="centro"><b>Cidade</b></td>
                <td class="centro"><b>UF</b></td>
                <td class="centro"><b>CEP</b></td>
            </tr>
            <tr v-for="endereco in dadosProponente.enderecos" v-bind:key="endereco.idEndereco">
                <td align="center">{{endereco.Logradouro}}</td>
                <td align="center">{{endereco.municipio}}</td>
                <td align="center">{{endereco.uf}}</td>
                <td align="center"><SalicFormatarCep :cep="endereco.Cep" /></td>
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