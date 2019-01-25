<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Carregando Aprovação'"/>
        </div>
        <div v-else-if="dados.Aprovacao">
            <v-expansion-panel popout>
                <v-expansion-panel-content
                    v-for="(dado, index) in dados.Aprovacao"
                    :key="index"
                    class="elevation-1"
                >
                    <v-layout
                        slot="header"
                        class="primary--text">
                        <v-icon class="mr-3 primary--text">subject</v-icon>
                        <span v-html="dado.TipoAprovacao"/>
                    </v-layout>
                    <v-container fluid>
                        <v-card
                            class="elevation-2"
                            color="grey lighten-4">
                            <v-card-text class="pl-5">
                                <v-container
                                    grid-list-md
                                    text-xs-left>
                                    <v-layout
                                        justify-space-around
                                        row
                                        wrap>
                                        <v-flex
                                            lg12
                                            dark
                                            class="text-xs-left">
                                            <b><h4>PORTARIA / DATAS</h4></b>
                                            <v-divider class="pb-2"/>
                                        </v-flex>
                                        <v-flex>
                                            <p><b>Tipo</b></p>
                                            <p v-html="dado.TipoAprovacao"/>
                                        </v-flex>
                                        <v-flex>
                                            <p><b>Dt. Aprovação</b></p>
                                            <p>
                                                {{ dado.DtAprovacao | formatarData }}
                                            </p>
                                        </v-flex>
                                        <v-flex>
                                            <p><b>Portaria</b></p>
                                            <p>
                                                {{ dado.PortariaAprovacao }}
                                            </p>
                                        </v-flex>
                                        <v-flex>
                                            <p><b>Dt. Portaria</b></p>
                                            <p>
                                                {{ dado.DtPortariaAprovacao | formatarData }}
                                            </p>
                                        </v-flex>
                                        <v-flex>
                                            <p><b>Dt. Publicação</b></p>
                                            <p>
                                                {{ dado.DtPublicacaoAprovacao | formatarData }}
                                            </p>
                                        </v-flex>
                                    </v-layout>
                                    <v-layout
                                        justify-space-around
                                        row
                                        wrap>
                                        <v-flex
                                            lg12
                                            dark
                                            class="text-xs-left">
                                            <b><h4>PERÍODO DE CAPTAÇÃO</h4></b>
                                            <v-divider class="pb-2"/>
                                        </v-flex>
                                        <v-flex>
                                            <p><b>Dt. Início</b></p>
                                            <p>
                                                {{ dado.DtInicioCaptacao | formatarData }}
                                            </p>
                                        </v-flex>
                                        <v-flex>
                                            <p><b>Dt. Fim</b></p>
                                            <p>
                                                {{ dado.DtFimCaptacao | formatarData }}
                                            </p>
                                        </v-flex>
                                    </v-layout>
                                    <v-layout
                                        justify-space-around
                                        row
                                        wrap>
                                        <v-flex
                                            lg12
                                            dark
                                            class="text-xs-left">
                                            <b><h4>SÍNTESE APROVAÇÃO</h4></b>
                                            <v-divider class="pb-2"/>
                                        </v-flex>
                                        <v-flex>
                                            <p v-html="dado.ResumoAprovacao"/>
                                        </v-flex>
                                    </v-layout>
                                    <div v-if="dado.AprovadoReal > 0">
                                        <v-layout
                                            justify-space-around
                                            row
                                            wrap>
                                            <v-flex
                                                lg12
                                                dark
                                                class="text-xs-left">
                                                <b><h4>MECENATO</h4></b>
                                                <v-divider class="pb-2"/>
                                            </v-flex>
                                            <v-flex>
                                                <p><b>Vl. Aprovação</b></p>
                                                <b>
                                                    <p>
                                                        {{
                                                            converterParaMoedaPontuado(dado.AprovadoReal)
                                                        }}
                                                    </p>
                                                </b>
                                            </v-flex>
                                        </v-layout>
                                    </div>
                                </v-container>
                            </v-card-text>
                        </v-card>
                    </v-container>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </div>
    </div>
</template>
<script>

import { mapActions, mapGetters } from 'vuex';
import Carregando from '@/components/CarregandoVuetify';
import { utils } from '@/mixins/utils';

export default {
    name: 'Aprovacao',
    components: {
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
            dados: 'projeto/aprovacao',
        }),
    },
    watch: {
        dados() {
            this.loading = false;
        },
    },
    mounted() {
        if (typeof this.dadosProjeto.idPronac !== 'undefined') {
            this.buscarAprovacao(this.dadosProjeto.idPronac);
        }
    },
    methods: {
        ...mapActions({
            buscarAprovacao: 'projeto/buscarAprovacao',
        }),
    },
};
</script>
