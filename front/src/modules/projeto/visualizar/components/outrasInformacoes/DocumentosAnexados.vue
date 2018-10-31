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
                    :pagination.sync="pagination"
                    class="elevation-1"
                    rows-per-page-text="Itens por Página"
            >
                <template slot="items" slot-scope="props">
                    <td>{{ props.item.id + 1 }}</td>
                    <td class="text-xs">{{ props.item.Anexado }}</td>
                    <td class="text-xs">{{ props.item.Data }}</td>
                    <td class="text-xs">{{ props.item.Descricao }}</td>
                    <v-tooltip left>
                        <v-btn
                            slot="activator"
                            color="blue"
                            :href="`/consultardadosprojeto/abrir-documentos-anexados?id=${props.item.idArquivo}&tipo=${props.item.AgenteDoc}&idPronac=${dadosProjeto.idPronac}`"
                            dark
                        >
                            <v-icon dark>cloud_download</v-icon>
                        </v-btn>
                        <span>{{ props.item.NoArquivo }}</span>
                    </v-tooltip>
                </template>
                <template slot="pageText" slot-scope="props">
                    Itens {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                </template>
            </v-data-table>
        </div>
    </div>
</template>
<script>
    import { mapGetters, mapActions } from 'vuex';
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
                        align: 'left',
                        value: 'id',
                    },
                    {
                        text: 'CLASSIFICAÇÃO',
                        value: 'Anexado',
                    },
                    {
                        text: 'DATA',
                        value: 'Data',
                    },
                    {
                        text: 'TIPO DE DOCUMENTO',
                        value: 'Descricao',
                    },
                    {
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
            iterador(index) {
                this.indexDocumentosAnexados = index + 1;
                return this.indexDocumentosAnexados;
            },
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
