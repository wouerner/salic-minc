<template>
    <div class="conteudo">
        <legend>Identificação</legend>
        <table class="tabela">
            <tr class="destacar">
                <td><b>PRONAC</b></td>
                <td><b>Nome do Projeto</b></td>
            </tr>
            <tr>
                <td>{{dadosProjeto.Pronac}}</td>
                <td>{{dadosProjeto.NomeProjeto}}</td>
            </tr>
        </table>
        <table class="tabela" v-if="dadosProjeto.ProponenteInabilitado" style="background-color: red;">
            <tr style="background-color: red;">
                <td align="center" style="text-transform: uppercase; color: red;">
                    <b>Proponente Inabilitado</b>
                </td>
            </tr>
        </table>
        <table class="tabela">
            <tr class="destacar">
                <td><b>CNPJ/CPF</b></td>
                <td><b>Nome do Proponente</b></td>
            </tr>
            <tr>
                <td v-if="dadosProjeto.cgcCPf">
                    <SalicFormatarCpfCnpj :cpf="dadosProjeto.cgcCPf"/>
                </td>
                <td v-else>Dado não informado!</td>
                <td v-if="dadosProjeto.NomeProponente">
                    {{dadosProjeto.NomeProponente}}
                </td>
                <td v-else>Dado não informado!</td>
            </tr>
        </table>
    </div>
</template>

<script type="text/javascript">

    import SalicFormatarCpfCnpj from '@/components/SalicFormatarCpfCnpj';

    export default {
        props: {
            dadosProjeto: {},
        },
        components: {
            SalicFormatarCpfCnpj,
        },
    };
</script>
