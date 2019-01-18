<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Conciliação Bancária'"/>
        </div>
        <div v-else>
            <v-card>
                <div v-if="Object.keys(dadosConciliacao).length > 0">
                    <v-container fluid>
                        <FiltroData
                            :text="'Escolha a Data:'"
                            @eventoFiltrarData="filtrarData"
                        />
                    </v-container>
                </div>
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
                            <td class="text-xs-center pl-5">
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
                    align: 'center',
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
