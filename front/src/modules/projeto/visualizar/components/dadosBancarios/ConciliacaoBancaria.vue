<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Conciliação Bancária'"/>
        </div>
        <div v-else>
            <v-card>
                <v-container fluid>
                    <FiltroData
                        :text="'Escolha a Data:'"
                        @eventoFiltrarData="filtrarData"
                    />
                </v-container>
                <v-card id="geraPdf">
                    <v-data-table
                        :headers="headers"
                        :items="dadosConciliacao"
                        :rows-per-page-items="[10, 25, 50, 100, {'text': 'Todos', value: -1}]"
                        class="elevation-1 container-fluid"
                    >
                        <template
                            slot="items"
                            slot-scope="props">
                            <td class="text-xs-left">
                                {{ props.item.ItemOrcamentario }}
                            </td>
                            <td
                                class="text-xs-left"
                                style="width: 200px">
                                {{ props.item.CNPJCPF | cnpjFilter }}
                            </td>
                            <td class="text-xs-left">
                                {{ props.item.Fornecedor }}
                            </td>
                            <td class="text-xs-right">
                                {{ props.item.nrDocumentoDePagamento }}
                            </td>
                            <td class="text-xs-right">
                                {{ props.item.dtPagamento | formatarData }}
                            </td>
                            <td class="text-xs-right font-weight-bold">
                                {{ props.item.vlPagamento | filtroFormatarParaReal }}
                            </td>
                            <td class="text-xs-left">{{ props.item.dsLancamento }}</td>
                            <td
                                v-if="props.item.vlDebitado"
                                class="text-xs-right font-weight-bold"
                            >
                                {{ props.item.vlDebitado | filtroFormatarParaReal }}
                            </td>
                            <td
                                v-else
                                class="text-xs-right font-weight-bold">
                                {{ '000' | filtroFormatarParaReal }}
                            </td>

                            <td
                                v-if="props.item.vlDiferenca"
                                class="text-xs-right font-weight-bold red--text"
                            >
                                {{ props.item.vlDiferenca | filtroFormatarParaReal }}
                            </td>
                            <td
                                v-else
                                class="text-xs-right font-weight-bold">
                                {{ '000' | filtroFormatarParaReal }}
                            </td>
                        </template>
                        <template
                            slot="pageText"
                            slot-scope="props">
                            Items {{ props.pageStart }}
                            - {{ props.pageStop }}
                            de {{ props.itemsLength }}
                        </template>
                    </v-data-table>
                </v-card>
            </v-card>
            <div
                v-if="Object.keys(dadosConciliacao).length > 0"
                class="text-xs-center">
                <v-btn
                    round
                    dark
                    target="_blank"
                    @click="createPDF"
                >
                    Imprimir
                    <v-icon
                        right
                        dark>local_printshop
                    </v-icon>
                </v-btn>
            </div>
        </div>
    </div>
</template>
<script>

import { mapActions, mapGetters } from 'vuex';
import Carregando from '@/components/CarregandoVuetify';
import cnpjFilter from '@/filters/cnpj';
import { utils } from '@/mixins/utils';
import FiltroData from './components/FiltroData';

export default {
    name: 'ConciliacaoBancaria',
    components: {
        Carregando,
        FiltroData,
    },
    filters: {
        cnpjFilter,
    },
    mixins: [utils],
    data() {
        return {
            name: '',
            search: '',
            pagination: {
                sortBy: 'fat',
            },
            selected: [],
            loading: true,
            headers: [
                {
                    text: 'ITEM ORÇAMENTÁRIO',
                    align: 'left',
                    value: 'ItemOrcamentario',
                },
                {
                    text: 'CNPJ / CPF',
                    align: 'left',
                    value: 'CNPJCPF',
                },
                {
                    text: 'FORNECEDOR',
                    align: 'left',
                    value: 'Fornecedor',
                },
                {
                    text: 'NÚMERO',
                    align: 'left',
                    value: 'nrDocumentoDePagamento',
                },
                {
                    text: 'DATA',
                    align: 'left',
                    value: 'dtPagamento',
                },
                {
                    text: 'VL. COMPROVADO',
                    align: 'left',
                    value: 'vlPagamento',
                },
                {
                    text: 'LANÇAMENTO',
                    align: 'left',
                    value: 'dsLancamento',
                },
                {
                    text: 'VL. DEBITADO',
                    align: 'left',
                    value: 'vlDebitado',
                },
                {
                    text: 'VL. DIFERENÇA',
                    align: 'left',
                    value: 'vlDiferenca',
                },
            ],
        };
    },
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
            dadosConciliacao: 'projeto/conciliacaoBancaria',
        }),
    },
    mounted() {
        if (typeof this.dadosProjeto.idPronac !== 'undefined') {
            const params = {
                idPronac: this.dadosProjeto.idPronac,
                dtInicio: '',
                dtFim: '',
            };
            this.buscarConciliacaoBancaria(params);
            this.loading = false;
        }
    },
    methods: {
        ...mapActions({
            buscarConciliacaoBancaria: 'projeto/buscarConciliacaoBancaria',
        }),
        filtrarData(response) {
            const params = {
                idPronac: this.dadosProjeto.idPronac,
                dtInicio: response.dtInicio,
                dtFim: response.dtFim,
            };
            this.buscarConciliacaoBancaria(params);
        },
        createPDF() {
            // var imgData = 'data:image/jpeg;base64,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';
            const pdf = new jsPDF('p', 'pt', 'a4');
            // pdf.addImage(imgData, 'JPEG', 80, 10, 90, 70);
            var options = {
                pagesplit: true,
            };
            pdf.addHTML($('#geraPdf'), options, () => {
                pdf.save('web.pdf');
            });
            // const doc = new jsPDF('p', 'pt', 'letter');
            // doc.addHTML($('#geraPdf'), () => {
            //     doc.save('teste.pdf');
            // });
        },
        // download() {
        //     const pdfName = 'test';
        //     const doc = new jsPDF();
        //     doc.text(this.name, 10, 10);
        //     doc.save(`${pdfName}.pdf`);
        // },
    },
};
</script>
