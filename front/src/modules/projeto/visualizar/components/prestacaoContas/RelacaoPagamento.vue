<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Carregando Relação de Pagamentos'"/>
        </div>
        <div v-else-if="dados">
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
                    <td class="text-xs-left">{{ props.item.Fornecedor }}</td>
                    <td class="text-xs-left">{{ props.item.tbDocumento }}</td>
                    <td class="text-xs-center pl-5">{{ props.item.DtPagamento | formatarData }}</td>
                    <td
                        class="text-xs-left"
                        v-html="props.item.tpFormaDePagamento"/>
                    <td class="text-xs-right">{{ props.item.vlPagamento | filtroFormatarParaReal }}</td>
                    <td class="text-xs-left">
                        <a
                            :href="`/upload`+
                                `/abrir`+
                            `?id=${props.item.idArquivo}`"
                        >
                            {{ props.item.nmArquivo }}
                        </a>
                    </td>
                    <td class="text-xs-center">
                        <v-tooltip bottom>
                            <v-btn
                                slot="activator"
                                flat
                                icon
                                @click="showItem(props.item)"
                            >
                                <v-icon>visibility</v-icon>
                            </v-btn>
                            <span>Visualizar Pagamento</span>
                        </v-tooltip>
                    </td>
                </template>
            </v-data-table>
            <v-dialog v-model="dialog">
                <v-card>
                    <v-card-text v-if="dadosPagamento">
                        <v-container
                            grid-list-md
                            text-xs-left>
                            <div>
                                <v-layout
                                    justify-space-around
                                    row
                                    wrap>
                                    <v-flex
                                        lg12
                                        dark
                                        class="text-xs-left">
                                        <b><h4>DADOS DO PAGAMENTO</h4></b>
                                        <v-divider class="pb-2"/>
                                    </v-flex>
                                    <v-flex>
                                        <b>Arquivo</b><br>
                                        <a
                                            v-if="dadosPagamento.idArquivo"
                                            :href="`/upload/abrir?id=${dadosPagamento.idArquivo}`"
                                        >
                                            <span v-html="dadosPagamento.nmArquivo"/>
                                        </a>
                                        <span v-else>
                                            -
                                        </span>
                                    </v-flex>
                                    <v-flex>
                                        <b class="pl-4">Data Pagamento</b>
                                        <p class="pl-4" v-if="dadosPagamento.DtPagamento">
                                            {{ dadosPagamento.DtPagamento | formatarData }}
                                        </p>
                                        <p v-else>
                                            -
                                        </p>
                                    </v-flex>
                                    <v-flex>
                                        <b>Data Emissão</b>
                                        <p v-if="dadosPagamento.DtPagamento">
                                            {{ dadosPagamento.DtEmissao | formatarData }}
                                        </p>
                                        <p v-else>
                                            -
                                        </p>
                                    </v-flex>
                                    <v-flex>
                                        <b>Valor Pagamento</b>
                                        <p v-if="dadosPagamento.vlPagamento">
                                            R$ {{ dadosPagamento.vlPagamento | filtroFormatarParaReal }}
                                        </p>
                                        <p v-else>
                                            -
                                        </p>
                                    </v-flex>
                                </v-layout>
                                <v-layout
                                    row
                                    justify-space-between>
                                    <v-flex xs6>
                                        <b>Fornecedor</b>
                                        <p
                                            v-if="dadosPagamento.Fornecedor"
                                            v-html="dadosPagamento.Fornecedor"/>
                                        <p v-else>
                                            -
                                        </p>
                                    </v-flex>
                                    <v-flex xs6>
                                        <b>CNPJ/CPF</b>
                                        <p v-if="dadosPagamento.CNPJCPF">
                                            {{ dadosPagamento.CNPJCPF | cnpjFilter }}
                                        </p>
                                        <p v-else>
                                            -
                                        </p>
                                    </v-flex>
                                </v-layout>
                                <v-layout
                                    row
                                    justify-space-between>
                                    <v-flex xs6>
                                        <b>Documento</b>
                                        <p
                                            v-if="dadosPagamento.tbDocumento"
                                            v-html="dadosPagamento.tbDocumento"/>
                                    </v-flex>
                                    <v-flex xs6>
                                        <b>Nº Documento</b>
                                        <p v-if="dadosPagamento.nrComprovante">
                                            {{ dadosPagamento.nrComprovante }}
                                        </p>
                                        <p v-else>
                                            -
                                        </p>
                                    </v-flex>
                                </v-layout>
                                <v-layout
                                    row
                                    justify-space-between>
                                    <v-flex xs6>
                                        <b>Forma de Pagamento</b>
                                        <p
                                            v-if="dadosPagamento.tpFormaDePagamento"
                                            v-html="dadosPagamento.tpFormaDePagamento"/>
                                    </v-flex>
                                    <v-flex xs6>
                                        <b>Nº Documento Pagamento</b>
                                        <p v-if="dadosPagamento.nrDocumentoDePagamento">
                                            {{ dadosPagamento.nrDocumentoDePagamento }}
                                        </p>
                                        <p v-else>
                                            -
                                        </p>
                                    </v-flex>
                                </v-layout>
                                <v-layout
                                    row
                                    justify-space-between>
                                    <v-flex>
                                        <b>Justificativa</b>
                                        <p
                                            v-if="dadosPagamento.dsJustificativa !== ' '"
                                            v-html="dadosPagamento.dsJustificativa"/>
                                        <p v-else>
                                            -
                                        </p>
                                    </v-flex>
                                </v-layout>
                            </div>
                        </v-container>
                    </v-card-text>
                    <v-divider/>
                    <v-card-actions>
                        <v-spacer/>
                        <v-btn
                            color="red"
                            flat
                            @click="dialog = false"
                        >
                            Fechar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
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
            dadosPagamento: {},
            loading: true,
            dialog: false,
            headers: [
                {
                    text: 'Item',
                    align: 'left',
                    value: 'Item',
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
                    text: 'Dt. Pagamento',
                    align: 'center',
                    value: 'DtPagamento',
                },
                {
                    text: 'Forma de Pagamento',
                    align: 'left',
                    value: 'tpFormaDePagamento',
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
                {
                    text: 'VISUALIZAR',
                    align: 'center',
                    value: 'item',
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
        showItem(item) {
            this.dadosPagamento = item;
            this.dialog = true;
        },
    },
};
</script>
