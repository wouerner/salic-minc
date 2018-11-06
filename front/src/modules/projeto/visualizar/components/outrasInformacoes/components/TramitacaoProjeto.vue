<template>
    <div>
        <v-card>
            <v-card-title>
                    <h6>Tramita&ccedil;&atilde;o do Projeto</h6>
            </v-card-title>
            <v-data-table
                    :headers="headers"
                    :items="dados"
                    class="elevation-1 container-fluid mb-2"
                    rows-per-page-text="Items por Página"
            >
                <template slot="items" slot-scope="props">
                    <td>{{ props.item.Origem }}</td>
                    <td>{{ props.item.dtTramitacaoEnvio }}</td>
                    <td>{{ props.item.Destino }}</td>
                    <td>{{ props.item.dtTramitacaoRecebida }}</td>
                    <td>{{ props.item.Situacao }}</td>
                    <td style="width: 700px">{{ props.item.meDespacho }}</td>
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
        </v-card>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: 'TramitacaoProjeto',
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
                        text: 'ORIGEM',
                        align: 'left',
                        value: 'Origem',
                    },
                    {
                        text: 'DT.ENVIO',
                        value: 'dtTramitacaoEnvio',
                    },
                    {
                        text: 'DESTINO',
                        value: 'Destino',
                    },
                    {
                        text: 'DT.RECEBIMENTO',
                        value: 'dtTramitacaoRecebida',
                    },
                    {
                        text: 'ESTADO',
                        value: 'Situacao',
                    },
                    {
                        text: 'DESPACHO',
                        value: 'meDespacho',
                    },
                ],
            };
        },
        mounted() {
            if (typeof this.idPronac !== 'undefined') {
                this.buscarTramitacaoProjeto(this.idPronac);
            }
        },
        computed: {
            ...mapGetters({
                dados: 'projeto/tramitacaoProjeto',
            }),
        },
        methods: {
            ...mapActions({
                buscarTramitacaoProjeto: 'projeto/buscarTramitacaoProjeto',
            }),
        },
    };
</script>

