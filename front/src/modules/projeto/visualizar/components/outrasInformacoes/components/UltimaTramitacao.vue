<template>
    <div>
        <v-card>
            <v-card-title>
                <h6>&Uacute;ltima Tramita&ccedil;&atilde;o</h6>
            </v-card-title>
            <v-data-table
                    :headers="headers"
                    :items="dados"
                    class="elevation-1 container-fluid mb-2"
                    rows-per-page-text="Items por Página"
            >
                <template slot="items" slot-scope="props">
                    <td>{{ props.item.Emissor }}</td>
                    <td>{{ props.item.dtTramitacaoEnvio }}</td>
                    <td>{{ props.item.Receptor }}</td>
                    <td>{{ props.item.dtTramitacaoRecebida }}</td>
                    <td>{{ props.item.Estado }}</td>
                    <td>{{ props.item.Destino }}</td>
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
        name: 'UltimaTramitacao',
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
                        text: 'Emissor',
                        align: 'left',
                        value: 'Emissor',
                    },
                    {
                        text: 'Dt.Envio',
                        value: 'dtTramitacaoEnvio',
                    },
                    {
                        text: 'Receptor',
                        value: 'Receptor',
                    },
                    {
                        text: 'Dt.Recebimento',
                        value: 'dtTramitacaoRecebida',
                    },
                    {
                        text: 'Estado',
                        value: 'Estado',
                    },
                    {
                        text: 'Destino',
                        value: 'Destino',
                    },
                    {
                        text: 'Despacho',
                        value: 'meDespacho',
                    },
                ],
            };
        },
        mounted() {
            if (typeof this.idPronac !== 'undefined') {
                this.buscarUltimaTramitacao(this.idPronac);
            }
        },
        computed: {
            ...mapGetters({
                dados: 'projeto/ultimaTramitacao',
            }),
        },
        methods: {
            ...mapActions({
                buscarUltimaTramitacao: 'projeto/buscarUltimaTramitacao',
            }),
        },
    };
</script>

