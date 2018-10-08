<template>
    <div id="conteudo">
        <IdentificacaoProjeto
            :pronac="informacoes.Pronac"
            :nomeProjeto="informacoes.NomeProjeto">
        </IdentificacaoProjeto>

        <table class="">
            <tbody v-for="(dado, index) in dados">
                <tr>
                    <td align="left">
                        <input  type="button"
                                class="btn_adicionar"
                                id="objetivos"
                                @click="setActiveTab(1);">
                        <b>{{ dado.Produto }}</b><b>
                            <span class="red" v-if="dado.stPrincipal == 1 "> (produto principal)</span>
                        </b>

                    </td>
                </tr>

                <tr v-if="activeTab === 1" align="left" style="padding: 5px">
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
                                    <b>Área</b>
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
                                                <b>Distribuição Gratuita (Qtde)</b>
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
                                                            <b>Patrocinador</b>
                                                            <br>
                                                        </td>
                                                        <td>
                                                            <b>Divulgação</b><br>
                                                            0 Variavel
                                                        </td>
                                                        <td>
                                                            <b>População de Baixa Renda</b><br>
                                                            1.000Variavel
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
                                                            0 Variavel
                                                        </td>
                                                        <td>
                                                            <b>Promocional</b><br>
                                                            0 Variavel
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
                                                            1.000 Variavel
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr class="destacar">
                                            <td align="center">
                                                <b>Preço Unitário (R$)</b>
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
                                                            0,00Variavel
                                                        </td>
                                                        <td>
                                                            <b>Promocional</b><br>
                                                            0,00 Variavel
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
                                                            0,00 Variavel
                                                        </td>
                                                        <td>
                                                            <b>Promocional</b><br>
                                                            0,00 Variavel
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
                                                            0,00 Variavel
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
</template>
<script>
    import IdentificacaoProjeto from './IdentificacaoProjeto';
    // import TabelaPlanoDistribuicao from './TabelaPlanoDistribuicao';
    export default {
        name: 'PlanoDistribuicao',
        props: ['idPronac'],
        components: {
            IdentificacaoProjeto,
            // TabelaPlanoDistribuicao
        },
        data() {
            return {
                dados: {
                    type: Object,
                    default() {
                        return {};
                    },
                },
                informacoes: {},
                activeTab: -1,
            };
        },
        mounted() {
            if (typeof this.$route.params.idPronac !== 'undefined') {
                this.buscar_dados();
            }
        },
        watch: {
            dados(value) {
                this.informacoes = value.informacoes;
            },
        },
        methods: {
            buscar_dados() {
                const self = this;
                const idPronac = self.$route.params.idPronac;
                /* eslint-disable */
                $3.ajax({
                    url: '/projeto/plano-distribuicao-rest/index/idPronac/' + idPronac,
                }).done(function (response) {
                    self.dados = response.data;
                    // self.informacoes = response.data.informacoes;
                });
            },

            setActiveTab(index) {
                if (this.activeTab === index) {
                    this.activeTab = -1;
                } else {
                    this.activeTab = index;
                }
            },
        },
    }
</script>
