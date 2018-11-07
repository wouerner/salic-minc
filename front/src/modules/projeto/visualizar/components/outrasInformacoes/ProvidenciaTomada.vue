<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Carregando Providência Tomada'"></Carregando>
        </div>
        <div v-else-if="dados.providenciaTomada">
           <v-data-table
                    :headers="headers"
                    :items="dados.providenciaTomada"
                    class="elevation-1 container-fluid"
                    rows-per-page-text="Items por Página"
                    no-data-text="Nenhum dado encontrado"
           >
                <template slot="items" slot-scope="props">
                    <td style="width: 190px" class="text-xs-center">{{ props.item.DtSituacao }}</td>
                    <td style="width: 50px"  class="text-xs-center">{{ props.item.Situacao }}</td>
                    <td style="width: 700px" class="text-xs-center">{{ props.item.ProvidenciaTomada }}</td>
                    <td style="width: 190px" class="text-xs-center" v-if="props.item.cnpjcpf">{{ props.item.cnpjcpf | cnpjFilter }}</td>
                    <td style="width: 190px" class="text-xs-center" v-else>Nao se aplica.</td>
                    <td class="text-xs-center">{{ props.item.usuario }}</td>
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
                        align: 'center',
                        value: 'DtSituacao',
                    },
                    {
                        text: 'SITUAÇÃO',
                        align: 'center',
                        value: 'Situacao',
                    },
                    {
                        text: 'PROVIDÊNCIA TOMADA',
                        align: 'center',
                        value: 'ProvidenciaTomada',
                    },
                    {
                        text: 'CPF',
                        align: 'center',
                        value: 'cnpjcpf',
                    },
                    {
                        text: 'NOME',
                        align: 'center',
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
