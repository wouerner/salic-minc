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
                    <td>{{ info.dtAvaliacao }}</td>
                    <td>{{ info.tipoDiligencia }}</td>
                </tr>
                <tr v-if="activeTab === index && dados.diligenciaAdequacao.length > 0">
                    <td colspan="3">
                        <table v-if="dados.diligenciaAdequacao[index].dsAvaliacao" class="tabela">
                            <tbody>
                                <tr>
                                    <th>SOLICITA&Ccedil;&Atilde;O</th>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px" v-html="dados.diligenciaAdequacao[index].dsAvaliacao"></td>
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
    name: 'VisualizarDiligenciaAdequacao',
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

