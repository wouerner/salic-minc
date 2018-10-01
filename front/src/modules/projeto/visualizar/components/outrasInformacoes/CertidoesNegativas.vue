<template>
    <div v-if="dados">
        <table class="tabela">
            <thead>
                <tr class="destacar">
                    <th>PRONAC</th>
                    <th>Nome do Projeto</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ dados.Pronac }}</td>
                    <td>{{ dados.NomeProjeto }}</td>
                </tr>
            </tbody>
        </table>
        <table class="tabela">
            <thead>
                <tr class="destacar">
                    <th>CERTIDOES</th>
                    <th>DATA DE EMISSAO</th>
                    <th>DATA DE VALIDADE</th>
                    <th>PRONAC</th>
                    <th>SITUACAO</th>
                </tr>
            </thead>
            <tbody v-for="(dado, index) in dados" :key="index">
                <tr>
                    <td>{{ dado.dsCertidao }}</td>
                    <td>{{ dado.DtEmissao }}</td>
                    <td>{{ dado.DtValidade }}</td>
                    <td>{{ dado.Pronac }}</td>
                    <td>{{ dado.Situacao }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    name: 'CertidoesNegativas',
    props: ['idPronac'],
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
                url: '/projeto/certidoes-negativas-rest/index/idPronac/' + idPronac,
            }).done(function (response) {
                self.dados = response.data;
            });
        },
    },
}
</script>

