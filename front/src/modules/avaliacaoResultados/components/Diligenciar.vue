<template>
    <v-container grid-list-xl>
        <v-form ref="form">
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
                            <h2>{{projeto.AnoProjeto}}{{projeto.Sequencial}} - {{projeto.NomeProjeto}}</h2>
                        </v-flex>
                    </v-layout>
                    <v-divider></v-divider>
                </v-container>
                <v-container grid-list>
                    <v-layout row wrap>
                        <v-flex>
                            <h3>Tipo de Diligencia</h3>
                        </v-flex>
                    </v-layout>
                    <v-divider></v-divider>
                    <v-layout wrap align-center>
                        <v-flex>
                            <p>
                                <input :value="174"
                                       type="radio"
                                       id="item1" />
                                <label for="item1">
                                    Somente itens recusados
                                </label>
                            </p>
                            <p>
                                <input :value="645"
                                       type="radio"
                                       id="item2" />
                                <label for="item2">
                                    Todos os itens or&ccedil;amentarios
                                </label>
                            </p>
                        </v-flex>
                    </v-layout>
                        <v-flex>
                            <v-textarea label="Solicitação"
                                        color="green"
                                        height="50px"></v-textarea>
                        </v-flex>
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
                requestEmissaoParecer: 'avaliacaoResultados/getDadosEmissaoParecer',
                salvar: 'avaliacaoResultados/salvarDiligencia',
            }),
            getConsolidacao(id) {
                this.requestEmissaoParecer(id);
            },
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
            }),
        },
        created() {
            this.getConsolidacao(this.idPronac);
        },
    };
</script>
