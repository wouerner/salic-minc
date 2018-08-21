<template>
    <v-container grid-list-xl>
        <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
            <v-btn slot="activator" color="green" dark>Emitir Parecer</v-btn>
            <v-card>
                <v-toolbar dark color="green">
                    <v-btn icon dark @click.native="dialog = false">
                        <v-icon>close</v-icon>
                    </v-btn>

                    <v-toolbar-title>Avaliação Financeira - Emissão de Parecer</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn dark flat @click.native="dialog = false">Salvar</v-btn>
                    </v-toolbar-items>
                </v-toolbar>

                <v-container grid-list-sm>
                    <v-layout row wrap>
                        <v-flex xs12 sm12 md12>
                            <p><b>Projeto:</b> 20213465653 - QUALQUER NOME</p>
                        </v-flex>
                        <v-flex xs12 sm12 md12>
                            <p><b>Proponente:</b> 707.707.012-00 - Sr. Juquinha Amaral</p>
                        </v-flex>
                    </v-layout>
                    <v-divider></v-divider>
                </v-container>

                <h4 class="text-sm-center">Quantidade de Comprovantes</h4>
                <v-container grid-list-sm>
                    <v-layout row wrap>
                        <v-flex xs10 sm3 md3 >
                            <div>
                                <h4 class="label text-sm-right">Total</h4>
                                <p class="text-sm-right">20213465653</p>
                            </div>
                        </v-flex>
                        <v-flex xs10 sm3 md3>
                            <div>
                                <h4 class="label text-sm-right">Validados</h4>
                                <p class="text-sm-right">20213465653</p>
                            </div>
                        </v-flex>
                        <v-flex xs10 sm3 md3>
                            <div>
                                <h4 class="label text-sm-right">Recusados</h4>
                                <p class="text-sm-right">Sr. Juquinha Amaral</p>
                            </div>
                        </v-flex>
                        <v-flex xs10 sm3 md3>
                            <div>
                                <h4 class="label text-sm-right">Não Avaliados</h4>
                                <p class="text-sm-right">20213465653</p>
                            </div>
                        </v-flex>
                    </v-layout>
                    <v-divider></v-divider>
                </v-container>

                <h4 class="text-sm-center">Valores Comprovados</h4>
                <v-container grid-list-sm>
                    <v-layout row wrap>
                        <v-flex xs10 sm3 md3 >
                            <div>
                                <h4 class="label text-sm-right">Total</h4>
                                <p class="text-sm-right">20213465653</p>
                            </div>
                        </v-flex>
                        <v-flex xs10 sm3 md3>
                            <div>
                                <h4 class="label text-sm-right">Validados</h4>
                                <p class="text-sm-right">20213465653</p>
                            </div>
                        </v-flex>
                        <v-flex xs10 sm3 md3>
                            <div>
                                <h4 class="label text-sm-right">Recusados</h4>
                                <p class="text-sm-right">Sr. Juquinha Amaral</p>
                            </div>
                        </v-flex>
                        <v-flex xs10 sm3 md3>
                            <div>
                                <h4 class="label text-sm-right">Não Avaliados</h4>
                                <p class="text-sm-right">20213465653</p>
                            </div>
                        </v-flex>
                    </v-layout>
                    <v-divider></v-divider>
                </v-container>

                <v-container grid-list>
                    <v-layout wrap align-center>
                        <v-flex>
                            <v-select height="20px"
                                      v-model="item"
                                      :items="items"
                                      item-text="text"
                                      item-value="id"
                                      box
                                      label="Manifestação"
                            ></v-select>
                        </v-flex>
                    </v-layout>
                    <v-flex>
                        <v-textarea

                            color="deep-purple"
                            label="Parecer"
                            height="200px"
                        ></v-textarea>
                    </v-flex>
                </v-container>
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
                texto: '',
                item:'',
                items: [{ 'id':  'R', 'text':'Reprovação' }, { 'id': 'A','text':'Aprovação' }, {'id' : 'P', 'text' :'Aprovação com Ressalva'}],
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
