<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Relatório de cumprimento do objeto'"/>
        </div>
        <div v-else>
            <v-card>
                <v-card-text>
                    <v-container
                            grid-list-md
                            text-xs-left
                    >
                        <v-layout
                                justify-space-around
                                row
                                wrap>
                            <v-flex
                                    lg12
                                    dark
                                    class="text-xs-left">
                                <b><h4>ETAPAS DE TRABALHO</h4></b>
                                <v-divider class="pb-2"/>
                            </v-flex>
                            <v-flex>
                                <p><b>Etapas de Trabalho Executadas</b></p>
                                <p v-html="dados.dadosRelatorio.dsEtapasConcluidas"></p>
                            </v-flex>
                            <v-flex>
                                <p><b>Medidas de Acessibilidade, nos Termos da Portaria de Aprovação</b></p>
                                <p v-html="dados.dadosRelatorio.dsMedidasAcessibilidade"></p>
                            </v-flex>
                            <v-flex>
                                <p><b>Medidas de Democratização do acesso, nos termos da portaria de aprovação</b></p>
                                <p v-html="dados.dadosRelatorio.dsMedidasFruicao"></p>
                            </v-flex>
                            <v-flex>
                                <p><b>MEDIDAS PREVENTIVAS QUANTO A IMPACTOS AMBIENTAIS</b></p>
                                <p v-html="dados.dadosRelatorio.dsMedidasPreventivas"></p>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
            </v-card>

            <!--COMPROVAÇÃO DE ITENS ORÇAMENTÁRIOS-->
            <ComprovacaoItensOrcamentarios ></ComprovacaoItensOrcamentarios>

            <BeneficiariosProdutoCultural></BeneficiariosProdutoCultural>
        </div>
    </div>
</template>
<script>

import { mapActions, mapGetters } from 'vuex';
import Carregando from '@/components/CarregandoVuetify';
import { utils } from '@/mixins/utils';
import ComprovacaoItensOrcamentarios from './components/ComprovacaoItensOrcamentarios';
import BeneficiariosProdutoCultural from './components/BeneficiariosProdutoCultural';

export default {
    name: 'RelatorioCumprimentoObjeto',
    components: {
        Carregando,
        ComprovacaoItensOrcamentarios,
        BeneficiariosProdutoCultural,
    },
    mixins: [utils],
    data() {
        return {
            pagination: {
                sortBy: '',
                descending: true,
            },
            loading: true,
            headers: [

            ],
        };
    },
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
            dados: 'prestacaoContas/relatorioCumprimentoObjeto',
        }),
    },
    watch: {
        dadosProjeto(value) {
            this.loading = false;
            this.buscarRelatorioCumprimentoObjeto(value.idPronac);
        },
        dados() {
            this.loading = false;
        },
    },
    mounted() {
        if (typeof this.dadosProjeto.idPronac !== 'undefined') {
            this.buscarRelatorioCumprimentoObjeto(this.dadosProjeto.idPronac);
        }
    },
    methods: {
        ...mapActions({
            buscarRelatorioCumprimentoObjeto: 'prestacaoContas/buscarRelatorioCumprimentoObjeto',
        }),
        indexItems() {
            const currentItems = this.dados;
            return currentItems.map((item, index) => ({
                id: index,
                ...item,
            }));
        },
    },
};
</script>
