<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Laudo final'"/>
        </div>
        <div v-else>
            <v-container
                grid-list-md
                text-xs-left>
                <v-layout
                    justify-space-around
                    row
                    wrap>
                    <v-flex
                        lg12
                        dark
                        class="text-xs-left">
                        <b><h4>PARECER DE AVALIAÇÃO TÉCNICA DO CUMPRIMENTO DO OBJETO</h4></b>
                        <v-divider class="pb-2"/>
                    </v-flex>
                    <v-flex lg12>
                        <b>Manifestação</b>
                        <p>
                            {{ dados.dsManifestacaoObjeto }}
                        </p>
                    </v-flex>
                    <v-flex>
                        <b>Parecer</b>
                        <p v-html="dados.dsParecerDeCumprimentoDoObjeto"/>
                    </v-flex>
                    <v-flex/>
                </v-layout>

                <v-layout
                    justify-space-around
                    row
                    wrap>
                    <v-flex
                        lg12
                        dark
                        class="text-xs-left">
                        <b><h4>PARECER TÉCNICO DE AVALIAÇÃO FINANCEIRA</h4></b>
                        <v-divider class="pb-2"/>
                    </v-flex>
                    <v-flex
                        lg12>
                        <b>Manifestação</b>
                        <p>
                            {{ parecerTecnico.siManifestacao | tipolaudoFinal }}
                        </p>
                    </v-flex>
                    <v-flex
                        lg12>
                        <b>Parecer</b>
                        <p v-html="parecerTecnico.dsParecer"/>
                    </v-flex>
                    <v-flex/>
                </v-layout>

                <v-layout
                    justify-space-around
                    row
                    wrap>
                    <v-flex
                        lg12
                        dark
                        class="text-xs-left">
                        <b><h4>LAUDO FINAL</h4></b>
                        <v-divider class="pb-2"/>
                    </v-flex>

                    <v-flex
                        lg12>
                        <b>Manifestação</b>
                        <p>
                            {{ laudoFinal.siManifestacao | tipolaudoFinal }}
                        </p>
                    </v-flex>
                    <v-flex
                        lg12>
                        <b>Parecer</b>
                        <p v-html="laudoFinal.dsLaudoFinal"/>
                    </v-flex>
                    <v-flex/>
                </v-layout>
            </v-container>
        </div>
    </div>
</template>
<script>

import { mapActions, mapGetters } from 'vuex';
import Carregando from '@/components/CarregandoVuetify';
import { utils } from '@/mixins/utils';

export default {
    name: 'LaudoFinal',
    filters: {
        tipolaudoFinal(idTipoLaudo) {
            let tipolaudoFinal = '';
            switch (idTipoLaudo) {
            case 'A':
                tipolaudoFinal = 'Aprovado';
                break;
            case 'P':
                tipolaudoFinal = 'Aprovado com ressalva';
                break;
            case 'R':
                tipolaudoFinal = 'Reprovado';
                break;
            default:
                tipolaudoFinal = '';
            }
            return tipolaudoFinal;
        },
    },
    components: {
        Carregando,
    },
    mixins: [utils],
    data() {
        return {
            pagination: {
                sortBy: '',
                descending: true,
            },
            loading: true,
        };
    },
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
            dados: 'avaliacaoResultados/objetoParecer',
            parecerTecnico: 'avaliacaoResultados/parecer',
            parecerLaudoFinal: 'avaliacaoResultados/getParecerLaudoFinal',
        }),
        laudoFinal() {
            return this.parecerLaudoFinal.items;
        },
    },
    watch: {
        dadosProjeto(value) {
            this.loading = true;
            this.requestEmissaoParecer(value.idPronac);
        },
        dados() {
            this.loading = false;
        },
    },
    mounted() {
        if (typeof this.dadosProjeto.idPronac !== 'undefined') {
            this.requestEmissaoParecer(this.dadosProjeto.idPronac);
            this.getLaudoFinal(this.dadosProjeto.idPronac);
        }
    },
    methods: {
        ...mapActions({
            requestEmissaoParecer: 'avaliacaoResultados/getDadosEmissaoParecer',
            getLaudoFinal: 'avaliacaoResultados/getLaudoFinal',
        }),
    },
};
</script>
