<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Carregando Relação de Pagamentos'"/>
        </div>
        <div v-else-if="dados">
            <v-data-table
                :pagination.sync="pagination"
                :headers="listagem"
                :items="indexItems"
                :rows-per-page-items="[10, 25, 50, {'text': 'Todos', value: -1}]"
                :expand="expand"
                item-key="id"
                class="elevation-1 container-fluid"
            >
                <template
                    slot="items"
                    slot-scope="props">
                    <tr @click="props.expanded = !props.expanded">
                        <td class="text-xs-center">{{ props.item.id + 1 }}</td>
                        <td class="text-xs-left"><b>{{ props.item.conteudo }}</b></td>
                    </tr>
                </template>
                <template slot="expand" slot-scope="props">
                    <v-data-table
                        :pagination.sync="pagination"
                        :headers="headers"
                        :items="dados"
                        :rows-per-page-items="[10, 25, 50, {'text': 'Todos', value: -1}]"
                        item-key="id"
                        class="elevation-1 container-fluid"
                    >
                        <template
                            slot="items"
                            slot-scope="props">
                            <td class="text-xs-left"><b>{{ props.item.Item }}</b></td>
                            <td
                                class="text-xs-center pl-5"
                                style="width: 200px">
                                {{ props.item.CNPJCPF | cnpjFilter }}
                            </td>
                            <td class="text-xs-left">{{ props.item.Fornecedor }}</td>
                            <td class="text-xs-left">{{ props.item.tbDocumento }}</td>
                            <td class="text-xs-right">{{ props.item.nrComprovante }}</td>
                            <td class="text-xs-center pl-5">{{ props.item.DtPagamento | formatarData }}</td>
                            <td class="text-xs-center pl-5">{{ props.item.DtEmissao | formatarData }}</td>
                            <td
                                class="text-xs-left"
                                v-html="props.item.tpFormaDePagamento"/>
                            <td class="text-xs-right">{{ props.item.nrDocumentoDePagamento }}</td>
                            <td class="text-xs-left">{{ props.item.dsJustificativa }}</td>
                            <td class="text-xs-right">{{ props.item.vlPagamento | filtroFormatarParaReal }}</td>
                            <td class="text-xs-left">
                                <v-btn
                                    :href="`/upload`+
                                        `/abrir`+
                                    `?id=${props.item.idArquivo}`"
                                    style="text-decoration: none"
                                    round
                                    small
                                >
                                    {{ props.item.nmArquivo }}
                                </v-btn>
                            </td>
                        </template>
                    </v-data-table>
                </template>
            </v-data-table>
            <v-data-table
                :pagination.sync="pagination"
                :headers="headers"
                :items="dados"
                :rows-per-page-items="[10, 25, 50, {'text': 'Todos', value: -1}]"
                item-key="id"
                class="elevation-1 container-fluid"
            >
                <template
                    slot="items"
                    slot-scope="props">
                    <td class="text-xs-left"><b>{{ props.item.Item }}</b></td>
                    <td
                        class="text-xs-center pl-5"
                        style="width: 200px">
                        {{ props.item.CNPJCPF | cnpjFilter }}
                    </td>
                    <td class="text-xs-left">{{ props.item.Fornecedor }}</td>
                    <td class="text-xs-left">{{ props.item.tbDocumento }}</td>
                    <td class="text-xs-right">{{ props.item.nrComprovante }}</td>
                    <td class="text-xs-center pl-5">{{ props.item.DtPagamento | formatarData }}</td>
                    <td class="text-xs-center pl-5">{{ props.item.DtEmissao | formatarData }}</td>
                    <td
                        class="text-xs-left"
                        v-html="props.item.tpFormaDePagamento"/>
                    <td class="text-xs-right">{{ props.item.nrDocumentoDePagamento }}</td>
                    <td class="text-xs-left">{{ props.item.dsJustificativa }}</td>
                    <td class="text-xs-right">{{ props.item.vlPagamento | filtroFormatarParaReal }}</td>
                    <td class="text-xs-left">
                        <v-btn
                            :href="`/upload`+
                                `/abrir`+
                            `?id=${props.item.idArquivo}`"
                            style="text-decoration: none"
                            round
                            small
                        >
                            {{ props.item.nmArquivo }}
                        </v-btn>
                    </td>
                </template>
            </v-data-table>
        </div>
    </div>
</template>
<script>

import { mapActions, mapGetters } from 'vuex';
import Carregando from '@/components/CarregandoVuetify';
import cnpjFilter from '@/filters/cnpj';
import { utils } from '@/mixins/utils';

export default {
    name: 'RelacaoPagamento',
    components: {
        Carregando,
    },
    filters: {
        cnpjFilter,
    },
    mixins: [utils],
    data() {
        return {
            search: '',
            pagination: {
                // sortBy: 'DtPagamento',
                // descending: true,
            },
            selected: [],
            dadosLista: [],
            loading: true,
            expand: false,
            listagem: [
                {
                    text: 'Nº',
                    align: 'center',
                    value: 'id',
                },
                {
                    text: 'Item',
                    align: 'left',
                    value: 'conteudo',
                },
            ],
            headers: [
                {
                    text: 'Item',
                    align: 'left',
                    value: 'Item',
                },
                {
                    text: 'CNPJ/CPF',
                    align: 'center',
                    value: 'CNPJCPF',
                },
                {
                    text: 'Fornecedor',
                    align: 'left',
                    value: 'Fornecedor',
                },
                {
                    text: 'Documento',
                    align: 'left',
                    value: 'tbDocumento',
                },
                {
                    text: 'Nº Comprovante',
                    align: 'right',
                    value: 'nrComprovante',
                },
                {
                    text: 'Dt. Pagamento',
                    align: 'center',
                    value: 'DtPagamento',
                },
                {
                    text: 'Dt. Emissao',
                    align: 'center',
                    value: 'DtEmissao',
                },
                {
                    text: 'Forma de Pagamento',
                    align: 'left',
                    value: 'tpFormaDePagamento',
                },
                {
                    text: 'Nº Doc. Pagamento',
                    align: 'right',
                    value: 'nrDocumentoDePagamento',
                },
                {
                    text: 'Justificativa',
                    align: 'left',
                    value: 'dsJustificativa',
                },
                {
                    text: 'Vl. Pagamento',
                    align: 'right',
                    value: 'vlPagamento',
                },
                {
                    text: 'Anexo',
                    align: 'left',
                    value: 'nmArquivo',
                },
            ],
        };
    },
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
            dados: 'prestacaoContas/relacaoPagamento',
        }),
        indexItems() {
            const currentItems = this.montaArray();
            return currentItems.map((item, index) => ({
                id: index,
                ...item,
                conteudo: item,
            }));
        },
    },
    watch: {
        dados() {
            this.loading = false;
        },
    },
    mounted() {
        if (typeof this.dadosProjeto.idPronac !== 'undefined') {
            this.buscarRelacaoPagamento(this.dadosProjeto.idPronac);
        }
    },
    methods: {
        ...mapActions({
            buscarRelacaoPagamento: 'prestacaoContas/buscarRelacaoPagamento',
        }),
        montaArray() {
            let dadosListagem = [];
            let arrayTeste = this.dados;
            arrayTeste = arrayTeste.filter(function(element, i, array) {
                return array.map(x => x['Item']).indexOf(element['Item']) === i;
            })

            arrayTeste.forEach(element => {
                dadosListagem.push(element['Item']);
            });

            return dadosListagem;
        },
    },
};
</script>
