<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Liberação'"></Carregando>
        </div>
        <div v-else>
            <v-card>
                <v-subheader class="justify-center">
                    <div>
                        <h4 class="display-1 grey--text text--darken-4 font-weight-light">
                            Dados da Liberação
                        </h4>
                    </div>
                </v-subheader>
                <v-container>
                    <v-layout>
                        <v-flex xs4>
                            <br>
                            <p><b>Dt. Liberação</b></p>
                            <p>{{ dadosLiberacao.DtLiberacao | FormatarData }}</p>
                        </v-flex>
                        <v-flex xs4>
                            <br>
                            <p><b>Vl. Liberado</b></p>
                            <p>{{ dadosLiberacao.vlLiberado }}</p>
                        </v-flex>
                        <v-flex xs4>
                            <br>
                            <p><b>Conta liberada por:</b></p>
                            <p>{{ dadosLiberacao.usu_Nome }}</p>
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
        name: 'Liberacao',
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
                this.buscarLiberacao(this.dadosProjeto.idPronac);
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
                dadosLiberacao: 'projeto/liberacao',
            }),
        },
        methods: {
            ...mapActions({
                buscarLiberacao: 'projeto/buscarLiberacao',
            }),
        },
    };
</script>

