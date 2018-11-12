<template>
    <!-- <div id="conteudo">
        <div v-if="loading">
            <Carregando :text="'Carregando Plano de Distribuicao'"></Carregando>
        </div>
        <div v-else-if="dadosIn2013">
            <table>
                <tbody v-for="(dado, index) in dadosIn2013" :key="index">
                <tr>
                    <td align="left">
                        <input type="button"
                               class="btn_adicionar"
                               id="objetivos"
                               @click="setActiveTab(index);">
                        <b>{{ dado.Produto }}</b><b>
                        <span class="red" v-if="dado.stPrincipal === 1 "> (produto principal)</span>
                    </b>

                    </td>
                </tr>

                <tr v-if="activeTab === index" align="left" style="padding: 5px">
                    <td>
                        <table class="tabela">
                            <tbody>
                            <tr>
                                <td colspan="2" align="center" class="destacar">
                                    <b>Produto</b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center" style="font-size: 11pt">
                                    <b>{{ dado.Produto }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" class="destacar">
                                    <b>&Aacute;rea</b>
                                </td>
                                <td align="center" class="destacar">
                                    <b>Segmento</b>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">{{ dado.Area }}</td>
                                <td align="center">{{ dado.Segmento }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <table class="tabela">
                                        <tbody>
                                        <tr class="destacar">
                                            <td align="center">
                                                <b>Distribui&ccedil;&atilde;o Gratuita (Qtde)</b>
                                            </td>
                                            <td align="center">
                                                <b>Total para Venda (Qtde)</b>
                                            </td>
                                            <td align="center">
                                                <b>Total Produzido</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table class="tabela">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <b>Patrocinador</b><br>
                                                            {{ dado.QtdePatrocinador }}
                                                            <br>
                                                        </td>
                                                        <td>
                                                            <b>Divulga&ccedil;&atilde;o</b><br>
                                                            {{ dado.QtdeProponente }}
                                                        </td>
                                                        <td>
                                                            <b>Popula&ccedil;&atilde;o de Baixa Renda</b><br>
                                                            {{ dado.QtdeOutros }}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td>
                                                <table class="tabela">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <b>Normal</b><br>
                                                            {{ dado.QtdeVendaNormal }}
                                                        </td>
                                                        <td>
                                                            <b>Promocional</b><br>
                                                            {{ dado.QtdeVendaPromocional }}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td>
                                                <table class="tabela">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <b>Nº Exemplares / Ingressos</b><br>
                                                            {{ dado.QtdeProduzida }}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr class="destacar">
                                            <td align="center">
                                                <b>Pre&ccedil;o Unit&aacute;rio (R$)</b>
                                            </td>
                                            <td align="center">
                                                <b>Receita Prevista (R$)</b>
                                            </td>
                                            <td align="center">
                                                <b>Total Receita Prevista (R$)</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table class="tabela">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <b>Normal</b><br>
                                                            {{ dado.PrecoUnitarioNormal }}
                                                        </td>
                                                        <td>
                                                            <b>Promocional</b><br>
                                                            {{ dado.PrecoUnitarioPromocional }}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td>
                                                <table class="tabela">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <b>Normal</b><br>
                                                            {{ dado.ReceitaNormal }}
                                                        </td>
                                                        <td>
                                                            <b>Promocional</b><br>
                                                            {{ dado.ReceitaPro }}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td>
                                                <table class="tabela">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <b>Total Receita Prevista (R$)</b><br>
                                                            {{ dado.ReceitaPrevista }}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div> -->
    <v-expansion-panel popout>
        <v-expansion-panel-content
            class="elevation-1"
            v-for="(dado, index) in dadosIn2013"
            :key="index"
        >
            <v-layout slot="header" class="green--text">
                <v-icon class="mr-3 green--text">subject</v-icon>
                <span>{{dado.Produto}}</span>
            </v-layout>
            <v-container fluid>
                <v-card class="elevation-2" color="grey lighten-4">
                    <v-card-text class="pl-5">
                        <v-layout justify-space-around row wrap>
                            <v-flex lg12 class="text-xs-center">
                                <p><b>Produto</b></p>
                                <p>{{ dado.Produto }}</p>
                            </v-flex>
                        </v-layout>
                        <v-layout justify-space-around row wrap>
                            <v-flex lg5 class="text-xs-center">
                                <p><b>&Aacute;REA</b></p>
                                <p>{{ dado.Area }}</p>
                            </v-flex>
                            <v-flex lg5 class="text-xs-center">
                                <p><b>SEGMENTO</b></p>
                                <p>{{ dado.Segmento }}</p>
                            </v-flex>
                        </v-layout>
                        <v-layout justify-space-around row wrap>
                                <v-flex lg12 class="text-xs-center">
                                    <p><b>DISTRIBUI&Ccedil;&Atilde;O GRATUITA (QTDE)</b></p>
                                </v-flex>
                                <v-flex s12 m6 lg3 offset-lg2>
                                    <p>
                                        <b>Patrocinador</b><br>
                                        {{ dado.QtdePatrocinador }}
                                    </p>
                                </v-flex>
                                <v-flex s6 m6 lg3>
                                    <p>
                                        <b>Divulga&ccedil;&atilde;o</b><br>
                                        {{ dado.QtdeProponente }}
                                    </p>
                                </v-flex>
                                <v-flex s12 m6 offset-xlg10>
                                    <p>
                                        <b>Popula&ccedil;&atilde;o Baixa Renda</b><br>
                                        {{ dado.QtdeOutros }}
                                    </p>
                                </v-flex>
                            </v-layout>
                            <v-layout justify-space-around row wrap>
                                <v-flex lg12 class="text-xs-center">
                                    <p><b>TOTAL PARA VENDA (QTDE)</b></p>
                                </v-flex>
                                <v-flex s3 m6 lg5 offset-lg2 class="text-xs-center">
                                    <p>
                                        <b>Normal</b><br>
                                        {{ dado.QtdeVendaNormal }}
                                    </p>
                                </v-flex>
                                <v-flex s3 m6 lg5>
                                    <p>
                                        <b>Proporcional</b><br>
                                        {{ dado.QtdeVendaPromocional }}
                                    </p>
                                </v-flex>
                            </v-layout>
                            <v-layout justify-space-around row wrap>
                                <v-flex lg12 class="text-xs-center">
                                    <p><b>TOTAL PRODUZIDO</b></p>
                                    <p>
                                        <b>N&ordm; Exemplares / Ingressos</b><br>
                                        {{ dado.QtdeProduzida }}
                                    </p>
                                </v-flex>
                            </v-layout>
                            <v-layout justify-space-around row wrap>
                                <v-flex lg12 class="text-xs-center">
                                    <p><b>PRE&Ccedil;O UNIT&Aacute;RIO (R$)</b></p>
                                </v-flex>
                                <v-flex s3 m6 lg5 offset-lg2 class="text-xs-center">
                                    <p>
                                        <b>Normal</b><br>
                                        {{ dado.PrecoUnitarioNormal }}
                                    </p>
                                </v-flex>
                                <v-flex s3 m6 lg5>
                                    <p>
                                        <b>Proporcional</b><br>
                                        {{ dado.PrecoUnitarioPromocional }}
                                    </p>
                                </v-flex>
                            </v-layout>
                            <v-layout justify-space-around row wrap>
                                <v-flex lg5 offset-lg1 class="text-xs-center pl-4">
                                    <p><b>RECEITA PREVISTA (R$)</b></p>
                                </v-flex>
                                <v-flex lg6 class="text-xs-center">
                                    <p><b>TOTAL RECEITA PREVISTA (R$)</b></p>
                                </v-flex>
                                <v-flex s12 m6 lg3 offset-lg2>
                                    <p>
                                        <b>Normal</b><br>
                                        {{ dado.ReceitaNormal }}
                                    </p>
                                </v-flex>
                                <v-flex s6 m6 lg3>
                                    <p>
                                        <b>Proporcional</b><br>
                                        {{ dado.ReceitaPro }}
                                    </p>
                                </v-flex>
                                <v-flex s12 m6 offset-xlg10>
                                    <p>
                                        <b>Total Receita Prevista (R$)</b><br>
                                        {{ dado.ReceitaPrevista }}
                                    </p>
                                </v-flex>
                            </v-layout>
                    </v-card-text>
                </v-card>
            </v-container>
        </v-expansion-panel-content>
    </v-expansion-panel>
</template>
<script>
    import { mapGetters, mapActions } from 'vuex';
    import Carregando from '@/components/Carregando';

    export default {
        name: 'PlanoDistribuicao-in-2013',
        props: ['idPronac'],
        components: {
            Carregando,
        },
        data() {
            return {
                informacoes: {},
                loading: true,
                activeTab: -1,
            };
        },
        mounted() {
            if (typeof this.$route.params.idPronac !== 'undefined') {
                this.buscarPlanoDistribuicaoIn2013(this.dadosProjeto.idPronac);
            }
        },
        watch: {
            dados(value) {
                this.informacoes = value.informacoes;
            },
            dadosIn2013() {
                this.loading = false;
            },
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dadosIn2013: 'projeto/planoDistribuicaoIn2013',
            }),
        },
        methods: {
            ...mapActions({
                buscarPlanoDistribuicaoIn2013: 'projeto/buscarPlanoDistribuicaoIn2013',
            }),
            setActiveTab(index) {
                if (this.activeTab === index) {
                    this.activeTab = -1;
                } else {
                    this.activeTab = index;
                }
            },
        },
    };
</script>
