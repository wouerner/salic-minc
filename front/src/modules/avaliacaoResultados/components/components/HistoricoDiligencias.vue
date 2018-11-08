<template>

    <v-layout row justify-center>
        <v-dialog v-model="dialog"
                  full-width
                  scrollable
                  fullscreen
        >
            <v-tooltip slot="activator" bottom>
                <v-btn slot="activator" flat icon @click.native="obterDiligencias(idPronac);">
                    <v-icon class="material-icons">assignment_late</v-icon>
                </v-btn>
                <span>Histórico de Diligências </span>
            </v-tooltip>

            <v-card>

                <v-toolbar dark color="green">
                    <v-btn icon dark @click.native="dialog = false">
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Diligências do Projeto</v-toolbar-title>
                </v-toolbar>

                <v-divider></v-divider>
                <v-card-text>
                    <v-timeline >
                        <v-timeline-item
                            v-for="(item, i) in sortByDate(diligencias.items)"
                            :key="i"
                            small
                        >
     <span
                            slot="opposite"
                            :class="`headline font-weight-bold green--text`"
                            v-text="year.year"
                        ></span>></span>
                            <v-card
                                color="#468847"
                            >
                                <v-card-title class="title">{{item.tipoDiligencia}}</v-card-title>
                                <v-card-text class="white text--primary">
                                    <div>
                                        Projeto: {{item.nomeProjeto}}
                                        produto: {{item.produto}}
                                        Pronac: {{item.pronac}}
                                    </div>
                                    <v-btn
                                        class="mx-0"
                                        outline
                                        color="red"
                                        v-on:click="mostrarSolicitacao(i)"
                                        v-if="item.Solicitacao"
                                    >
                                        Solicitação
                                    </v-btn>
                                    <v-btn
                                        class="mx-0"
                                        outline
                                        color="red"
                                        v-on:click="mostrarResposta(i)"
                                        v-if="item.Resposta"
                                    >
                                        Resposta
                                    </v-btn>


                                        <div v-if="show.solicitacao && show.index === i" v-html="item.Solicitacao"></div>
                                        <div v-if="show.resposta && show.index === i" v-html="item.Resposta"></div>

                                </v-card-text>
                            </v-card>


                        </v-timeline-item>
                    </v-timeline>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-layout>

</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import CarregarTemplateAjax from '../../../../components/CarregarTemplateAjax';

export default {
    name: 'HistoricoDiligencias',
    components: { CarregarTemplateAjax },
    props: { idPronac: Object },
    data() {
        return {
            dialog: false,
            show: {
              solicitacao: false,
              resposta: false,
              index: '',
            },
        };
    },
    methods: {
        ...mapActions({
            obterDiligencias: 'avaliacaoResultados/obetDadosDiligencias',
        }),
        mostrarSolicitacao(index){
            this.show.solicitacao = !this.show.solicitacao;
            this.show.index = index;
        },
        mostrarResposta(index){
            this.show.resposta = !this.show.resposta;
            this.show.index = index;
        },
        sortByDate: function (list) {
            return _.orderBy(list, 'dataSolicitacao', 'desc');
        }
    },
    computed: {
        ...mapGetters({
            diligencias: 'avaliacaoResultados/diligenciasHistorico',
        }),
    },
};
</script>

