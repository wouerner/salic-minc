<template>
    <div>
        <table class="tabela">
            <thead>
                <tr class="destacar">
                    <th>VISUALIZAR</th>
                    <th>DATA DA AVALIA&Ccedil;&Atilde;O</th>
                    <th>TIPO DE DILIG&Ecirc;NCIA</th>
                </tr>
            </thead>
            <tbody v-for="(diligencia, index) in diligencias" :key="index">
                <tr>
                    <td class="center">
                        <button
                            class="waves-effect waves-darken btn white black-text"
                            @click="setActiveTab(diligencia.idAvaliarAdequacaoProjeto)"
                        >
                            <i class="material-icons">visibility</i>
                        </button>
                    </td>
                    <td>{{ diligencia.dtAvaliacao }}</td>
                    <td>{{ diligencia.tipoDiligencia }}</td>
                </tr>
            </tbody>
        </table>
        <table v-if="activeTab && Object.keys(dadosDiligencia).length > 0">
            <tr>
                <td colspan="3">
                    <table v-if="dadosDiligencia.dsAvaliacao" class="tabela">
                        <tbody>
                        <tr>
                            <th>SOLICITA&Ccedil;&Atilde;O</th>
                        </tr>
                        <tr>
                            <td style="padding-left: 20px" v-html="dadosDiligencia.dsAvaliacao"></td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
export default {
    name: 'VisualizarDiligenciaAdequacao',
    props: ['idPronac', 'diligencias'],
    data() {
        return {
            dadosDiligencia: {
                type: Object,
                default() {
                    return {};
                },
            },
            activeTab: false,
        };
    },
    methods: {
        setActiveTab(idAvaliarAdequacaoProjeto) {
            this.activeTab = !this.activeTab;
            this.obterDiligencias(idAvaliarAdequacaoProjeto);
        },
        obterDiligencias(idAvaliarAdequacaoProjeto) {
            const self = this;
            /* eslint-disable */
            $3.ajax({
                url: `/projeto/diligencia-adequacao-rest/get/idPronac/${self.idPronac}/idAvaliarAdequacaoProjeto/${idAvaliarAdequacaoProjeto}`,
            }).done(function (response) {
                self.dadosDiligencia = response.data;
            });
        },
    },
}
</script>

