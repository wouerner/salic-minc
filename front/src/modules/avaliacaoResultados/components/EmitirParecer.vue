<template>
    <v-container grid-list-xl>
        <v-form v-model="valid">
            <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
                <v-btn slot="activator" color="green" dark>Emitir Parecer</v-btn>
                <v-card>
                    <v-toolbar dark color="green">
                        <v-btn icon dark :href="redirectLink">
                            <v-icon>close</v-icon>
                        </v-btn>

                        <v-toolbar-title>Avaliação Financeira - Emissão de Parecer</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                            <v-btn dark flat @click.native="dialog = false" :disabled="!valid">Salvar</v-btn>
                        </v-toolbar-items>
                    </v-toolbar>

                    <v-container grid-list-sm>
                        <v-layout row wrap>
                            <v-flex xs12 sm12 md12>
                                <p><b>Projeto:</b> {{consolidacao.items.IdPronac}} -  {{consolidacao.items.NomeProjeto}}</p>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                                <p><b>Proponente:</b> {{consolidacao.items.CnpjCpf}} - {{consolidacao.items.Proponente}}</p>
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
                                    <p class="text-sm-right">{{consolidacao.items.qtTotalComprovante}}</p>
                                </div>
                            </v-flex>
                            <v-flex xs10 sm3 md3>
                                <div>
                                    <h4 class="label text-sm-right">Validados</h4>
                                    <p class="text-sm-right">{{consolidacao.items.qtComprovantesValidadosProjeto}}</p>
                                </div>
                            </v-flex>
                            <v-flex xs10 sm3 md3>
                                <div>
                                    <h4 class="label text-sm-right">Recusados</h4>
                                    <p class="text-sm-right">{{consolidacao.items.qtComprovantesRecusadosProjeto}}</p>
                                </div>
                            </v-flex>
                            <v-flex xs10 sm3 md3>
                                <div>
                                    <h4 class="label text-sm-right">Não Avaliados</h4>
                                    <p class="text-sm-right">{{consolidacao.items.qtComprovantesNaoAvaliados}}</p>
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
                                    <p class="text-sm-right">{{consolidacao.items.vlComprovadoProjeto}}</p>
                                </div>
                            </v-flex>
                            <v-flex xs10 sm3 md3>
                                <div>
                                    <h4 class="label text-sm-right">Validados</h4>
                                    <p class="text-sm-right">{{consolidacao.items.vlComprovadoValidado}}</p>
                                </div>
                            </v-flex>
                            <v-flex xs10 sm3 md3>
                                <div>
                                    <h4 class="label text-sm-right">Recusados</h4>
                                    <p class="text-sm-right">{{consolidacao.items.vlComprovadoRecusado}}</p>
                                </div>
                            </v-flex>
                            <v-flex xs10 sm3 md3>
                                <div>
                                    <h4 class="label text-sm-right">Não Avaliados</h4>
                                    <p class="text-sm-right">{{consolidacao.items.vlNaoComprovado}}</p>
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
                                          :rules="itemRules"
                                          :items="items"
                                          item-text="text"
                                          item-value="id"
                                          box
                                          label="Manifestação *"
                                          required="required"
                                ></v-select>
                            </v-flex>
                        </v-layout>
                        <v-flex>
                            <v-textarea
                                v-model="parecer"
                                :rules="parecerRules"
                                color="deep-purple"
                                label="Parecer *"
                                height="200px"
                                required="required"
                            ></v-textarea>
                        </v-flex>
                    </v-container>
                </v-card>

            </v-dialog>
        </v-form>
    </v-container>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import ModalTemplate from '@/components/modal';
    // import Parecer from '../mocks/Parecer.json';

    export default {
        name: 'UpdateBar',
        data()
        {
            return {
                // mock: Parecer,
                idPronac: this.$route.params.id,
                redirectLink: '/prestacao-contas/realizar-prestacao-contas/index/idPronac/',
                valid: false,
                dialog: true,
                itemRules: [
                    v => !!v || 'Tipo de manifestação e obrigatório!'
                ],
                parecerRules: [
                    v => !!v || 'Parecer e obrigatório!',
                    v => v.length >= 10 || 'Parecer deve conter mais que 10 characters'
                ],
                parecer: '',
                item: '',
                items: [{ id:  'R', text:'Reprovação' }, { id: 'A',text:'Aprovação' }, {id : 'P', text:'Aprovação com Ressalva'}],
            };
        },
        components:
            {
                ModalTemplate,
            },
        methods:
            {
                ...mapActions({
                    modalOpen: 'modal/modalOpen',
                    modalClose: 'modal/modalClose',
                    requestConsolidacao: 'avaliacaoResultados/getComconsolidacaoParecer',

                }),
                fecharModal()
                {
                    this.modalClose();
                },
                getConsolidacao(id)
                {
                    this.requestConsolidacao(id);
                },
            },
        computed:
            {
                ...mapGetters({
                    modalVisible: 'modal/default',
                    consolidacao: 'avaliacaoResultados/consolidacao',
                }),
            },
        mounted()
        {
            this.redirectLink = this.redirectLink + this.idPronac;
            this.getConsolidacao(this.idPronac);
        },
    };
</script>
