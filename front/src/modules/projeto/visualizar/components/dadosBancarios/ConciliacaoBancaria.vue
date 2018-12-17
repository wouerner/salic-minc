// <template>
//     <div>
//         <div v-if="loading">
//             <Carregando :text="'Conciliação Bancária'"></Carregando>
//         </div>
//         <div v-else>
//             <v-data-table
//                     :headers="headers"
//                     :items="dadosConciliacao"
//                     class="elevation-1 container-fluid"
//                     rows-per-page-text="Items por Página"
//                     no-data-text="Nenhum dado encontrado"
//                     :rows-per-page-items="[10, 25, 50, 100, {'text': 'Todos', value: -1}]"
//             >
//                 <template slot="items" slot-scope="props">
//                     <td class="text-xs-left">{{ props.item.ItemOrcamentario }}</td>
//                     <td class="text-xs-left" style="width: 200px">{{ props.item.CNPJCPF | cnpjFilter }}</td>
//                     <td class="text-xs-left">{{ props.item.Fornecedor }}</td>
//                     <td class="text-xs-right">{{ props.item.nrDocumentoDePagamento }}</td>
//                     <td class="text-xs-right">{{ props.item.dtPagamento | FormatarData }}</td>
//                     <td class="text-xs-right font-weight-bold">
//                         {{ props.item.vlPagamento | filtroFormatarParaReal }}
//                     </td>
//                     <td class="text-xs-left">{{ props.item.dsLancamento }}</td>
//                     <td class="text-xs-right font-weight-bold"
//                         v-if="props.item.vlDebitado"
//                     >
//                         {{ props.item.vlDebitado | filtroFormatarParaReal }}
//                     </td>
//                     <td class="text-xs-right font-weight-bold" v-else>
//                         {{ '000' | filtroFormatarParaReal}}
//                     </td>

//                     <td class="text-xs-right font-weight-bold red--text"
//                         v-if="props.item.vlDiferenca"
//                     >
//                         {{ props.item.vlDiferenca | filtroFormatarParaReal }}
//                     </td>
//                     <td class="text-xs-right font-weight-bold" v-else>
//                         {{ '000' | filtroFormatarParaReal}}
//                     </td>
//                 </template>
//                 <template slot="pageText" slot-scope="props">
//                     Items {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
//                 </template>
//                 <!--<form target="_blank" class="form" name="formImpressao" id="formImpressao" method="post" action='<?php echo $this->url(array('controller' => 'consultardadosprojeto', 'action' => 'imprimir-conciliacao-bancaria')).'?pag='.$this->paginacao['pag'].'&qtde='.$this->paginacao['qtde'].'&dtLancamento='.$this->dtLancamento.'&dtLancamentoFim='.$this->dtLancamentoFim.'&idPronac='.$this->idPronac.'&campo='.$this->paginacao['campo'].'&ordem='.$this->paginacao['novaOrdem'].'&tpConta='.$this->tpConta;?>'>-->
//                 <!--</form>-->
//                 <!--http://local.salic/consultardadosprojeto/imprimir-conciliacao-bancaria? pag=1&qtde=10&dtLancamento=&dtLancamentoFim=&idPronac=155263&campo=&ordem=ASC&tpConta=-->
//             </v-data-table>
//             <div class="text-xs-center">
//                 <v-btn round
//                        dark
//                        target="_blank"
//                        :href="`/consultardadosprojeto/imprimir-conciliacao-bancaria?&idPronac=${dadosProjeto.idPronac}`"
//                 >
//                     Imprimir
//                     <v-icon right dark>local_printshop</v-icon>
//                 </v-btn>
//             </div>
//             <PrintableDataTable v-bind="$data"></PrintableDataTable>
//         </div>
//     </div>
// </template>
// <script>

//     import { mapActions, mapGetters } from 'vuex';
//     import Carregando from '@/components/CarregandoVuetify';
//     import moment from 'moment';
//     import cnpjFilter from '@/filters/cnpj';
//     import planilhas from '@/mixins/planilhas';
//     import PrintableDataTable from './components/PrintableDataTable';

//     export default {
//         name: 'ConciliacaoBancaria',
//         data() {
//             return {

//                 tblClass: 'table-bordered',
//                 pageSizeOptions: [5, 10, 15, 20, 25],

//                 search: '',
//                 pagination: {
//                     sortBy: 'fat',
//                 },
//                 selected: [],
//                 loading: true,
//                 headers: [
//                     {
//                         text: 'ITEM ORÇAMENTÁRIO',
//                         align: 'left',
//                         value: 'ItemOrcamentario',
//                     },
//                     {
//                         text: 'CNPJ / CPF',
//                         align: 'left',
//                         value: 'CNPJCPF',
//                     },
//                     {
//                         text: 'FORNECEDOR',
//                         align: 'left',
//                         value: 'Fornecedor',
//                     },
//                     {
//                         text: 'NÚMERO',
//                         align: 'left',
//                         value: 'nrDocumentoDePagamento',
//                     },
//                     {
//                         text: 'DATA',
//                         align: 'left',
//                         value: 'dtPagamento',
//                     },
//                     {
//                         text: 'VL. COMPROVADO',
//                         align: 'left',
//                         value: 'vlPagamento',
//                     },
//                     {
//                         text: 'LANÇAMENTO',
//                         align: 'left',
//                         value: 'dsLancamento',
//                     },
//                     {
//                         text: 'VL. DEBITADO',
//                         align: 'left',
//                         value: 'vlDebitado',
//                     },
//                     {
//                         text: 'VL. DIFERENÇA',
//                         align: 'left',
//                         value: 'vlDiferenca',
//                     },
//                 ],
//             };
//         },
//         mixins: [planilhas],
//         components: {
//             Carregando,
//             PrintableDataTable,
//         },
//         mounted() {
//             if (typeof this.dadosProjeto.idPronac !== 'undefined') {
//                 this.buscarConciliacaoBancaria(this.dadosProjeto.idPronac);
//                 this.loading = false;
//             }
//         },
//         filters: {
//             FormatarData(date) {
//                 if (date.length === 0) {
//                     return '-';
//                 }
//                 return moment(date).format('DD/MM/YYYY');
//             },
//             cnpjFilter,
//         },
//         computed: {
//             ...mapGetters({
//                 dadosProjeto: 'projeto/projeto',
//                 dadosConciliacao: 'projeto/conciliacaoBancaria',
//             }),
//         },
//         methods: {
//             ...mapActions({
//                 buscarConciliacaoBancaria: 'projeto/buscarConciliacaoBancaria',
//             }),
//         },
//     };
// </script>

