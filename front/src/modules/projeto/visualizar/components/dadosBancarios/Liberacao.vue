<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Liberação'"></Carregando>
        </div>
        <div v-else-if="Object.keys(dadosLiberacao).length > 0">
            <v-card>
                <v-subheader class="justify-center">
                    <div>
                        <h4 class="display-1 grey--text text--darken-4 font-weight-light">
                            Liberação
                        </h4>
                    </div>
                </v-subheader>
                <v-container>
                    <v-layout>
                        <v-flex xs4 offset-xs1>
                            <br>
                            <p><b>Dt. Liberação</b></p>
                            <p>{{ dadosLiberacao.DtLiberacao | formatarData }}</p>
                        </v-flex>
                        <v-flex xs4 offset-xs1>
                            <br>
                            <p><b>Vl. Liberado</b></p>
                            <p>{{ dadosLiberacao.vlLiberado }}</p>
                        </v-flex>
                        <v-flex xs4 offset-xs1>
                            <br>
                            <p><b>Conta liberada por:</b></p>
                            <p>{{ dadosLiberacao.usu_Nome }}</p>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card>
        </div>
        <v-layout v-else>
            <v-container grid-list-md text-xs-center>
                <v-layout row wrap>
                    <v-flex>
                        <v-card>
                            <v-card-text class="px-0">Nenhuma Liberação encontrada</v-card-text>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-layout>
    </div>
</template>
<script>

    import { mapActions, mapGetters } from 'vuex';
    import Carregando from '@/components/CarregandoVuetify';
    import { utils } from '@/mixins/utils';

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
        mixins: [utils],
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

