<template>
    <v-container fluid>
        <v-card>
            <v-tabs
                centered
                color="green"
                dark
                icons-and-text
            >
                <v-tabs-slider color="deep-orange accent-3"></v-tabs-slider>
                <v-tab href="#tab-0"
                    v-if="getUsuario.grupo_ativo == 125"
                >
                    <template v-if="Object.keys(getProjetosParaDistribuir).length == 0">
                        <v-progress-circular
                            indeterminate
                            color="primary"
                            dark
                        ></v-progress-circular>
                    </template>
                    <template v-else>
                        Encaminhar
                        <v-icon>assignment_ind</v-icon>
                    </template>
                </v-tab>
                <v-tab href="#tab-1">
                    <template v-if="Object.keys(dadosTabelaTecnico).length == 0">
                        <v-progress-circular
                            indeterminate
                            color="primary"
                            dark
                        ></v-progress-circular>
                    </template>
                    <template v-else>
                        Em Analise
                        <v-icon>how_to_reg</v-icon>
                    </template>
                </v-tab>
                <v-tab href="#tab-2">
                    Assinar
                    <v-icon>done_all</v-icon>
                </v-tab>
                <v-tab href="#tab-3">
                    Acompanhamento 
                    <v-icon>edit</v-icon>
                </v-tab>
                <v-tab href="#tab-4">
                    Historico 
                    <v-icon>edit</v-icon>
                </v-tab>

                <v-tab-item
                    :id="'tab-0'"
                    :key="0"
                >
                    <TabelaProjetos
                        v-if="getProjetosParaDistribuir"
                        :dados="getProjetosParaDistribuir"
                        :componentes="distribuirAcoes"
                    ></TabelaProjetos>
                </v-tab-item>
                <v-tab-item
                    :id="'tab-1'"
                    :key="1"
                >
                    <v-card flat
                        v-if="dadosTabelaTecnico"
                    >
                        <v-card-text>
                            <TabelaProjetos
                                v-if="getUsuario.grupo_ativo == 125"
                                :analisar="true"
                                :dados="dadosTabelaTecnico"
                                :componentes="listaAcoesCoordenador"
                            ></TabelaProjetos>
                            <TabelaProjetos
                                v-else
                                :analisar="true"
                                :dados="dadosTabelaTecnico"
                                :componentes="listaAcoesTecnico"
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
                                :componentes="listaAcoesTecnico"
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
                                :dados="getProjetosAssinatura"
                                :componentes="listaAcoesTecnico"
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
import TipoAvaliacao from './TipoAvaliacao';
import AnaliseButton from './analise/analisarButton';

export default {
    name: 'Painel',
    created() {
        this.projetosFinalizados({ estadoid: 6 });
        this.projetosAssinatura();
        this.obterDadosTabelaTecnico({ estadoid: 5 });
        this.distribuir({ estadoid: 6 });
        this.usuarioLogado();
    },
    mounted() {
    },
    watch: {
        getUsuario(val) {
            if (Object.keys(val).length > 0 && val.usu_codigo != 0 ) {

                this.projetosFinalizados({ estadoid: 6, idAgente: this.getUsuario.usu_codigo });
                this.obterDadosTabelaTecnico({ estadoid: 5, idAgente: this.getUsuario.usu_codigo });
                this.distribuir({ estadoid: 6 });
            }
        },
    },
    data() {
        return {
            listaAcoesTecnico: [Historico, AnaliseButton],
            //listaAcoesTecnico: [Historico, TipoAvaliacao],
            listaAcoesCoordenador: [Historico],
            //listaAcoesCoordenador: [Historico, TipoAvaliacao],
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
            projetosAssinatura: 'avaliacaoResultados/projetosAssinatura',
            distribuir: 'avaliacaoResultados/projetosParaDistribuir',
            usuarioLogado: 'autenticacao/usuarioLogado',
        }),
    },
    computed: {
        ...mapGetters({
            dadosTabelaTecnico: 'avaliacaoResultados/dadosTabelaTecnico',
            getProjetosFinalizados: 'avaliacaoResultados/getProjetosFinalizados',
            getProjetosAssinatura: 'avaliacaoResultados/getProjetosAssinatura',
            getProjetosParaDistribuir: 'avaliacaoResultados/getProjetosParaDistribuir',
            getUsuario: 'autenticacao/getUsuario',
        }),
    },
};
</script>
