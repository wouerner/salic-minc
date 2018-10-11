<template>
    <div id="conteudo">
        <button class="waves-effect waves-darken btn white black-text"
                @click="setActiveTab(posicao);">
            <i class="material-icons">visibility</i>
        </button>
        <div v-if="activeTab === posicao">
                <table>
                    <thead>
                        <tr>
                            <th>NR PROPOSTA</th>
                            <th>NOME DA PROPOSTA</th>
                        </tr>
                        <tr>
                            <th>DATA DA SOLICITA&Ccedil;&Atilde;O</th>
                            <th>DATA DA RESPOSTA</th>
                        </tr>
                        <tr>
                            <th>SOLICITA&Ccedil;&Atilde;O</th>
                        </tr>
                        <tr>
                            <th>RESPOSTA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ dados.diligenciaProposta[posicao].idPreprojeto }}</td>
                            <td>{{ dados.diligenciaProposta[posicao].nomeProjeto }}</td>
                        </tr>
                        <tr>
                            <td>{{ dados.diligenciaProposta[posicao].dataSolicitacao }}</td>
                            <td>{{ dados.diligenciaProposta[posicao].dataResposta }}</td>
                        </tr>
                        <tr>
                            <td>{{ dados.diligenciaProposta[posicao].Solicitacao }}</td>
                        </tr>
                        <tr>
                            <td>{{ dados.diligenciaProposta[posicao].Resposta }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </div>
</template>

<script>
export default {
    name: 'VisualizarDiligenciaProposta',
    props: ['idPronac', 'posicao'],
    data() {
        return {
            dados: {
                    type: Object,
                    default() {
                        return {};
                    },
                },
            activeTab: -1,
        };
    },
    mounted() {
        if (typeof this.idPronac !== 'undefined') {
            this.buscar_dados();
        }
    },
    methods: {
        setActiveTab(index) {
            if (this.activeTab === index) {
                this.activeTab = -1;
            } else {
                this.activeTab = index;
            }
        },
        buscar_dados() {
            const self = this;
            /* eslint-disable */
            $3.ajax({
                url: '/projeto/diligencia-projeto-rest/get/idPronac/' + self.idPronac,
            }).done(function (response) {
                self.dados = response.data;
                console.log(self.dados.diligenciaProposta[self.posicao].idPreprojeto)
            });
        },
    },
}
</script>

