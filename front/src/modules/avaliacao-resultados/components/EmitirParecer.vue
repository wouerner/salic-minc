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
                            <v-flex xs12 sm4 md2>
                                <v-subheader> <v-icon>assignment</v-icon> PRONAC</v-subheader>
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

                <v-list> Quantidade de Comprovantes
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap>
                            <v-flex xs12 sm4 md2>
                                <v-subheader>Total</v-subheader>
                                <div>20213465653</div>
                            </v-flex>
                            <v-flex xs12 sm4 md2>
                                <v-subheader>Validos</v-subheader>
                                <div>20213465653</div>
                            </v-flex>
                            <v-flex xs12 sm4 md2>
                                <v-subheader>Recusados</v-subheader>
                                <div>Sr. Juquinha Amaral</div>
                            </v-flex>
                            <v-flex xs12 sm4 md2>
                                <v-subheader>Não Avaliados</v-subheader>
                                <div>20213465653</div>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-list>

                <v-divider></v-divider>

                <v-list> Quantidade de Comprovantes
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap>
                            <v-flex xs12 sm4 md2>
                                <v-subheader>Total</v-subheader>
                                <div>20213465653</div>
                            </v-flex>
                            <v-flex xs12 sm4 md2>
                                <v-subheader>Validos</v-subheader>
                                <div>20213465653</div>
                            </v-flex>
                            <v-flex xs12 sm4 md2>
                                <v-subheader>Recusados</v-subheader>
                                <div>Sr. Juquinha Amaral</div>
                            </v-flex>
                            <v-flex xs12 sm4 md2>
                                <v-subheader>Não Avaliados</v-subheader>
                                <div>20213465653</div>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-list>

                <v-list three-line subheader>
                    <v-subheader>General</v-subheader>
                    <v-list-tile avatar>
                        <v-list-tile-action>
                            <v-checkbox v-model="notifications"></v-checkbox>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>Notifications</v-list-tile-title>
                            <v-list-tile-sub-title>Notify me about updates to apps or games that I downloaded</v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile avatar>
                        <v-list-tile-action>
                            <v-checkbox v-model="sound"></v-checkbox>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>Sound</v-list-tile-title>
                            <v-list-tile-sub-title>Auto-update apps at any time. Data charges may apply</v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile avatar>
                        <v-list-tile-action>
                            <v-checkbox v-model="widgets"></v-checkbox>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>Auto-add widgets</v-list-tile-title>
                            <v-list-tile-sub-title>Automatically add home screen widgets</v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>

                <v-layout wrap align-center>
                    <v-flex xs12 sm12 d-flex>
                        <v-select height="20px"
                                  :items="items"
                                  box
                                  label="Box style"
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
                notifications: false,
                sound: true,
                widgets: false,
                currentRegistro: {
                    Codigo: '',
                    DadoNr: '',
                },
                items: ['pedro', 'leo']
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
