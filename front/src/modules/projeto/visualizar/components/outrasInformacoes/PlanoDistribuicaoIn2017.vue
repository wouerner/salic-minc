<template>
    <!-- <div id="conteudo">
        <div v-if="loading">
            <Carregando :text="'Carregando Plano de Distribuicao'"></Carregando>
        </div>
        <div v-else>
            <PropostaPlanoDistribuicao
                    :arrayProdutos="dadosIn2017.planodistribuicaoproduto"
                    :arrayDetalhamentos="dadosIn2017.tbdetalhaplanodistribuicao">
            </PropostaPlanoDistribuicao>
        </div>
    </div> -->
<v-expansion-panel popout focusable>
            <v-expansion-panel-content class="elevation-1">
                <v-layout slot="header" class="green--text">
                    <v-icon class="mr-3 green--text">subject</v-icon>
                    <span>Plano Teste</span>
                </v-layout>
                <v-container fluid>
                    <v-card class="elevation-2 pl-5 pt-3">
                        <v-card-text>
                            <v-layout justify-space-around row wrap>
                                <v-flex s12 m6 lg2 offset-lg1 dark>
                                    <b>AREA</b>
                                    <p>Artes Cenicas</p>
                                    </v-flex>
                                    <v-flex s12 m6 lg3>
                                        <b>SEGMENTO</b>
                                    <p>Teatro</p>
                                    </v-flex>
                                    <v-flex s12 m6 lg3>
                                        <b>CANAL ABERTO?</b>
                                        <P>Sim</P>
                                    </v-flex>
                                    <v-flex s12 m6 lg3>
                                        <b>CANAL ABERTO?</b>
                                        <P>NAO</P>
                                    </v-flex>
                                </v-layout>

                                <v-layout justify-space-around row wrap>
                                    <v-flex lg12 dark class="text-xs-center">
                                    <b>QUANTIDADE DISTRIBUICAO GRATUITA</b>
                                    </v-flex>
                                    <v-flex s6 m6 lg3 offset-lg1>
                                        <p>
                                           <b>Divulgacao</b><br>
                                            #1
                                        </p>
                                    </v-flex>
                                    <v-flex s12 m6 lg4>
                                        <p>
                                            <b>Patrocinador</b><br>
                                            #2
                                        </p>
                                    </v-flex>
                                    <v-flex s12 m6 offset-xlg10>
                                        <p>
                                            <b>Populacao</b><br>
                                            #3
                                        </p>
                                    </v-flex>
                                </v-layout>

                                <v-layout justify-space-around row wrap>
                                    <v-flex lg12 dark class="text-xs-center">
                                    <b>PRECO POPULAR</b>
                                    </v-flex>
                                    <v-flex s6 m6 lg3 offset-lg1>
                                        <p>
                                            <b>Quantidade Inteira</b><br>
                                            #1
                                        </p>
                                    </v-flex>
                                    <v-flex s12 m6 lg4>
                                        <p>
                                            <b>Quantidade Meia</b><br>
                                            #2
                                        </p>
                                    </v-flex>
                                    <v-flex s12 m6 lg4>
                                        <p>
                                            <b>Valor medio</b><br>
                                            #3
                                        </p>
                                    </v-flex>
                                </v-layout>
                                <v-layout justify-space-around row wrap>
                                    <v-flex lg12 dark class="text-xs-center">
                                    <b>PRECO POPULAR</b>
                                    </v-flex>
                                    <v-flex s6 m6 lg3 offset-lg1>
                                        <p>
                                            <b>Quantidade Inteira</b><br>
                                            #1
                                        </p>
                                    </v-flex>
                                    <v-flex s12 m6 lg4>
                                        <p>
                                            <b>Quantidade Meia</b><br>
                                            #2
                                        </p>
                                    </v-flex>
                                    <v-flex s12 m6 lg4>
                                        <p>
                                            <b>Valor medio</b><br>
                                            #3
                                        </p>
                                    </v-flex>
                                </v-layout>

                                <v-layout justify-space-around row wrap>
                                    <v-flex lg12 dark class="text-xs-center">
                                    <b>PROPONENTE</b>
                                    </v-flex>
                                    <v-flex s6 m6 lg3 offset-lg1>
                                        <p>
                                            <b>Quantidade Inteira</b><br>
                                            #1
                                        </p>
                                    </v-flex>
                                    <v-flex s12 m6 lg4>
                                        <p>
                                            <b>Quantidade Meia</b><br>
                                            #2
                                        </p>
                                    </v-flex>
                                    <v-flex s12 m6 lg4>
                                        <p>
                                            <b>Valor medio</b><br>
                                            #3
                                        </p>
                                    </v-flex>
                                </v-layout>

                                <v-layout justify-space-around row wrap>
                                    <v-flex lg5 dark class="text-xs-center">
                                    <b>QUANTIDADE TOTAL</b>
                                    </v-flex>
                                    <v-flex lg5 dark class="text-xs-center">
                                    <b>RECEITA PREVISTA TOTAL</b>
                                    </v-flex>
                                    <v-flex s3 m6 lg5 offset-lg1>
                                        <p>
                                            <b>Quantidade Inteira</b><br>
                                            #1
                                        </p>
                                    </v-flex>
                                    <v-flex s3 m6 lg6>
                                        <p>
                                            <b>Quantidade Meia</b><br>
                                            #2
                                        </p>
                                    </v-flex>
                                </v-layout>
                            </v-card-text>
                    </v-card>
            </v-container>
        </v-expansion-panel-content>
    </v-expansion-panel>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import Carregando from "@/components/Carregando";
import PropostaPlanoDistribuicao from "@/modules/proposta/visualizar/components/PropostaPlanoDistribuicao";

export default {
  name: "PlanoDistribuicaoIn2017",
  props: ["idPronac"],
  data() {
    return {
      loading: true
    };
  },
  components: {
    Carregando,
    PropostaPlanoDistribuicao
  },
  mounted() {
    if (typeof this.dadosProjeto.idPreProjeto !== "undefined") {
      this.buscarPlanoDistribuicaoIn2017(this.dadosProjeto.idPreProjeto);
    }
  },
  watch: {
    dadosIn2017() {
      this.loading = false;
    }
  },
  computed: {
    ...mapGetters({
      dadosProjeto: "projeto/projeto",
      dadosIn2017: "projeto/planoDistribuicaoIn2017"
    })
  },
  methods: {
    ...mapActions({
      buscarPlanoDistribuicaoIn2017: "projeto/buscarPlanoDistribuicaoIn2017"
    })
  }
};
</script>
