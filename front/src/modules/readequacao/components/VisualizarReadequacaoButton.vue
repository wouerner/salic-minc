<template>
    <v-layout>
        <v-btn
            dark
            icon
            flat
            small
            color="#212121"
            @click.stop="dialog = true"
        >
            <v-tooltip bottom>
                <v-icon slot="activator">visibility</v-icon>
                <span>Visualizar Readequação</span>
            </v-tooltip>
        </v-btn>
        <v-dialog
            v-model="dialog"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
            @keydown.esc="dialog = false"
        >
            <v-card>
                <v-toolbar
                    dark
                    color="primary"
                    fixed
                >
                    <v-btn
                        icon
                        dark
                        @click="dialog = false"
                    >
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Readequação - {{ dadosReadequacao.dsTipoReadequacao }}</v-toolbar-title>
                    <v-spacer/>
                    <v-toolbar-title>{{ dadosProjeto.Pronac }} - {{ dadosProjeto.NomeProjeto }}</v-toolbar-title>
                </v-toolbar>

                <v-divider></v-divider>

                <v-layout
                    row
                    wrap
                    class="mt-5 pt-3"
                >
                    <v-flex xs5 offset-xs1>
                        <v-list two-line subheader>
                            <v-subheader inset>Dados da Solicitação</v-subheader>

                            <v-list-tile avatar>

                                <v-list-tile-avatar>
                                    <v-icon class="green lighten-1 white--text">person</v-icon>
                                </v-list-tile-avatar>

                                <v-list-tile-content>
                                    <v-list-tile-title>Nome do Solicitante</v-list-tile-title>
                                    <v-list-tile-sub-title>Beltrano Ciclano - {{dadosReadequacao.idSolicitante}} </v-list-tile-sub-title>
                                </v-list-tile-content>

                            </v-list-tile>
                            <v-list-tile avatar>

                                <v-list-tile-avatar>
                                    <v-icon class="green lighten-1 white--text">mode_comment</v-icon>
                                </v-list-tile-avatar>

                                <v-list-tile-content>
                                    <v-list-tile-title>Solicitação</v-list-tile-title>
                                    <v-list-tile-sub-title>{{dadosReadequacao.dsSolicitacao}}</v-list-tile-sub-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </v-list>
                    </v-flex>


                    <v-flex xs5>
                        <v-list two-line subheader>
                            <v-subheader inset></v-subheader>

                            <v-list-tile avatar>

                                <v-list-tile-avatar>
                                    <v-icon class="green lighten-1 white--text">date_range</v-icon>
                                </v-list-tile-avatar>

                                <v-list-tile-content>
                                    <v-list-tile-title>Data da Solicitação</v-list-tile-title>
                                    <v-list-tile-sub-title>{{dadosReadequacao.dtSolicitacao}}</v-list-tile-sub-title>
                                </v-list-tile-content>

                            </v-list-tile>
                            <v-list-tile avatar>

                                <v-list-tile-avatar>
                                    <v-icon class="green lighten-1 white--text">assignment</v-icon>
                                </v-list-tile-avatar>

                                <v-list-tile-content>
                                    <v-list-tile-title>Justificativa</v-list-tile-title>
                                    <v-list-tile-sub-title>{{dadosReadequacao.dsJustificativa}}</v-list-tile-sub-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </v-list>
                    </v-flex>

                    <v-flex xs5 offset-xs1>
                        <v-list two-line subheader>
                            <v-subheader inset>Dados da Avaliação</v-subheader>

                            <v-list-tile avatar>

                                <v-list-tile-avatar>
                                    <v-icon class="green lighten-1 white--text">person</v-icon>
                                </v-list-tile-avatar>

                                <v-list-tile-content>
                                    <v-list-tile-title>Nome do Avaliador</v-list-tile-title>
                                    <v-list-tile-sub-title>Avaliador - {{dadosReadequacao.idAvaliador}}</v-list-tile-sub-title>
                                </v-list-tile-content>

                            </v-list-tile>
                            <v-list-tile avatar>

                                <v-list-tile-avatar>
                                    <v-icon class="green lighten-1 white--text">rate_review</v-icon>
                                </v-list-tile-avatar>

                                <v-list-tile-content>
                                    <v-list-tile-title>Avaliação</v-list-tile-title>
                                    <v-list-tile-sub-title>{{dadosReadequacao.dsAvaliacao}}</v-list-tile-sub-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </v-list>
                    </v-flex>

                    <v-flex xs5>
                        <v-list two-line subheader>
                            <v-subheader inset></v-subheader>

                            <v-list-tile avatar>

                                <v-list-tile-avatar>
                                    <v-icon class="green lighten-1 white--text">date_range</v-icon>
                                </v-list-tile-avatar>

                                <v-list-tile-content>
                                    <v-list-tile-title>Data da Avaliação</v-list-tile-title>
                                    <v-list-tile-sub-title>{{dadosReadequacao.dtAvaliador}}</v-list-tile-sub-title>
                                </v-list-tile-content>

                            </v-list-tile>
                        </v-list>
                    </v-flex>

                        <!-- <v-expansion-panel
                            v-model="panel"
                            expand
                        >
                            <v-expansion-panel-content
                            >
                                <div
                                    slot="header"
                                    class="title"
                                >DADOS DA SOLICITAÇÃO</div>
                                <v-card>
                                    <v-flex xs4 sm2>
                                        <v-text-field
                                            :value="dadosReadequacao.dsSolicitacao"
                                            label="Solicitante"
                                            outline
                                            readonly
                                        >
                                        </v-text-field>
                                    </v-flex>
                                </v-card>
                                <v-card>
                                    <v-card-title class="subheading font-weight-bold">
                                        Justificativa
                                    </v-card-title>
                                    <v-card-text>
                                        <span v-html="dadosReadequacao.dsJustificativa"></span>
                                    </v-card-text>
                                </v-card>
                                <v-card>
                                    <v-card-title class="subheading font-weight-bold">
                                        Data de solicitação
                                    </v-card-title>
                                    <v-card-text>
                                        <span>{{ dadosReadequacao.dtSolicitacao }}</span>
                                    </v-card-text>
                                </v-card>
                            </v-expansion-panel-content>
                            <v-expansion-panel-content
                            >
                                <div
                                    slot="header"
                                    class="title"
                                >DADOS DA AVALIAÇÃO</div>
                                <v-card>
                                    <v-card-title
                                        class="subheading"
                                    >
                                        Dados
                                    </v-card-title>
                                    <v-card-text>
                                        <span class="subheading">{{ dadosReadequacao.dsAvaliacao }}</span>
                                        <span class="subheading">{{ dadosReadequacao.dtAvaliador }}</span>
                                    </v-card-text>
                                </v-card>
                            </v-expansion-panel-content>
                        </v-expansion-panel> -->
                </v-layout>
            </v-card>
        </v-dialog>
    </v-layout>
</template>
<script>
import { mapActions } from 'vuex';

export default {
    name: 'VisualizarReadequacaoButton',
    props: {
        obj: { type: Object, default: () => {} },
        dadosProjeto: { type: Object, default: () => {} },
        dadosReadequacao: { type: Object, default: () => {} },
    },
    data() {
        return {
            dialog: false,
            panel: [true, true],
        };
    },
    computed: {},
    methods: {
        ...mapActions({}),
    },
};
</script>
