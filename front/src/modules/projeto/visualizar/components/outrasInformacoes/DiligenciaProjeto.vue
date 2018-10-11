<template>
    <div id="conteudo">
            <IdentificacaoProjeto
                :pronac="dadosProjeto.Pronac"
                :nomeProjeto="dadosProjeto.NomeProjeto"
            >
            </IdentificacaoProjeto>
            <div v-if="dados.diligenciaProposta">
                <div v-if="dados.diligenciaProposta.length > 0">
                    <fieldset>
                        <legend>Dilig&ecirc;ncia Proposta</legend>
                            <VisualizarDiligenciaProposta
                                :idPronac="idPronac"
                                :infos="dados.diligenciaProposta"
                            >
                            </VisualizarDiligenciaProposta>
                    </fieldset>
                </div>
            </div>
            <div v-if="dados.diligenciaAdequacao">
                <div v-if="dados.diligenciaAdequacao.length > 0">
                    <fieldset>
                        <legend>Dilig&ecirc;ncias da Adequa&ccedil;&atilde;o do Projeto</legend>
                        <table class="tabela">
                            <thead>
                                <tr class="destacar">
                                    <th>VISUALIZAR</th>
                                    <th>DATA DA AVALIA&Ccedil;&Atilde;O</th>
                                    <th>TIPO DE DILIG&Ecirc;NCIA</th>
                                </tr>
                            </thead>
                            <tbody v-for="(dado, index) in dados.diligenciaAdequacao" :key="index">
                                <tr>
                                    <td class="center">
                                        <button class="waves-effect waves-darken btn white black-text">
                                            <i class="material-icons">visibility</i>
                                        </button>
                                    </td>
                                    <td>{{ dado.dtAvaliacao }}</td>
                                    <td>{{ dado.tipoDiligencia }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </fieldset>
                </div>
            </div>
            <div v-if="dados.diligenciaProjeto">
                <div v-if="dados.diligenciaProjeto.length > 0">
                    <fieldset>
                        <legend>Dilig&ecirc;ncia Projeto</legend>
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
                            <tbody v-for="(dado, index) in dados.diligenciaProjeto" :key="index">
                                <tr>
                                    <td class="center">
                                        <button class="waves-effect waves-darken btn white black-text">
                                            <i class="material-icons">visibility</i>
                                        </button>
                                    </td>
                                    <td v-if="dado.produto">{{ dado.produto }}</td>
                                    <td v-else class="center"> - </td>
                                    <td>{{ dado.tipoDiligencia }}</td>
                                    <td>{{ dado.dataSolicitacao }}</td>
                                    <td>{{ dado.dataResposta }}</td>
                                    <td>{{ dado.prazoResposta }}</td>
                                    <td>Prorrogado</td>
                                </tr>
                            </tbody>
                        </table>
                    </fieldset>
                </div>
            </div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
import IdentificacaoProjeto from './IdentificacaoProjeto';
import VisualizarDiligenciaProposta from './components/VisualizarDiligenciaProposta';


export default {
    name: 'DiligenciaProjeto',
    components: {
        IdentificacaoProjeto,
        VisualizarDiligenciaProposta,
    },
    data() {
        return {
            dados: {
                    type: Object,
                    default() {
                        return {};
                    },
                },
            idPronac: {},
        };
    },
    mounted() {
        if (typeof this.$route.params.idPronac !== 'undefined') {
            this.buscar_dados();
        }
    },
    computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
            }),
        },
    methods: {
        buscar_dados() {
            const self = this;
            self.idPronac = self.$route.params.idPronac
            /* eslint-disable */
            $3.ajax({
                url: '/projeto/diligencia-projeto-rest/index/idPronac/' + self.idPronac,
            }).done(function (response) {
                self.dados = response.data;
            });
        },
    },
}
</script>

