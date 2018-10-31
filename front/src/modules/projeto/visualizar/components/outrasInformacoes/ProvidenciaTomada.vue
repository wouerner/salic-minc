<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Carregando Certidoes Negativas'"></Carregando>
        </div>
        <div v-else-if="dados.providenciaTomada">
            <IdentificacaoProjeto :pronac="dadosProjeto.Pronac"
                                  :nomeProjeto="dadosProjeto.NomeProjeto">
            </IdentificacaoProjeto>
           <v-data-table
                    :headers="headers"
                    :items="dados.providenciaTomada"
                    class="elevation-1 container-fluid"
                    rows-per-page-text="Itens por Página"
           >
                <template slot="items" slot-scope="props">
                    <td style="width: 190px">{{ props.item.DtSituacao }}</td>
                    <td style="width: 50px">{{ props.item.Situacao }}</td>
                    <td style="width: 700px">{{ props.item.ProvidenciaTomada }}</td>
                    <td style="width: 190px">{{ props.item.cnpjcpf | cnpjFilter }}</td>
                    <td>{{ props.item.usuario }}</td>
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
    import cnpjFilter from '@/filters/cnpj';
    import IdentificacaoProjeto from './IdentificacaoProjeto';

    export default {
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
                selected: [],
                loading: true,
                headers: [
                    {
                        text: 'DT. SITUAÇÃO',
                        align: 'left',
                        sortable: false,
                        value: 'DtSituacao',
                    },
                    {
                        text: 'SITUAÇÃO',
                        value: 'Situacao',
                    },
                    {
                        text: 'PROVIDÊNCIA TOMADA',
                        value: 'ProvidenciaTomada',
                    },
                    {
                        text: 'CPF',
                        value: 'cnpjcpf',
                    },
                    {
                        text: 'NOME',
                        value: 'usuario',
                    },
                ],
            };
        },

        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                this.buscarProvidenciaTomada(this.dadosProjeto.idPronac);
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
                dados: 'projeto/providenciaTomada',
            }),
        },
        methods: {
            ...mapActions({
                buscarProvidenciaTomada: 'projeto/buscarProvidenciaTomada',
            }),
        },
        filters: {
            cnpjFilter,
        },
    };
</script>
