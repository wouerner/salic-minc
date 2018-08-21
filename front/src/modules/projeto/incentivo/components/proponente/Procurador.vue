<template>
    <div class="conteudo">
        <legend>Procurador</legend>
        <table class="tabela" v-if="Object(dadosProponente.procuradores).length > 0">
            <tr class="destacar">
                <td width="20%" align="center"><b>CPF</b></td>
                <td align="center"><b>Nome</b></td>
            </tr>
            <tr v-for="procurador in dadosProponente.procuradores" v-bind:key="procurador.idAgente">
                <td align="center">
                    <SalicFormatarCpfCnpj :cpf="procurador.CNPJCPF"/>
                </td>
                <td align="left">{{procurador.nome}}</td>
            </tr>
        </table>
        <table class="tabela" v-else>
            <tr>
                <td colspan="2" align="left"><em>N&atilde;o existe Procurador cadastrado</em></td>
            </tr>
        </table>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import SalicFormatarCpfCnpj from '@/components/SalicFormatarCpfCnpj';

    export default {
        components: {
            SalicFormatarCpfCnpj,
        },
        computed: {
            ...mapGetters({
                dadosProponente: 'projeto/proponente',
            }),
        },
    };
</script>
