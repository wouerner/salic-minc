<template>
    <div>
        <table class="tabela" v-if="Object.keys(diligencias).length > 0">
            <thead>
            <tr class="destacar">
                <th>VISUALIZAR</th>
                <th>NR PROPOSTA</th>
                <th>DATA DA SOLICITA&Ccedil;&Atilde;O</th>
            </tr>
            </thead>
            <tbody v-for="(diligencia, index) in diligencias" :key="index">
            <tr>
                <td class="center">
                    <v-layout row justify-center>
                        <v-dialog v-model="dialog"
                                  max-width="1350"
                                  transition="dialog-bottom-transition"
                        >
                            <v-btn outline
                                   slot="activator"
                                   color="green"
                            >
                                {{ dadosProjeto.NomeProjeto }}
                            </v-btn>
                            <v-card>
                                <v-card-title class="headline">{{ dadosProjeto.NomeProjeto }}</v-card-title>
                                <v-card-text>

                                    <!--Let Google help apps determine location. This means sending anonymous location data to-->
                                    <!--Google, even when no apps are running.-->

                                    <!--Let Google help apps determine location. This means sending anonymous location data to-->
                                    <!--Google, even when no apps are running.-->

                                    <!--Let Google help apps determine location. This means sending anonymous location data to-->
                                    <!--Google, even when no apps are running.-->

                                    <!--Let Google help apps determine location. This means sending anonymous location data to-->
                                    <!--Google, even when no apps are running.-->

                                    <!--Let Google help apps determine location. This means sending anonymous location data to-->
                                    <!--Google, even when no apps are running.-->
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="green darken-1" flat @click.native="dialog = false">OK</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-layout>
                    <!--<button-->
                            <!--class="waves-effect waves-darken btn white black-text"-->
                            <!--@click="setAbaAtiva(diligencia, index)"-->
                    <!--&gt;-->
                        <!--<i class="material-icons">visibility</i>-->
                    <!--</button>-->
                </td>
                <td>{{ diligencia.idPreprojeto }}</td>
                <td>{{ diligencia.dataSolicitacao }}</td>
            </tr>
            <tr v-if="abaAtiva === index && ativo && Object.keys(dadosDiligencia).length > 2">
                <td colspan="3">
                    <template>
                        <table class="tabela">
                            <tbody>
                            <tr>
                                <th>Nr PROPOSTA</th>
                                <th>NOME DA PROPOSTA</th>
                            </tr>
                            <tr>
                                <td>{{ dadosDiligencia.idPreprojeto }}</td>
                                <td>{{ dadosDiligencia.nomeProjeto }}</td>
                            </tr>
                            <tr>
                                <th>DATA DA SOLICITA&Ccedil;&Atilde;O</th>
                                <th>DATA DA RESPOSTA</th>
                            </tr>
                            <tr>
                                <td>{{ dadosDiligencia.dataSolicitacao }}</td>
                                <td>{{ dadosDiligencia.dataResposta }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <table v-if="dadosDiligencia.Solicitacao" class="tabela">
                            <tbody>
                            <tr>
                                <th>SOLICITA&Ccedil;&Atilde;O</th>
                            </tr>
                            <tr>
                                <td style="padding-left: 20px" v-html="dadosDiligencia.Solicitacao"></td>
                            </tr>
                            </tbody>
                        </table>
                        <table v-if="dadosDiligencia.Resposta" class="tabela">
                            <tbody>
                            <tr>
                                <th>RESPOSTA:</th>
                            </tr>
                            <tr>
                                <td style="padding-left: 20px" v-html="dadosDiligencia.Resposta"></td>
                            </tr>
                            </tbody>
                        </table>
                    </template>
                </td>
            </tr>
            </tbody>
        </table>
        <div v-else class="center">
            <em>Dados n&atilde;o informado.</em>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: 'VisualizarDiligenciaProposta',
        props: ['idPronac', 'diligencias'],
        data() {
            return {
                dialog: false,
                abaAtiva: -1,
                ativo: false,
            };
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dadosDiligencia: 'projeto/diligenciaProposta',
            }),
        },
        methods: {
            setAbaAtiva(value, index) {
                if (this.abaAtiva === index) {
                    this.ativo = !this.ativo;
                } else {
                    this.abaAtiva = index;
                    this.ativo = true;
                    this.buscarDiligenciaProposta(value);
                }
            },
            ...mapActions({
                buscarDiligenciaProposta: 'projeto/buscarDiligenciaProposta',
            }),
        },
    };
</script>

