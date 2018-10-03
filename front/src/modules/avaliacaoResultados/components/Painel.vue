<template>
    <v-container fluid>
        <h1 class="display-2 font-weight-thin">Análise Técnica</h1>
        <v-card>
            <v-tabs
                    centered
                    color="green"
                    dark
                    icons-and-text
            >
                <v-tabs-slider color="deep-orange accent-3"></v-tabs-slider>
                <v-tab href="#tab-0">
                    Encaminhar 
                    <v-icon>assignment_ind</v-icon>
                </v-tab>
                <v-tab href="#tab-1">
                    Em Analise
                    <v-icon>how_to_reg</v-icon>
                </v-tab>
                <v-tab href="#tab-2">
                     Finalizados
                    <v-icon>done_all</v-icon>
                </v-tab>
                <v-tab href="#tab-3">
                     Em assinatura
                    <v-icon>edit</v-icon>
                </v-tab>
                <v-tab-item
                        :id="'tab-0'"
                        :key="0"
                >
                    <v-card flat>
                        <v-card-text>
                            <TabelaProjetos
                                :dados="getProjetosParaDistribuir"
                                :componentes="distribuirAcoes"
                            ></TabelaProjetos>
                        </v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item
                        :id="'tab-1'"
                        :key="1"
                >
                    <v-card flat>
                        <v-card-text>
                            <TabelaProjetos
                                :analisar="true"
                                :dados="dadosTabelaTecnico"
                                :componentes="listaAcoes"
                            ></TabelaProjetos>
                        </v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item
                        :id="'tab-2'"
                        :key="2"
                >
                    <v-card flat>
                        <v-card-text>
                            <TabelaProjetos
                                :dados="getProjetosFinalizados"
                                :componentes="listaAcoes"
                            ></TabelaProjetos>
                        </v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item
                        :id="'tab-3'"
                        :key="3"
                >
                    <v-card flat>
                        <v-card-text>
                            <TabelaProjetos
                                :dados="getProjetosFinalizados"
                                :componentes="listaAcoes"
                            ></TabelaProjetos>
                        </v-card-text>
                    </v-card>
                </v-tab-item>
            </v-tabs>
        </v-card>
    </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import TabelaProjetos from './TabelaProjetos';
import Historico from './Historico';
import Encaminhar from './ComponenteEncaminhar';

export default {
    name: 'Painel',
    created() {
        this.projetosFinalizados({ estadoid: 6 });
        this.obterDadosTabelaTecnico({ estadoid: 5 });
        this.distribuir({ estadoid: 6 });
    },
    data() {
        return {
            listaAcoes: [Historico],
            distribuirAcoes: [Encaminhar],
        };
    },
    components: {
        TabelaProjetos,
    },
    methods: {
        ...mapActions({
            obterDadosTabelaTecnico: 'avaliacaoResultados/obterDadosTabelaTecnico',
            projetosFinalizados: 'avaliacaoResultados/projetosFinalizados',
            distribuir: 'avaliacaoResultados/projetosParaDistribuir',
        }),
    },
    computed: {
        ...mapGetters({
            dadosTabelaTecnico: 'avaliacaoResultados/dadosTabelaTecnico',
            getProjetosFinalizados: 'avaliacaoResultados/getProjetosFinalizados',
            getProjetosParaDistribuir: 'avaliacaoResultados/getProjetosParaDistribuir',
        }),
    },
};
</script>
