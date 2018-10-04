<template>
    <div id="conteudo">
        <IdentificacaoProjeto
            :pronac="informacoes.Pronac"
            :nomeProjeto="informacoes.NomeProjeto">
        </IdentificacaoProjeto>

        <table class="tabela">
            <tbody v-for="(dado, index) in dados">
            <tr>
                <td align="left">
                    <input  type="button"
                            class="btn_adicionar"
                            id="objetivos"
                            @click="setActiveTab(1)">
                    <b v-html="">
                        <b>{{ dado.Produto }}</b>
                            <span class="red">(produto principal)</span>
                        </b>
                </td>
            </tr>
            <tr class="199447 sumir" align="left">
                <td>
                    <table class="tabela">
                        <tbody><tr>
                            <td colspan="2" align="center" class="destacar">
                                <b>Produto</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" style="font-size: 11pt">
                                <b>Exposição de Artes</b>
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
                            <td align="center">Artes Visuais</td>
                            <td align="center">Fotografia</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <table class="tabela">
                                    <tbody><tr class="destacar">
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
                                                <tbody><tr>
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
                                                </tbody></table>
                                        </td>
                                        <td>
                                            <table class="tabela">
                                                <tbody><tr>
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
                                                <tbody><tr>
                                                    <td>
                                                        <b>Normal</b><br>
                                                        0,00Variavel
                                                    </td>
                                                    <td>
                                                        <b>Promocional</b><br>
                                                        0,00 Variavel
                                                    </td>
                                                </tr>
                                                </tbody></table>
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

        <!--<table>-->
            <!--<thead>-->
            <!--<tr class="destacar">-->
                <!--<th class="center">N°</th>-->
                <!--<th class="center">CLASSIFICA&ccedil;&atilde;O</th>-->
                <!--<th class="center">DATA</th>-->
                <!--<th class="center">TIPO DE DOCUMENTO</th>-->
                <!--<th class="center">DOCUMENTO</th>-->
            <!--</tr>-->
            <!--</thead>-->
            <!--<tbody v-for="(dado, index) in dados.documentos" :key="index">-->
            <!--<tr>-->
                <!--<td class="center">{{ index + 1 }}</td>-->
                <!--<td class="center">{{ dado.Anexado }}</td>-->
                <!--<td class="center">{{ dado.Data }}</td>-->
                <!--<td class="center">{{ dado.Descricao }}</td>-->
                <!--<td class="center">-->
                <!--<a class="" :href="`/consultardadosprojeto/abrir-documentos-anexados?id=${dado.idArquivo}&tipo=${dado.AgenteDoc}&idPronac=${dados.informacoes.idPronac}`"-->
                   <!--target="_blank"-->
                    <!--data-position="top" data-delay="50" data-tooltip="Visualizar">-->
                    <!--{{ dado.NoArquivo }}-->
                <!--</a>-->
                <!--</td>-->
            <!--</tr>-->
            <!--</tbody>-->
        <!--</table>-->

        <!--<TabelaPlanoDistribuicao  dadoComplementar="Outras Informa&ccedil;&otilde;es"-->
        <!--:dsDadoComplementar="dados.NomeProjeto">-->
        <!--</TabelaPlanoDistribuicao>-->
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
