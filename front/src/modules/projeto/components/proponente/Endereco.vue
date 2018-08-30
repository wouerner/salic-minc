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
            <tr>
                <td>{{dadosProponente.dados.Endereco}}</td>
                <td>{{dadosProponente.dados.Municipio}}</td>
                <td class="center-align">{{dadosProponente.dados.Uf}}</td>
                <td class="center-align">
                    <SalicFormatarCep :cep="dadosProponente.dados.Cep"/>
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
