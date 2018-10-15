<template>
    <div>
        <table class="tabela">
            <thead>
                <tr class="destacar">
                    <th>VISUALIZAR</th>
                    <th>NR PROPOSTA</th>
                    <th>DATA DA SOLICITA&Ccedil;&Atilde;O</th>
                </tr>
            </thead>
            <tbody v-for="(info, index) in infos" :key="index">
                <tr>
                    <td class="center">
                        <button
                            class="waves-effect waves-darken btn white black-text"
                            @click="setActiveTab(index);"
                        >
                            <i class="material-icons">visibility</i>
                        </button>
                    </td>
                    <td>{{ info.idPreprojeto }}</td>
                    <td>{{ info.dataSolicitacao }}</td>
                </tr>
                <tr v-if="activeTab === index && dados.diligenciaProposta.length > 0">
                    <td colspan="3">
                         <table class="tabela">
                            <tbody>
                                <tr>
                                    <th>Nr PROPOSTA</th>
                                    <th>NOME DA PROPOSTA</th>
                                </tr>
                                <tr>
                                    <td>{{ dados.diligenciaProposta[index].idPreprojeto }}</td>
                                    <td>{{ dados.diligenciaProposta[index].nomeProjeto }}</td>
                                </tr>
                                <tr>
                                    <th>DATA DA SOLICITA&Ccedil;&Atilde;O</th>
                                    <th>DATA DA RESPOSTA</th>
                                </tr>
                                <tr>
                                    <td>{{ dados.diligenciaProposta[index].dataSolicitacao }}</td>
                                    <td>{{ dados.diligenciaProposta[index].Resposta }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table v-if="dados.diligenciaProposta[index].Solicitacao" class="tabela">
                            <tbody>
                                <tr>
                                    <th>SOLICITA&Ccedil;&Atilde;O</th>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px" v-html="dados.diligenciaProposta[index].Solicitacao"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table v-if="dados.diligenciaProposta[index].Resposta" class="tabela">
                            <tbody>
                                <tr>
                                    <th>RESPOSTA</th>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px" v-html="dados.diligenciaProposta[index].Resposta"></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: 'VisualizarDiligenciaProposta',
    props: ['idPronac', 'infos'],
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
            });
        },
    },
}
</script>

