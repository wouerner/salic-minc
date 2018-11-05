<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Documentos Anexados'"></Carregando>
        </div>
        <div v-else-if="documentosAnexados.documentos">
            <IdentificacaoProjeto :pronac="dadosProjeto.Pronac"
                                  :nomeProjeto="dadosProjeto.NomeProjeto">
            </IdentificacaoProjeto>
            <v-data-table
                    :headers="headers"
                    :items="indexItems"
                    item-key="id"
                    :search="search"
                    class="elevation-1"
                    :pagination.sync="pagination"
                    rows-per-page-text="Items por Página"
            >
                <template slot="items" slot-scope="props">
                    <td class="center">{{ props.item.id + 1 }}</td>
                    <td class="center">{{ props.item.Anexado }}</td>
                    <td class="center">{{ props.item.Data }}</td>
                    <td class="text-xs-left">{{ props.item.Descricao }}</td>
                    <td class="center">
                        <v-tooltip left>
                            <v-btn
                                    style="text-decoration: none"
                                    slot="activator"
                                    color="blue"
                                    :href="`/consultardadosprojeto/abrir-documentos-anexados?id=${props.item.idArquivo}&tipo=${props.item.AgenteDoc}&idPronac=${dadosProjeto.idPronac}`"
                                    dark
                            >
                                <v-icon dark>cloud_download</v-icon>
                            </v-btn>
                            <span>{{ props.item.NoArquivo }}</span>
                        </v-tooltip>
                    </td>
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
    </div>
</template>
<script>
    import {mapGetters, mapActions} from 'vuex';
    import Carregando from '@/components/Carregando';
    import IdentificacaoProjeto from './IdentificacaoProjeto';

    export default {
        name: 'DocumentosAnexados',
        props: ['idPronac'],
        components: {
            Carregando,
            IdentificacaoProjeto,
        },
        data() {
            return {
                search: '',
                pagination: {
                    sortBy: 'fat',
                },
                indexDocumentosAnexados: 0,
                selected: [],
                loading: true,
                headers: [
                    {
                        text: 'N°',
                        align: 'center',
                        value: 'id',
                    },
                    {
                        align: 'center',
                        text: 'CLASSIFICAÇÃO',
                        value: 'Anexado',
                    },
                    {
                        align: 'center',
                        text: 'DATA',
                        value: 'Data',
                    },
                    {
                        align: 'center',
                        text: 'TIPO DE DOCUMENTO',
                        value: 'Descricao',
                    },
                    {
                        align: 'center',
                        text: 'DOCUMENTO',
                        value: 'NoArquivo',
                    },
                ],
            };
        },
        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                this.buscarDocumentosAnexados(this.dadosProjeto.idPronac);
            }
        },
        watch: {
            dados(value) {
                this.informacoes = value.informacoes;
            },
            documentosAnexados() {
                this.loading = false;
            },
        },
        methods: {
            ...mapActions({
                buscarDocumentosAnexados: 'projeto/buscarDocumentosAnexados',
            }),
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                documentosAnexados: 'projeto/documentosAnexados',
            }),
            indexItems() {
                const currentItems = this.documentosAnexados.documentos;
                return currentItems.map((item, index) => ({
                    id: index,
                    ...item,
                }));
            },
        },
    };
</script>
