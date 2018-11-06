<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Carregando Certidoes Negativas'"></Carregando>
        </div>
        <div v-else-if="dados.certidoes">
            <v-data-table
                    :headers="headers"
                    :items="dados.certidoes"
                    class="elevation-1 container-fluid"
                    rows-per-page-text="Items por Página"
            >
                <template slot="items" slot-scope="props">
                    <td>{{ props.item.dsCertidao }}</td>
                    <td>{{ props.item.DtEmissao }}</td>
                    <td>{{ props.item.DtValidade }}</td>
                    <td>{{ props.item.Pronac }}</td>
                    <td v-if="props.item.Situacao">
                        {{ props.item.Situacao }}
                    </td>
                    <td v-else>
                        Vencida
                    </td>
                </template>
                <template slot="no-data">
                    <v-alert :value="true" color="info" icon="warning">
                        Nenhum dado encontrado
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

    import { mapActions, mapGetters } from 'vuex';
    import Carregando from '@/components/Carregando';

    export default {
        name: 'CertidoesNegativas',
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
                        text: 'CERTIDÕES',
                        align: 'left',
                        value: 'dsCertidao',
                    },
                    {
                        text: 'DATA DE EMISSÃO',
                        value: 'DtEmissao',
                    },
                    {
                        text: 'DATA DE VALIDADE',
                        value: 'DtValidade',
                    },
                    {
                        text: 'PRONAC',
                        value: 'Pronac',
                    },
                    {
                        text: 'SITUAÇÃO',
                        value: 'Situacao',
                    },
                ],
            };
        },
        components: {
            Carregando,
        },
        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                this.buscarCertidoesNegativas(this.dadosProjeto.idPronac);
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
                dados: 'projeto/certidoesNegativas',
            }),
        },
        methods: {
            ...mapActions({
                buscarCertidoesNegativas: 'projeto/buscarCertidoesNegativas',
            }),
        },
    };
</script>

