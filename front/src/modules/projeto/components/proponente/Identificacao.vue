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
                <td><b>Tipo de Pessoa</b></td>
            </tr>
            <tr>
                <td v-if="dadosProjeto.CgcCPf">
                    <SalicFormatarCpfCnpj :cpf="dadosProjeto.CgcCPf"/>
                </td>
                <td v-else>Dado não informado!</td>
                <td v-if="dadosProjeto.Proponente">
                    {{dadosProjeto.Proponente}}
                </td>
                <td v-else>Dado não informado!</td>
                <td>{{tipoProponente}}</td>
            </tr>
        </table>
    </div>
</template>

<script type="text/javascript">

    import { mapGetters } from 'vuex';
    import SalicFormatarCpfCnpj from '@/components/SalicFormatarCpfCnpj';

    export default {
        components: {
            SalicFormatarCpfCnpj,
        },
        methods: {
            tipoCgcCPf(cgcCPf) {
                let resposta = '';

                switch (String(cgcCPf).length) {
                case 11:
                    resposta = 'Pessoa Física';
                    break;
                case 14:
                    resposta = 'Pessoa Jurídica';
                    break;
                default:
                    resposta = 'CPF/CNPJ inválido!';
                }

                return resposta;
            },
        },
        computed: {
            tipoProponente() {
                const cgcCPf = this.dadosProjeto.CgcCPf;

                if (String(cgcCPf).length > 0) {
                    return this.tipoCgcCPf(cgcCPf);
                }
                return 'Dado não informado!';
            },
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
            }),
        },
    };
</script>
