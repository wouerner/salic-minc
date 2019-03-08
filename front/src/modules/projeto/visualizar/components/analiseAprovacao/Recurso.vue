<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Recursos'"/>
        </div>
        <div v-else-if="dados.length > 0">
            <v-expansion-panel
                popout
                focusable>
                <v-expansion-panel-content
                    v-for="(recurso, index) in dados"
                    :key="index"
                    class="elevation-1">
                    <v-layout
                        slot="header"
                        class="primary--text">
                        <v-icon class="mr-3 primary--text">assignment</v-icon>
                        <span v-html="recurso.dadosRecurso.tpRecursoDesc"/>
                        <span v-html="recurso.dadosRecurso.siFaseProjeto"/>
                    </v-layout>
                    <desistencia-recursal
                        v-if="recurso.desistenciaRecurso === true"
                        :dados-recurso="recurso.dadosRecurso"/>
                    <component
                        v-else
                        :is="`conteudo-recurso-fase-${recurso.dadosRecurso.siFaseProjeto}`"
                        :recurso="recurso"/>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </div>
        <div v-else>
            <v-container
                grid-list-md
                text-xs-center>
                <v-layout
                    row
                    wrap>
                    <v-flex>
                        <v-card>
                            <v-card-text>Nenhum Recurso encontrado</v-card-text>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </div>
    </div>
</template>
<script>

import { mapActions, mapGetters } from 'vuex';
import Carregando from '@/components/CarregandoVuetify';
import { utils } from '@/mixins/utils';
import DesistenciaRecursal from './components/DesistenciaRecursal';
import ConteudoRecursoFase1 from './components/ConteudoRecursoFase1';
import ConteudoRecursoFase2 from './components/ConteudoRecursoFase2';

export default {
    name: 'Recurso',
    components: {
        ConteudoRecursoFase1,
        ConteudoRecursoFase2,
        DesistenciaRecursal,
        Carregando,
    },
    mixins: [utils],
    data() {
        return {
            loading: true,
        };
    },
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
            dados: 'analise/recurso',
        }),
    },
    watch: {
        dadosProjeto(value) {
            this.buscarRecurso(value.idPronac);
        },
        dados() {
            this.loading = false;
        },
    },
    mounted() {
        if (typeof this.dadosProjeto.idPronac !== 'undefined') {
            this.buscarRecurso(this.dadosProjeto.idPronac);
        }
    },
    methods: {
        ...mapActions({
            buscarRecurso: 'analise/buscarRecurso',
        }),
    },
};
</script>
