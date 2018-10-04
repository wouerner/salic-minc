<template>
    <v-dialog
        v-model="dialog"
        fullscreen
        hide-overlay
    >
        <v-btn slot="activator" color="success">CONSOLIDAÇÃO</v-btn>
        <v-card>
            <!-- <h2>{{ nomeProjeto }}</h2> -->
            <div>
                <v-expansion-panel class="mt-2">
                    <v-expansion-panel-content>
                        <div slot="header"></div>
                        <v-card>
                            <v-card-text>
                                <table>
                                    <tr>
                                        <th>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                    </tr>

                                </table>
                            </v-card-text>
                        </v-card>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </div>
            <v-btn color="red" @click="dialog = false" flat block>FECHAR</v-btn>
        </v-card>
    </v-dialog>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: 'ConsolidacaoAnalise',
        data() {
            return {
                dialog: false,
            };
        },
        props: {
            idPronac: Number,
            nomeProjeto: String,
        },
        computed: {
            ...mapGetters({
                getConsolidacaoAnalise: 'avaliacaoResultados/consolidacaoAnalise',
            }),
        },
        mounted() {
            this.setConsolidacaoAnalise(this.idPronac);
        },
        methods: {
            ...mapActions({
                setConsolidacaoAnalise: 'avaliacaoResultados/consolidacaoAnalise',
            }),
        },
    };
</script>
