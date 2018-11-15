<template>
    <div>
        <!--<div v-if="loading">-->
            <!--<carregando :text="'Carregando Marcas Anexadas'"/>-->
        <!--</div>-->
        <div>
            <v-card>
                <v-card-title>
                    <h6>Pedido de Porrogação</h6>
                </v-card-title>
                <v-data-table
                        :headers="headers"
                        :items="dados"
                        class="elevation-1 container-fluid mb-2"
                        rows-per-page-text="Items por Página"
                        no-data-text="Nenhum dado encontrado"
                >
                    <template slot="items" slot-scope="props">
                        <td class="text-xs-left">{{ props.item.DtPedido }}</td>
                        <td class="text-xs-right">{{ props.item.DtInicio | formatarData }}</td>
                        <td class="text-xs-left">{{ props.item.DtFinal }}</td>
                        <td class="text-xs-left">{{ props.item.Observacao }}</td>
                        <td class="text-xs-left">{{ props.item.Estado }}</td>
                        <td class="text-xs-left">{{ props.item.Usuario }}</td>
                    </template>
                    <template slot="pageText" slot-scope="props">
                        Items {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                    </template>
                </v-data-table>
            </v-card>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex';

    export default {
        name: 'PedidoProrrogacao',
        props: ['idPronac'],
        data() {
            return {
                search: '',
                pagination: {
                    sortBy: 'fat',
                },
                selected: [],
                headers: [
                    {
                        align: 'center',
                        text: 'Dt.Pedido',
                        sortable: false,
                        value: 'DtPedido',
                    },
                    {
                        align: 'left',
                        text: 'Dt.Início',
                        value: 'DtInicio',
                    },
                    {
                        align: 'left',
                        text: 'Dt.Final',
                        value: 'DtFinal',
                    },
                    {
                        align: 'center',
                        text: 'Observações',
                        value: 'Observacao',
                    },
                    {
                        text: 'Estado',
                        align: 'center',
                        value: 'Estado',
                    },
                    {
                        text: 'Analista',
                        align: 'center',
                        value: 'Usuario',
                    },
                ],
                dados: Object,
                default() {
                    return [];
                }
            }
        },
        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                this.buscar_dados();
            }
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
            }),
        },
        methods: {
            buscar_dados() {
                const self = this;
                $3.ajax({
                    url: '/execucao/pedido-prorrogacao-rest/index/idPronac/' + self.dadosProjeto.idPronac,
                }).done(function (response) {
                    self.dados = response.data.items;
                    console.log(self.dados);
                });
            },
        },
    };
</script>

<!--<script>-->
    <!--export default {-->
        <!--name: 'DocumentosAssinados',-->
        <!--props: ['idPronac'],-->
        <!--data() {-->
            <!--return {-->
                <!--dados: {-->
                    <!--type: Object,-->
                    <!--default() {-->
                        <!--return {};-->
                    <!--},-->
                <!--},-->
            <!--};-->
        <!--},-->
        <!--mounted() {-->
            <!--if (typeof this.$route.params.idPronac !== 'undefined') {-->
                <!--this.buscar_dados();-->
            <!--}-->
        <!--},-->
        <!--methods: {-->
            <!--buscar_dados() {-->
                <!--const self = this;-->
                <!--const idPronac = self.$route.params.idPronac;-->
                <!--/* eslint-disable */-->
                <!--$3.ajax({-->
                    <!--url: '/projeto/documentos-assinados-rest/index/idPronac/' + idPronac,-->
                <!--}).done(function (response) {-->
                    <!--self.dados = response.data;-->
                <!--});-->
            <!--},-->
        <!--},-->
    <!--}-->
<!--</script>-->