<template>
    <div class="conteudo">
        <legend>Identificação</legend>
        <table class="tabela">
            <tr class="destacar">
                <td align="center"><b>PRONAC</b></td>
                <td align="center"><b>Nome do Projeto</b></td>
            </tr>
            <tr>
                <td align="center">{{dadosProjeto.Pronac}}</td>
                <td align="center">{{dadosProjeto.NomeProjeto}}</td>
            </tr>
        </table>
        <br clear="all">
        <table class="tabela" v-if="dadosProjeto.ProponenteInabilitado" style="background-color: red;">
            <tr style="background-color: red;">
                <td align="center" style="text-transform: uppercase; color: red;">
                    <b>Proponente Inabilitado</b>
                </td>
            </tr>
        </table>
        <table class="tabela">
            <tr class="destacar">
                <td tabindex="1" align="center"><b>CNPJ/CPF</b></td>
                <td tabindex="2" align="center"><b>Nome do Proponente</b></td>
                <td tabindex="3" align="center"><b>Tipo de Pessoa</b></td>
            </tr>
            <tr>
                <td tabindex="4" align="center" v-if="dadosProjeto.CgcCPf">
                    <SalicFormatarCpfCnpj :cpf="dadosProjeto.CgcCPf"/>
                </td>
                <td tabindex="4" align="center" v-else>Dado não informado!</td>
                <td tabindex="5" align="center" v-if="dadosProjeto.Proponente">
                    {{dadosProjeto.Proponente}}
                </td>
                <td tabindex="5" align="center" v-else>Dado não informado!</td>
                <td tabindex="6" align="center">{{tipoProponente}}</td>
            </tr>
        </table>
    </div>
</template>

<script type="text/javascript">

    import { mapGetters } from 'vuex';
    import SalicFormatarCpfCnpj from '@/components/SalicFormatarCpfCnpj';

    export default{
        components:{
            SalicFormatarCpfCnpj,
        },
        methods: {
            tipoCgcCPf(cgcCPf) {
                let resposta = '';

                switch(String(cgcCPf).length) {
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

                if(String(cgcCPf).length > 0) {
                    return this.tipoCgcCPf(cgcCPf);
                } else {
                    return 'Dado não informado!'
                }
            },
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
            }),
        }
    };


</script>
