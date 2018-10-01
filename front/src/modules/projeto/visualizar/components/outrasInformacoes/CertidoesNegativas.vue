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
        return idPronac = 216941;
    },
    methods: {
            // buscar_dados() {
            //     const self = this;
            //     /* eslint-disable */
            //     $3.ajax({
            //         url: '/projeto/certidoes-negativas-rest/get-action/idPronac/' + self.idPronac
            //     }).done(function (response) {
            //         self.dadosAtuais = response.data.atual;
            //         self.dadosHistorico = response.data.historico;
            //     });
            // },
        },
}
</script>

