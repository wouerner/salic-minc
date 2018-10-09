<template>
    <div id="conteudo">
        <div v-if="dados.providenciaTomada">
            <table class="tabela">
                <thead>
                    <tr class="destacar">
                        <th class="center">DT. SITUA&Ccedil;&Atilde;O</th>
                        <th class="center">SITUA&Ccedil;&Atilde;O</th>
                        <th class="center">PROVID&Ecirc;NCIA TOMADA</th>
                        <th class="center">CPF</th>
                        <th class="center">NOME</th>
                    </tr>
                </thead>
                <tbody v-for="(dado, index) in dados.providenciaTomada" :key="index">
                    <tr>
                        <td class="center">{{ dado.DtSituacao }}</td>
                        <td class="center">{{ dado.Situacao }}</td>
                        <td class="center">{{ dado.ProvidenciaTomada }}</td>
                        <td class="center">{{ dado.cnpjcpf }}</td>
                        <td class="center">{{ dado.usuario }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import IdentificacaoProjeto from './IdentificacaoProjeto';

export default {
    name: 'ProvidenciaTomada',
    components: {
        IdentificacaoProjeto,
    },
    data() {
        return {
            dados: {
                    type: Object,
                    default() {
                        return {};
                    },
                },
        };
    },
    mounted() {
        if (typeof this.$route.params.idPronac !== 'undefined') {
            this.buscar_dados();
        }
    },
    methods: {
        buscar_dados() {
            const self = this;
            const idPronac = self.$route.params.idPronac
            /* eslint-disable */
            $3.ajax({
                url: '/projeto/providencia-tomada-rest/index/idPronac/' + idPronac,
            }).done(function (response) {
                self.dados = response.data;
            });
        },
    },
}
</script>

