<template>
    <!-- <div id="conteudo">
        <div v-if="loading">
            <Carregando :text="'Carregando Plano de Distribuicao'"></Carregando>
        </div>
        <div v-else>
            <PropostaPlanoDistribuicao
                    :arrayProdutos="dadosIn2017.planodistribuicaoproduto"
                    :arrayDetalhamentos="dadosIn2017.tbdetalhaplanodistribuicao">
            </PropostaPlanoDistribuicao>
        </div>
    </div> -->
    <v-expansion-panel popout>
        <v-expansion-panel-content
            class="elevation-1"
            v-for="(produto, index) of dadosIn2017.planodistribuicaoproduto"
            :key="index"
            >
                <v-layout slot="header" class="green--text">
                    <v-icon class="mr-3 green--text">subject</v-icon>
                    <span>{{produto.Produto}}</span>
                </v-layout>
                <v-container fluid>
                    <v-card class="elevation-2" color="grey lighten-4">
                        <v-card-text class="pl-5">
                            <v-layout justify-space-around row wrap>
                                <v-flex s12 m6 lg2 offset-lg1>
                                    <b>&Aacute;REA</b>
                                    <p>{{produto.DescricaoArea}}</p>
                                </v-flex>
                                <v-flex s12 m6 lg3>
                                    <b>SEGMENTO</b>
                                    <p>{{produto.DescricaoSegmento}}</p>
                                </v-flex>
                                <v-flex s12 m6 lg3>
                                    <b>PRINCIPAL</b>
                                    <P>{{label_sim_ou_nao(produto.stPrincipal)}}</P>
                                </v-flex>
                                <v-flex s12 m6 lg3>
                                    <b>CANAL ABERTO?</b>
                                    <P>{{label_sim_ou_nao(produto.canalAberto)}}</P>
                                </v-flex>
                            </v-layout>

                            <v-layout justify-space-around row wrap>
                                <v-flex lg12 class="text-xs-center">
                                <b>QUANTIDADE DISTRIBUICAO GRATUITA</b>
                                </v-flex>
                                <v-flex s6 m6 lg3 offset-lg1>
                                    <p>
                                        <b>Divulga&ccedil;&atilde;o</b><br>
                                        {{produto.QtdeProponente}}
                                    </p>
                                </v-flex>
                                <v-flex s12 m6 lg4>
                                    <p>
                                        <b>Patrocinador</b><br>
                                        {{produto.QtdePatrocinador}}
                                    </p>
                                </v-flex>
                                <v-flex s12 m6 offset-xlg10>
                                    <p>
                                        <b>Popula&ccedil;&atilde;o</b><br>
                                        {{produto.QtdeOutros}}
                                    </p>
                                </v-flex>
                            </v-layout>

                            <v-layout justify-space-around row wrap>
                                <v-flex lg12 class="text-xs-center">
                                <b>PRE&Ccedil;O POPULAR</b>
                                </v-flex>
                                <v-flex s6 m6 lg3 offset-lg1>
                                    <p>
                                        <b>Quantidade Inteira</b><br>
                                        {{produto.QtdeVendaPopularNormal}}
                                    </p>
                                </v-flex>
                                <v-flex s12 m6 lg4>
                                    <p>
                                        <b>Quantidade Meia</b><br>
                                        {{produto.QtdeVendaPopularPromocional}}
                                    </p>
                                </v-flex>
                                <v-flex s12 m6 lg4>
                                    <p>
                                        <b>Valor m&eacute;dio</b><br>
                                        {{produto.ReceitaPopularNormal}}
                                    </p>
                                </v-flex>
                            </v-layout>

                            <v-layout justify-space-around row wrap>
                                <v-flex lg12 class="text-xs-center">
                                <b>PROPONENTE</b>
                                </v-flex>
                                <v-flex s6 m6 lg3 offset-lg1>
                                    <p>
                                        <b>Quantidade Inteira</b><br>
                                        {{produto.QtdeVendaNormal}}
                                    </p>
                                </v-flex>
                                <v-flex s12 m6 lg4>
                                    <p>
                                        <b>Quantidade Meia</b><br>
                                        {{produto.QtdeVendaPromocional}}
                                    </p>
                                </v-flex>
                                <v-flex s12 m6 lg4>
                                    <p>
                                        <b>Valor m&eacute;dio</b><br>
                                        {{produto.PrecoUnitarioNormal}}
                                    </p>
                                </v-flex>
                            </v-layout>

                            <v-layout justify-space-around row wrap>
                                <v-flex lg5 class="text-xs-center">
                                <b>QUANTIDADE TOTAL</b>
                                </v-flex>
                                <v-flex lg5 class="text-xs-center">
                                <b>RECEITA PREVISTA TOTAL</b>
                                </v-flex>
                                <v-flex s3 m6 lg5 offset-lg1>
                                    <p>
                                        <b>Quantidade Inteira</b><br>
                                        {{produto.QtdeProduzida}}
                                    </p>
                                </v-flex>
                                <v-flex s3 m6 lg6>
                                    <p>
                                        <b>Quantidade Meia</b><br>
                                        {{produto.Receita}}
                                    </p>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-expansion-panel popout>
                            <v-expansion-panel-content
                                class="elevation-1"
                                >
                                <v-layout slot="header" class="black--text">
                                    <v-icon class="mr-3 black--text">place</v-icon>
                                    <span>Detalhamento - {{dadosIn2017.tbdetalhaplanodistribuicao[index].DescricaoUf}} - {{dadosIn2017.tbdetalhaplanodistribuicao[index].DescricaoMunicipio}}</span>
                                </v-layout>
                                <v-data-table
                                        :headers="headers"
                                        :items="dadosIn2017.tbdetalhaplanodistribuicao"
                                        class="elevation-1 container-fluid"
                                        rows-per-page-text="Items por Página"
                                        no-data-text="Nenhum dado encontrado"
                                >
                                    <template slot="items" slot-scope="props">
                                        <td class="text-xs-left">{{props.item.dsProduto}}</td>
                                        <td class="text-xs-left">{{ props.item.qtExemplares }}</td>

                                        <td class="text-xs-left">{{ parseInt(props.item.qtGratuitaDivulgacao) +
                                            parseInt(props.item.qtGratuitaPatrocinador) + parseInt(props.item.qtGratuitaPopulacao) }}
                                        </td>

                                        <td class="text-xs-left">{{ props.item.qtPopularIntegral }}</td>
                                        <td class="text-xs-left">{{ props.item.qtPopularParcial }}</td>
                                        <td class="text-xs-left">{{ props.item.vlUnitarioPopularIntegral }}</td>

                                        <td class="text-xs-left">{{ props.item.qtProponenteIntegral }}</td>
                                        <td class="text-xs-left">{{ props.item.qtProponenteParcial }}</td>
                                        <td class="text-xs-left">{{ props.item.vlUnitarioProponenteIntegral }}</td>

                                        <td class="text-xs-left">{{ props.item.vlReceitaPrevista }}</td>
                                    </template>
                                    <template slot="pageText" slot-scope="props">
                                        Items {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                                    </template>
                                </v-data-table>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                    </v-card>
            </v-container>
        </v-expansion-panel-content>
    </v-expansion-panel>
</template>
<script>
import { mapGetters, mapActions } from 'vuex';
import Carregando from '@/components/Carregando';
import PropostaPlanoDistribuicao from '@/modules/proposta/visualizar/components/PropostaPlanoDistribuicao';

export default {
    name: 'PlanoDistribuicaoIn2017',
    props: ['idPronac'],
    data() {
        return {
            search: '',
            pagination: {
                sortBy: 'fat',
            },
            selected: [],
            loading: true,
            headers: [
                {
                    text: 'CATEGORIA',
                    align: 'left',
                    value: 'dsProduto',
                },
                {
                    text: 'QTD.',
                    align: 'center',
                    value: 'qtExemplares',
                },
                {
                    text: 'DIST. GRATUITA',
                    align: 'center',
                    // value: `${qtGratuitaDivulgacao}+${qtGratuitaPatrocinador}+${qtGratuitaPopulacao}`,
                    value: 'qtGratuitaDivulgacao + qtGratuitaPatrocinador + qtGratuitaPopulacao',
                },
                {
                    text: 'QTD. INTEIRA',
                    align: 'center',
                    value: 'qtPopularIntegral',
                },
                {
                    text: 'QTD. MEIA',
                    align: 'center',
                    value: 'qtPopularParcial',
                },
                {
                    text: 'PREÇO UNITÁRIO',
                    align: 'left',
                    value: 'vlUnitarioPopularIntegral',
                },
                {
                    text: 'QTD. INTEIRA',
                    align: 'center',
                    value: 'qtProponenteIntegral',
                },
                {
                    text: 'QTD. MEIA',
                    align: 'center',
                    value: 'qtProponenteParcial',
                },
                {
                    text: 'PREÇO UNITÁRIO',
                    align: 'left',
                    value: 'vlUnitarioProponenteIntegral',
                },
                {
                    text: 'RECEITA PREVISTA',
                    align: 'left',
                    value: 'vlReceitaPrevista',
                },
            ],
        };
    },
    components: {
        Carregando,
        PropostaPlanoDistribuicao,
    },
    mounted() {
        if (typeof this.dadosProjeto.idPreProjeto !== 'undefined') {
            this.buscarPlanoDistribuicaoIn2017(this.dadosProjeto.idPreProjeto);
        }
    },
    watch: {
        dadosIn2017() {
            this.loading = false;
        },
    },
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
            dadosIn2017: 'projeto/planoDistribuicaoIn2017',
        }),
    },
    methods: {
        ...mapActions({
            buscarPlanoDistribuicaoIn2017: 'projeto/buscarPlanoDistribuicaoIn2017',
        }),
        label_sim_ou_nao(valor) {
            if (valor === 1) {
                return 'Sim';
            }
            return 'N\xE3o';
        },
    },
};
</script>
