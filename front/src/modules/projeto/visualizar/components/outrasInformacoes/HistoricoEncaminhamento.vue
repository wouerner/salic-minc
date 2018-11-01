<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Carregando Certidoes Negativas'"></Carregando>
        </div>
        <div v-else-if="dados.Encaminhamentos">
            <IdentificacaoProjeto :pronac="dadosProjeto.Pronac"
                                  :nomeProjeto="dadosProjeto.NomeProjeto">
            </IdentificacaoProjeto>
           <v-data-table
                    :headers="headers"
                    :items="dados.Encaminhamentos"
                    class="elevation-1 container-fluid"
                    rows-per-page-text="Itens por Página"
           >
                <template slot="items" slot-scope="props">
                    <td style="width: 190px">{{ props.item.Produto }}</td>
                    <td style="width: 50px">{{ props.item.Unidade }}</td>
                    <td style="width: 700px" v-html="props.item.Observacao"></td>
                    <td style="width: 190px">{{ props.item.DtEnvio }}</td>
                    <td style="width: 190px">{{ props.item.DtRetorno }}</td>
                    <td>{{ props.item.qtDias }}</td>
                </template>
                <template slot="pageText" slot-scope="props">
                    Itens {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                </template>
            </v-data-table>
        </div>
    </div>
</template>
<script>
    import { mapActions, mapGetters } from 'vuex';
    import Carregando from '@/components/Carregando';
    import IdentificacaoProjeto from './IdentificacaoProjeto';

    export default {
        name: 'HistoricoEncaminhamento',
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
                        text: 'PRODUTO',
                        align: 'left',
                        value: 'Produto',
                    },
                    {
                        text: 'UNIDADE',
                        value: 'Unidade',
                    },
                    {
                        text: 'OBSERVAÇÃO',
                        value: 'Observacao',
                    },
                    {
                        text: 'DT. ENVIO',
                        value: 'DtEnvio',
                    },
                    {
                        text: 'DT. RETORNO',
                        value: 'DtRetorno',
                    },
                    {
                        text: 'QT. DIAS',
                        value: 'qtDias',
                    },
                ],
            };
        },
        components: {
            Carregando,
            IdentificacaoProjeto,
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dados: 'projeto/historicoEncaminhamento',
            }),
        },
        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                this.buscarHistoricoEncaminhamento(this.dadosProjeto.idPronac);
            }
        },
        watch: {
            dados() {
                this.loading = false;
            },
        },
        methods: {
            ...mapActions({
                buscarHistoricoEncaminhamento: 'projeto/buscarHistoricoEncaminhamento',
            }),
        },
    };
</script>

