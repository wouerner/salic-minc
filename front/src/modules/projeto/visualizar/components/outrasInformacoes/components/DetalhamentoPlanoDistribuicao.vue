<template>
    <v-expansion-panel popout>
        <v-expansion-panel-content
            class="elevation-1"
            v-for="(detalhamento, index) of detalhamentos"
            :key="index"
            >
            <v-layout slot="header" class="black--text">
                <v-icon class="mr-3 black--text">place</v-icon>
                <span>Detalhamento - {{detalhamento[0].DescricaoUf}} - {{detalhamento[0].DescricaoMunicipio}}</span>
            </v-layout>
            <v-data-table
                    :headers="headers"
                    :items="detalhamento"
                    class="elevation-1 container-fluid"
                    rows-per-page-text="Items por Página"
                    no-data-text="Nenhum dado encontrado"
            >
                <template slot="items" slot-scope="props">
                    <td class="text-xs-left">{{props.item.dsProduto}}</td>
                    <td class="text-xs-right">{{ props.item.qtExemplares }}</td>

                    <td class="text-xs-right">{{ parseInt(props.item.qtGratuitaDivulgacao) +
                        parseInt(props.item.qtGratuitaPatrocinador) + parseInt(props.item.qtGratuitaPopulacao) }}
                    </td>

                    <td class="text-xs-right">{{ props.item.qtPopularIntegral }}</td>
                    <td class="text-xs-right">{{ props.item.qtPopularParcial }}</td>
                    <td class="text-xs-right">{{ props.item.vlUnitarioPopularIntegral }}</td>

                    <td class="text-xs-right">{{ props.item.qtProponenteIntegral }}</td>
                    <td class="text-xs-right">{{ props.item.qtProponenteParcial }}</td>
                    <td class="text-xs-right">{{ props.item.vlUnitarioProponenteIntegral }}</td>

                    <td class="text-xs-right">{{ props.item.vlReceitaPrevista }}</td>
                </template>
                <template slot="pageText" slot-scope="props">
                    Items {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                </template>
            </v-data-table>
        </v-expansion-panel-content>
    </v-expansion-panel>
</template>
<script>
export default {
    name: 'DetalhamentoPlanoDistribuicao',
    props: ['arrayDetalhamentos'],
    data() {
        return {
            detalhamentos: [],
            search: '',
            pagination: {
                sortBy: 'fat',
            },
            selected: [],
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
                    align: 'center',
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
                    align: 'center',
                    value: 'vlUnitarioProponenteIntegral',
                },
                {
                    text: 'RECEITA PREVISTA',
                    align: 'center',
                    value: 'vlReceitaPrevista',
                },
            ],
        };
    },
    watch: {
        arrayDetalhamentos(value) {
            this.detalhamentos = this.montarVisualizacao(value);
        },
    },
    mounted() {
        if (typeof this.arrayDetalhamentos !== 'undefined') {
            this.detalhamentos = this.montarVisualizacao(this.arrayDetalhamentos);
        }
    },
    methods: {
        montarVisualizacao(detalhamentos) {
            const novoDetalhamento = {};
            let i = 0;
            let idMunicipio = '';

            detalhamentos.forEach((element) => {
                if (element.idMunicipio !== idMunicipio) {
                    novoDetalhamento[element.idMunicipio] = [];
                    i = 0;
                    idMunicipio = element.idMunicipio;
                }

                novoDetalhamento[element.idMunicipio][i] = element;

                i += 1;
            });

            return novoDetalhamento;
        },
    },
}
</script>

