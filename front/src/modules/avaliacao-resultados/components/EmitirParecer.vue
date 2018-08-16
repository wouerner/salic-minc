<template>
    <v-container fluid grid-list-xl>
        <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
            <v-btn slot="activator" color="primary" dark>Open Dialog</v-btn>
            <v-card>

                <v-toolbar dark color="primary">
                    <v-btn icon dark @click.native="dialog = false">
                        <v-icon>close</v-icon>
                    </v-btn>

                    <v-toolbar-title>Avaliação Financeira - Emissão de Parecer</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn dark flat @click.native="dialog = false">Save</v-btn>
                    </v-toolbar-items>
                </v-toolbar>

                <v-list subheader>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap>
                            <v-flex xs12 sm4 md2 offset-lg2>
                                <v-subheader>PRONAC</v-subheader>
                                <div>20213465653</div>
                            </v-flex>
                            <v-flex xs12 sm4 md2>
                                <v-subheader>Nome do Projeto</v-subheader>
                                <div>20213465653</div>
                            </v-flex>
                            <v-flex xs12 sm4 md2>
                                <v-subheader>Proponente</v-subheader>
                                <div>Sr. Juquinha Amaral</div>
                            </v-flex>
                            <v-flex xs12 sm4 md2>
                                <v-subheader>CPF / CNPJ </v-subheader>
                                <div>20213465653</div>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-list>

                <v-divider></v-divider>

                <h4 class="text-sm-center">Quantidade de Comprovantes</h4>
                <v-list>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap>
                            <v-flex xs12 sm3 md2 >
                                <div>
                                    <h4 class="label text-sm-right">Total</h4>
                                    <p class="text-sm-right">20213465653</p>
                                </div>
                            </v-flex>
                            <v-flex xs12 sm3 md2>
                                <div>
                                    <h4 class="label text-sm-right">Validos</h4>
                                    <p class="text-sm-right">20213465653</p>
                                </div>
                            </v-flex>
                            <v-flex xs12 sm3 md2>
                                <div>
                                    <h4 class="label text-sm-right">Recusados</h4>
                                    <p class="text-sm-right">Sr. Juquinha Amaral</p>
                                </div>
                            </v-flex>
                            <v-flex xs12 sm3 md2>
                                <div>
                                    <h4 class="label text-sm-right">Não Avaliados</h4>
                                    <p class="text-sm-right">20213465653</p>
                                </div>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-list>

                <v-divider></v-divider>

                <h4 class="text-sm-center">Valores Comprovados</h4>
                <v-list>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap>
                            <v-flex xs12 sm3 md2>
                                <h4 class="label text-sm-right">Total</h4>
                                <p class="text-sm-right">20213465653</p>
                            </v-flex>
                            <v-flex xs12 sm3 md2>
                                <h4 class="label text-sm-right">Validos</h4>
                                <p class="text-sm-right">20213465653</p>
                            </v-flex>
                            <v-flex xs12 sm3 md2>
                                <h4 class="label text-sm-right">Recusados</h4>
                                <p class="text-sm-right">Sr. Juquinha Amaral</p>
                            </v-flex>
                            <v-flex xs12 sm3 md2>
                                <h4 class="label text-sm-right">Não Avaliados</h4>
                                <p class="text-sm-right">20213465653</p>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-list>

                <v-layout wrap align-center>
                    <v-flex xs12 sm12 d-flex>
                        <v-select height="20px"
                                  :items="items"
                                  box
                                  label="Manifestação"
                        ></v-select>
                    </v-flex>
                </v-layout>

            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import ModalTemplate from '@/components/modal';

    export default {
        name: 'UpdateBar',
        data() {
            return {

                dialog: false,

                currentRegistro: {
                    Codigo: '',
                    DadoNr: '',
                },
                items: [{'Reprovação':'R'}, {'Aprovação':'A'},{'Aprovação com Ressalva':'P'}]
            };
        },
        props: ['registroAtivo'],
        components: {
            ModalTemplate,
        },
        methods: {
            ...mapActions({
                atualizarRegistro: 'foo/atualizarRegistro',
                setRegistroAtivo: 'foo/setRegistroAtivo',
                modalOpen: 'modal/modalOpen',
                modalClose: 'modal/modalClose',
            }),
            buildRegistro(event) {
                const DadoNr = event.target.value;
                this.currentRegistro.DadoNr = DadoNr;
                this.currentRegistro.Codigo = this.registro.Codigo;
            },
            checkChangesAndUpdate() {
                if (this.currentRegistro !== this.registro) {
                    this.atualizarRegistro(this.currentRegistro);
                }
            },
            fecharModal() {
                // eslint-disable-next-line
                $3('#modalTemplate').modal('close');
                this.modalClose();
            },
            alert() {
                alert('teste');
            },
        },
        computed: {
            ...mapGetters({
                registro: 'foo/registro',
                modalVisible: 'modal/default',
            }),
        },
    };
</script>

<style scoped>
    .label{
        color: rgba(0,0,0,.54);
        font-size: 14px;
        font-weight: 500;
        text-align-all: right;
    }
</style>
