<template>
    <div class="conteudo">
        <legend>Endereço</legend>
        <table class="tabela">
            <tr class="destacar">
                <td><b>Logradouro</b></td>
                <td><b>Cidade</b></td>
                <td class="center-align"><b>UF</b></td>
                <td class="center-align"><b>CEP</b></td>
            </tr>
            <tr v-for="endereco in dadosProponente.enderecos" v-bind:key="endereco.idEndereco">
                <td>{{endereco.Logradouro}}</td>
                <td>{{endereco.municipio}}</td>
                <td class="center-align">{{endereco.uf}}</td>
                <td class="center-align">
                    <SalicFormatarCep :cep="endereco.Cep"/>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import SalicFormatarCep from '@/components/SalicFormatarCep';

    export default {
        components: {
            SalicFormatarCep,
        },
        computed: {
            ...mapGetters({
                dadosProponente: 'projeto/proponente',
            }),
        },
    };
</script>
