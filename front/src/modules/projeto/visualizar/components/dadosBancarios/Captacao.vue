<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Captação'"></Carregando>
        </div>
        <div v-else-if="Object.keys(dadosCaptacao).length > 0">
            <v-card>
                <v-data-table
                    :headers="headers"
                    :items="dadosCaptacao"
                    class="elevation-1 container-fluid"
                    rows-per-page-text="Items por Página"
                    :pagination.sync="pagination"
                    :rows-per-page-items="[10, 25, 50, {'text': 'Todos', value: -1}]"
                    no-data-text="Nenhum dado encontrado"
                    no-results-text="Nenhum dado encontrado"
                    :search="search"
                >
                    <template slot="items" slot-scope="props">
                        <td class="text-xs-left" v-html="props.item.Nome"></td>
                        <td class="text-xs-right">{{ props.item.NumeroRecibo }}</td>
                        <td class="text-xs-left" v-html="props.item.TipoApoio"></td>
                        <td class="text-xs-right">{{ props.item.DtRecibo | formatarData }}</td>
                        <td class="text-xs-right">{{ props.item.DtTransferenciaRecurso | formatarData }}</td>
                        <td class="text-xs-right">{{ props.item.CaptacaoReal | filtroFormatarParaReal }}</td>
                        <td class="text-xs-right">{{ parseFloat(((props.item.CaptacaoReal / (props.item.ValorCaptado))* 100).toFixed(2)) }}</td>
                        <td class="text-xs-right" v-if="props.item.isBemServico == 0">Não</td>
                        <td class="text-xs-right" v-else-if="props.item.isBemServico == 1">Sim</td>
                    </template>
                    <template slot="pageText" slot-scope="props">
                        Items {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                    </template>
                </v-data-table>
                <v-container fluid>
                    <v-layout row wrap>
                        <v-flex xs6>
                            <h6>Total Captado</h6>
                        </v-flex>
                        <v-flex xs5 offset-xs1 class=" text-xs-right">
                            <h6>R$ {{ dadosProjeto.vlCaptado | filtroFormatarParaReal }}</h6>
                        </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                        <v-flex xs6>
                            <h6>Total % Captado</h6>
                        </v-flex>
                        <v-flex xs5 offset-xs1 class=" text-xs-right">
                            <h6>{{ dadosProjeto.PercentualCaptado }}%</h6>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card>
        </div>
    </div>
</template>
<script>

    import { mapActions, mapGetters } from 'vuex';
    import Carregando from '@/components/CarregandoVuetify';
    import { utils } from '@/mixins/utils';

    export default {
        name: 'Captacao',
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
                        text: 'INCENTIVADOR',
                        align: 'left',
                        value: 'Nome',
                    },
                    {
                        text: 'NR. RECIBO',
                        align: 'center',
                        value: 'NumeroRecibo',
                    },
                    {
                        text: 'TIPO DE APOIO',
                        align: 'center',
                        value: 'TipoApoio',
                    },
                    {
                        text: 'DT. CAPTAÇÃO',
                        align: 'center',
                        value: 'DtRecibo',
                    },
                    {
                        text: 'DT. TRANSFERÊMCIA',
                        align: 'left',
                        value: 'DtTransferenciaRecurso',
                    },
                    {
                        text: 'VL. CAPTADO',
                        align: 'center',
                        value: 'CaptacaoReal',
                    },
                    {
                        text: '% CAPTADO',
                        align: 'center',
                        value: 'PorcentagemCaptacao',
                    },
                    {
                        text: 'BEM/SERVIÇO',
                        align: 'center',
                        value: 'isBemServico',
                    },
                ],
            };
        },
        mixins: [utils],
        components: {
            Carregando,
        },
        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                const params = {
                    idPronac: this.dadosProjeto.idPronac,
                    dtReciboInicio: '',
                    dtReciboFim: '',
                };
                this.buscarCaptacao(params);
            }
        },
        watch: {
            dadosCaptacao() {
                this.loading = false;
            },
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dadosCaptacao: 'projeto/captacao',
            }),
        },
        methods: {
            ...mapActions({
                buscarCaptacao: 'projeto/buscarCaptacao',
            }),
        },
    };
</script>
