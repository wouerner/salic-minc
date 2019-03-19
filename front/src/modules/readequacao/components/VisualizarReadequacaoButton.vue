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
                <v-layout
                    row
                    wrap
                    class="mt-5 pt-3"
                >
                    <v-flex
                        xs10
                        offset-xs1
                    >
                        <v-expansion-panel
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
                                    <v-card-title class="subheading font-weight-bold">
                                        Solicitação
                                    </v-card-title>
                                    <v-card-text>
                                        <span v-html="dadosReadequacao.dsSolicitacao"></span>
                                    </v-card-text>
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
                        </v-expansion-panel>
                    </v-flex>
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
