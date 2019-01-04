<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Contas Bancárias'"></Carregando>
        </div>
        <div v-else>
            <v-card>
                <v-subheader class="justify-center">
                    <div>
                        <h4 class="display-1 grey--text text--darken-4 font-weight-light">
                            Dados da Conta
                        </h4>
                    </div>
                </v-subheader>
                <v-container>
                    <v-layout>
                        <v-flex xs6 offset-xs2>
                            <br>
                            <p><b>Banco</b></p>
                            <p>{{ dadosConta.Banco }}</p>
                        </v-flex>
                        <v-flex xs6 offset-xs2>
                            <br>
                            <p><b>Agência</b></p>
                            <p>{{ dadosConta.Agencia }}</p>
                        </v-flex>
                    </v-layout>
                </v-container>

                <v-subheader class="justify-center">
                    <div>
                        <h4 class="display-1 grey--text text--darken-4 font-weight-light">
                            Conta Captação
                        </h4>
                    </div>
                </v-subheader>
                <v-container>
                    <v-layout>
                        <v-flex xs4>
                            <br>
                            <p><b>Número</b></p>
                            <p>{{ dadosConta.ContaBloqueada }}</p>
                        </v-flex>
                        <v-flex xs4>
                            <br>
                            <p><b>Dt. Abertura</b></p>
                            <p v-if="dadosConta.DtLoteRemessaCB">
                                {{ dadosConta.DtLoteRemessaCB | FormatarData }}
                            </p>
                            <p v-else> - </p>
                        </v-flex>
                        <v-flex xs4>
                            <br>
                            <p><b>Ocorrência</b></p>
                            <p v-if="dadosConta.OcorrenciaCB">{{ dadosConta.OcorrenciaCB }}</p>
                            <p v-else> - </p>
                        </v-flex>
                    </v-layout>
                </v-container>

                <v-subheader class="justify-center">
                    <div>
                        <h4 class="display-1 grey--text text--darken-4 font-weight-light">
                            Conta Movimento
                        </h4>
                    </div>
                </v-subheader>
                <v-container>
                    <v-layout>
                        <v-flex xs4>
                            <br>
                            <p><b>Número</b></p>
                            <p>{{ dadosConta.ContaLivre }}</p>
                        </v-flex>
                        <v-flex xs4>
                            <br>
                            <p><b>Dt. Abertura</b></p>
                            <p v-if="dadosConta.DtLoteRemessaCL">
                                {{ dadosConta.DtLoteRemessaCL | FormatarData}}
                            </p>
                            <p v-else> - </p>
                        </v-flex>
                        <v-flex xs4>
                            <br>
                            <p><b>Ocorrência</b></p>
                            <p v-if="dadosConta.OcorrenciaCL ">{{ dadosConta.OcorrenciaCL }}</p>
                            <p v-else> - </p>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card>
        </div>
    </div>
</template>
<script>

    import { mapActions, mapGetters } from 'vuex';
    import Carregando from '@/components/CarregandoVuetify';
    import moment from 'moment';

    export default {
        name: 'ContasBancarias',
        data() {
            return {
                loading: true,
            };
        },
        components: {
            Carregando,
        },
        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                this.buscarContasBancarias(this.dadosProjeto.idPronac);
                this.loading = false;
            }
        },
        filters: {
            FormatarData(date) {
                if (date.length === 0) {
                    return '-';
                }
                return moment(date).format('DD/MM/YYYY');
            },
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dadosConta: 'projeto/contasBancarias',
            }),
        },
        methods: {
            ...mapActions({
                buscarContasBancarias: 'projeto/buscarContasBancarias',
            }),
        },
    };
</script>

