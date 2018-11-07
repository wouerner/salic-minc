<template>
    <div>
        <v-card>
            <v-card-title>
                    <h6>Tramita&ccedil;&atilde;o Documento</h6>
            </v-card-title>
            <v-data-table
                    :headers="headers"
                    :items="dados"
                    class="elevation-1 container-fluid mb-2"
                    rows-per-page-text="Items por Página"
                    no-data-text="Nenhum dado encontrado"
            >
                <template slot="items" slot-scope="props">
                    <td>{{ props.item.dsTipoDocumento }}</td>
                    <td>{{ props.item.dtDocumento }}</td>
                    <td>{{ props.item.dtAnexacao }}</td>
                    <td>
                        <a :href="`/consultardadosprojeto/abrir-documento-tramitacao?id=${ props.item.idDocumento}&idPronac=${idPronac}`">
                            {{ props.item.noArquivo }}
                        </a>
                    </td>
                    <td>{{ props.item.Usuario }}</td>
                    <td>{{ props.item.idLote }}</td>
                    <td>{{ props.item.Situacao }}</td>
                </template>
                <template slot="pageText" slot-scope="props">
                    Items {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                </template>
            </v-data-table>
        </v-card>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: 'TramitacaoDocumento',
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
                        text: 'TIPO',
                        align: 'left',
                        value: 'dsTipoDocumento',
                    },
                    {
                        text: 'DATA',
                        value: 'dtDocumento',
                    },
                    {
                        text: 'DT. ANEXAÇÃO',
                        value: 'dtAnexacao',
                    },
                    {
                        text: 'DOCUMENTO',
                        value: 'noArquivo',
                    },
                    {
                        text: 'ANEXADO POR',
                        value: 'Usuario',
                    },
                    {
                        text: 'LOTE',
                        value: 'idLote',
                    },
                    {
                        text: 'ESTADO',
                        value: 'Situacao',
                    },
                ],
            };
        },
        mounted() {
            if (typeof this.idPronac !== 'undefined') {
                this.buscarTramitacaoDocumento(this.idPronac);
            }
        },
        computed: {
            ...mapGetters({
                dados: 'projeto/tramitacaoDocumento',
            }),
        },
        methods: {
            ...mapActions({
                buscarTramitacaoDocumento: 'projeto/buscarTramitacaoDocumento',
            }),
        },
    };
</script>

