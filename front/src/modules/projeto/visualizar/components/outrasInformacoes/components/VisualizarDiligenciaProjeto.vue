<template>
    <div>
        <table class="tabela">
            <thead>
                <tr class="destacar">
                    <th>VISUALIZAR</th>
                    <th>PRODUTO</th>
                    <th>TIPO DE DILIG&Ecirc;NCIA</th>
                    <th>DATA DA SOLICITA&Ccedil;&Atilde;O</th>
                    <th>DATA DA RESPOSTA</th>
                    <th>PRAZO DA RESPOSTA</th>
                    <th>PRORROGADO</th>
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
                    <td v-if="info.produto">{{ info.produto }}</td>
                    <td v-else class="center"> - </td>
                    <td>{{ info.tipoDiligencia }}</td>
                    <td>{{ info.dataSolicitacao }}</td>
                    <td>{{ info.dataResposta }}</td>
                    <td>{{ info.prazoResposta }}</td>
                    <td>Prorrogado</td>
                </tr>
                <tr v-if="activeTab === index && dados.diligenciaProjeto.length > 0">
                    <td colspan="7">
                         <table class="tabela">
                            <tbody>
                                <tr>
                                    <th>PRONAC</th>
                                    <th>NOME DO PROJETO</th>
                                </tr>
                                <tr>
                                    <td>{{ idPronac }}</td>
                                    <td>{{ dados.diligenciaProjeto[index].nomeProjeto }}</td>
                                </tr>
                                <tr>
                                    <th>DATA DA SOLICITA&Ccedil;&Atilde;O</th>
                                    <th>DATA DA RESPOSTA</th>
                                </tr>
                                <tr>
                                    <td>{{ dados.diligenciaProjeto[index].dataSolicitacao }}</td>
                                    <td>{{ dados.diligenciaProjeto[index].dataResposta }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table v-if="dados.diligenciaProjeto[index].Solicitacao" class="tabela">
                            <tbody>
                                <tr>
                                    <th>SOLICITA&Ccedil;&Atilde;O</th>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px" v-html="dados.diligenciaProjeto[index].Solicitacao"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table v-if="dados.diligenciaProjeto[index].Resposta" class="tabela">
                            <tbody>
                                <tr>
                                    <th>RESPOSTA</th>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px" v-html="dados.diligenciaProjeto[index].Resposta"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table v-if="dados.diligenciaProjeto[index].Arquivo" class="tabela">
                            <tbody>
                                <tr>
                                    <th colspan="2">ARQUIVOS ANEXADOS</th>
                                </tr>
                                <tr>
                                    <th>Arquivo</th>
                                    <th>Dt. Envio</th>
                                </tr>
                                <tr v-for="(Arquivo, index) in dados.diligenciaProjeto[index].Arquivo" :key="index">
                                    <td style="padding-left: 20px" v-html="Arquivo.nmArquivo"></td>
                                    <td> {{ Arquivo.dtEnvio }}</td>
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
    name: 'VisualizarDiligenciaProjeto',
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

