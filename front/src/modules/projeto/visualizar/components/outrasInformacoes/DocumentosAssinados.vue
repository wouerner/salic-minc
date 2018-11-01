<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Carregando Documentos Assinados'"></Carregando>
        </div>
        <v-data-table
                :headers="headers"
                :items="dados"
                :search="search"
                :pagination.sync="pagination"
                class="elevation-1"
                rows-per-page-text="Items por Página"
        >
            <template slot="items" slot-scope="props">
                <v-btn
                        slot="activator"
                        class="center"
                        color="primary"
                        :to="{ name: 'dadosprojeto', params: { idPronac: dadosProjeto.idPronac }}">
                    <u>{{ props.item.pronac }}</u>
                </v-btn>
                <td class="center">{{ props.item.nomeProjeto }}</td>
                <td class="center">{{ props.item.dsAtoAdministrativo }}</td>
                <td class="center">{{ props.item.dt_criacao }}</td>
                <v-tooltip left>
                    <v-btn
                            fab dark small
                            slot="activator"
                            color="teal"
                            :href="`/assinatura/index/visualizar-documento-assinado/idPronac/${props.item.IdPRONAC}?idDocumentoAssinatura=${props.item.idDocumentoAssinatura}`"
                            target="_blank"
                            dark
                    >
                        <v-icon dark>search</v-icon>
                    </v-btn>
                    <span>Visualizar</span>
                </v-tooltip>
            </template>
            <template slot="no-data">
                <v-alert :value="true" color="error" icon="warning">
                    Nenhum dado encontrado ¯\_(ツ)_/¯
                </v-alert>
            </template>
            <template slot="pageText" slot-scope="props">
                Items {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
            </template>
        </v-data-table>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import Carregando from '@/components/Carregando';

    export default {
        name: 'DocumentosAssinados',
        props: ['idPronac'],
        components: {
            Carregando,
        },
        data() {
            return {
                loading: true,
                search: '',
                pagination: {
                    sortBy: 'fat',
                },
                selected: [],
                headers: [
                    {
                        align: 'center',
                        text: 'PRONAC',
                        sortable: false,
                        value: 'pronac',
                    },
                    {
                        align: 'center',
                        text: 'NOME DO PROJETO',
                        value: 'nomeProjeto',
                    },
                    {
                        align: 'center',
                        text: 'ATO ADMINISTRATIVO',
                        value: 'dsAtoAdministrativo',
                    },
                    {
                        align: 'center',
                        text: 'DATA',
                        value: 'dt_criacao',
                    },
                    {
                        align: 'center',
                        sortable: false,
                        text: 'VER',
                    },
                ],
            };
        },
        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                this.buscarDocumentosAssinados(this.dadosProjeto.idPronac);
            }
        },
        watch: {
            dados() {
                this.loading = false;
            },
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dados: 'projeto/documentosAssinados',
            }),
        },
        methods: {
            ...mapActions({
                buscarDocumentosAssinados: 'projeto/buscarDocumentosAssinados',
            }),
        },
    };
</script>