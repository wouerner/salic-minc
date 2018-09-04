<template>
        <v-container>
            <v-layout row>
        <v-flex xs12 sm8 offset-sm2>
            <v-card>
                <v-card-text>
                    <table class="v-datatable v-table">
                        <tr>
                            <th>
                                Dt.Envio Prestacao de Contas
                            </th>
                            <th>
                                Resultado da Avaliacao do Objeto
                            </th>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Cumpriu objeto e objetivos</td>
                        </tr>
                    </table>
                </v-card-text>
            </v-card>


            <v-card>
                <v-card-text>
                <table>
                    <tr>
                        <th>
                            Valores
                        </th>
                        <th>
                            Quantidade de Comprovantes por nivel de confianca
                        </th>
                    </tr>
                    <tr>
                        <td>Captado	</td>
                        <td>Aprovado</td>
                        <td>Todos</td>
                        <td>90%</td>
                        <td>95%</td>
                        <td>99%</td>
                    </tr>
                </table>
                </v-card-text>
            </v-card>



            <v-card>
                <v-card-text>
                <fieldset>
                    <legend>SELECIONAR O TIPO DE AVALIACAO FINANCERIA</legend>
                    <p>Avaliar comprovantes por nivel de confianca:</p>
                        <v-flex xs12 sm6 md6>
                            <v-radio-group v-model="ex7" column>

                                <v-radio
                                        label="Todos Comprovantes"
                                        color="cyan darken-2"
                                        value="todos comprovantes"
                                ></v-radio>
                                <v-radio
                                        label="90%"
                                        color="teal darken-1"
                                        value="90%"
                                ></v-radio>
                                <v-radio
                                        label="95%"
                                        color="teal darken-1"
                                        value="95%"
                                ></v-radio>
                                <v-radio
                                        label="99%"
                                        color="teal darken-1"
                                        value="99%"
                                ></v-radio>

                            </v-radio-group>

                                <v-btn dark large color="teal darken-1">AVALIAR</v-btn>

                        </v-flex>
                </fieldset>
                </v-card-text>
            </v-card>
        </v-flex>
            </v-layout>
        </v-container>


</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import ModalTemplate from '@/components/modal';

export default {
    name: 'Painel',
    data() {
        return {
            data: [
                {
                    value: false,
                    name: '',
                    tb:'',
                },
                {
                    value: false,
                    tb:'',
                    name:'',
                }
            ]
        };
    },
    components: {
        ModalTemplate,
    },
    methods: {
        ...mapActions({
            criarRegistro: 'foo/criarRegistro',
            modalOpen: 'modal/modalOpen',
            modalClose: 'modal/modalClose',
        }),
        fecharModal() {
            // eslint-disable-next-line
            $3('#modalTemplate').modal('close');
            this.modalClose();
        },
    },
    computed: mapGetters({
        modalVisible: 'modal/default',
    }),
};
</script>

