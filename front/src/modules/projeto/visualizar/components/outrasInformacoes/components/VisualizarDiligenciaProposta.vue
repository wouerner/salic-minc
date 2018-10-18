<template>
    <div>
        <table class="tabela" v-if="Object.keys(diligencias).length > 0">
            <thead>
                <tr class="destacar">
                    <th>VISUALIZAR</th>
                    <th>NR PROPOSTA</th>
                    <th>DATA DA SOLICITA&Ccedil;&Atilde;O</th>
                </tr>
            </thead>
            <tbody v-for="(diligencia, index) in diligencias" :key="index">
                <tr>
                    <td class="center">
                        <button
                            class="waves-effect waves-darken btn white black-text"
                            @click="setAbaAtiva(diligencia.idPreprojeto, diligencia.idAvaliacaoProposta, index)"
                        >
                            <i class="material-icons">visibility</i>
                        </button>
                    </td>
                    <td>{{ diligencia.idPreprojeto }}</td>
                    <td>{{ diligencia.dataSolicitacao }}</td>
                </tr>
                <tr v-if="abaAtiva === index && ativo && Object.keys(dadosDiligencia).length > 2">
                    <td colspan="3">
                        <template>
                        <table class="tabela">
                            <tbody>
                            <tr>
                                <th>Nr PROPOSTA</th>
                                <th>NOME DA PROPOSTA</th>
                            </tr>
                            <tr>
                                <td>{{ dadosDiligencia.idPreprojeto }}</td>
                                <td>{{ dadosDiligencia.nomeProjeto }}</td>
                            </tr>
                            <tr>
                                <th>DATA DA SOLICITA&Ccedil;&Atilde;O</th>
                                <th>DATA DA RESPOSTA</th>
                            </tr>
                            <tr>
                                <td>{{ dadosDiligencia.dataSolicitacao }}</td>
                                <td>{{ dadosDiligencia.dataResposta }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <table v-if="dadosDiligencia.Solicitacao" class="tabela">
                            <tbody>
                            <tr>
                                <th>SOLICITA&Ccedil;&Atilde;O</th>
                            </tr>
                            <tr>
                                <td style="padding-left: 20px" v-html="dadosDiligencia.Solicitacao"></td>
                            </tr>
                            </tbody>
                        </table>
                        <table v-if="dadosDiligencia.Resposta" class="tabela">
                            <tbody>
                            <tr>
                                <th>RESPOSTA:</th>
                            </tr>
                            <tr>
                                <td style="padding-left: 20px" v-html="dadosDiligencia.Resposta"></td>
                            </tr>
                            </tbody>
                        </table>
                        </template>
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-else class="center">
            <em>Dados n&atilde;o  informado.</em>
        </div>
    </div>
</template>

<script>
export default {
    name: 'VisualizarDiligenciaProposta',
    props: ['idPronac', 'diligencias'],
    data() {
        return {
            dadosDiligencia: {
                type: Object,
                default() {
                    return {};
                },
            },
            abaAtiva: -1,
            ativo: false,
        };
    },
    methods: {
        setAbaAtiva(idPreProjeto, idAvaliacaoProposta, index) {
            if (this.abaAtiva === index) {
                this.ativo = !this.ativo;
            } else {
                this.abaAtiva = index;
                this.ativo = true;
                this.obterDiligencias(idPreProjeto, idAvaliacaoProposta);
            }
        },
        obterDiligencias(idPreProjeto, idAvaliacaoProposta) {
            const self = this;
            /* eslint-disable */
            $3.ajax({
                url: `/projeto/diligencia-proposta-rest/get/idPreProjeto/${idPreProjeto}/idAvaliacaoProposta/${idAvaliacaoProposta}`,
            }).done(function (response) {
                self.dadosDiligencia = response.data;
            });
        },
    },
}
</script>

