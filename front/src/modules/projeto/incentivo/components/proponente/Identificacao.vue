<template>
    <div class="conteudo">
        <legend>Identificação</legend>
        <table class="tabela">
            <tr class="destacar">
                <td align="center"><b>PRONAC</b></td>
                <td align="center"><b>Nome do Projeto</b></td>
            </tr>
            <tr>
                <td align="center">{{codPronac}}</td>
                <td align="center">{{nmeProjeto}}</td>
            </tr>
        </table>
        <br clear="all">
        
        <table class="tabela" v-if="ProponenteInabilitado" style="background-color: red;">
            <tr style="background-color: red;">
                <td align="center" style="text-transform: uppercase; color: red;"><b>Proponente Inabilitado</b></td>
            </tr>
        </table>
        
        <table class="tabela" v-else>
            <tr class="destacar">
                <td tabindex="1" align="center">CNPJ/CPF</td>
                <td tabindex="2" align="center"><b>Nome do Proponente</b></td>
                <td tabindex="3" align="center"><b>Tipo de Pessoa</b></td>
            </tr>
            <tr>
                <td tabindex="4" align="center">{{cnpj_cpf|formataCPF}}</td>
                <td tabindex="5" align="center">{{nmeProponente}}</td>
                <td tabindex="6" align="center">{{tpoPessoa}}</td>
            </tr>
        </table>
    </div>
</template>

<script type="text/javascript">
    import numberToFormat from 'numeral';

    export default{
        data() {
            return{
                codPronac: 510115,
                nmeProjeto: 'NINE',
                cnpj_cpf: '',
                nmeProponente:'',
                tpoPessoa:'Pessoa Jurídica',
                ProponenteInabilitado: false,
            };
        },
        filters:{
            formataCPF(campo){
                if (campo.length === 0) {
                    return '';
                }
                return numberToFormat(campo).format('000.000.000-00');
            }
        }
    };
</script>