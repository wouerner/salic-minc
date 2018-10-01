<template>
    <div>
        <table class="tabela">
            <thead>
                <tr class="destacar">
                    <th>PRONAC</th>
                    <th>Nome do Projeto</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>209561</td>
                    <td>Teste</td>
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
            <tbody>
                <tr>
                    <td>teste certidoes</td>
                    <td>teste data 1</td>
                    <td>teste data 2</td>
                    <td>209561</td>
                    <td>Teste</td>
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
            this.buscar_dados();
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

