<template>
    <v-container grid-list-xl>
        <v-form ref="form" v-model="valid">
            <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
                <v-toolbar dark color="green">
                        <v-toolbar-title>Diligenciar</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                            <v-btn dark flat @click.native="enviarDiligencia()">Enviar</v-btn>
                            <v-btn dark flat :href="'voltar'">Cancelar</v-btn>
                        </v-toolbar-items>
                </v-toolbar>
                <v-container grid-list-sm>
                    <v-layout row wrap>
                        <v-flex xs12 sm12 md12>
                            <h3>{{projeto.AnoProjeto}}{{projeto.Sequencial}} - {{projeto.nomeProjeto}}</h3>
                        </v-flex>
                    </v-layout>
                    <v-divider></v-divider>
                </v-container>
                <v-container grid-list>
                    <v-layout wrap align-center>
                        <v-flex>
                            <p><b>Tipo de Diligencia</b></p>
                        </v-flex>
                        <v-flex>
                            <p>
                                <input v-model="diligencia.tpDiligencia"
                                       :value="174"
                                       type="radio"
                                       id="test1"
                                       label="Somente itens recusados" />
                                <!-- <label for="test1">
                                    Somente itens recusados
                                </label> -->
                            </p>
                            <p>
                                <input v-model="diligencia.tpDiligencia"
                                       :value="645"
                                       type="radio"
                                       id="test2"
                                       label="Todos os itens or&ccedil;amentarios" />
                                <!-- <label for="test2">
                                    Todos os itens or&ccedil;amentarios
                                </label> -->
                            </p>
                        </v-flex>
                        <v-flex>
                            <v-textarea v-model="diligencia.solicitacao"
                                        id="solicitacao"
                                        label="Solicita&ccedil;&atilde;o">
                            </v-textarea>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-dialog>
        </v-form>
    </v-container>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';

    export default {
        data() {
            return {
                idPronac: this.$route.params.id,
                dialog: true,
            };
        },
        methods:
        {
            ...mapActions({
                salvar: 'avaliacaoResultados/salvarDiligencia',
                getDiligencia: 'avaliacaoResultados/getDiligencia',
            }),
            enviarDiligencia() {
                const data = {
                    idPronac: this.idPronac,
                    tpDiligencia: this.tpDiligencia,
                    dssolicitacao: this.solicitacao,
                };

                this.salvar(data);
                /** Descomentar linha após migração da lista para o VUEJS */
                // this.dialog = false;
            },
        },
        computed:
        {
            ...mapGetters({
                projeto: 'avaliacaoResultados/projeto',
                diligencia: 'avaliacaoResultados/diligencia',
            }),
        },
    };
</script>
