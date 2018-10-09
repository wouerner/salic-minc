<template>
    <v-layout row justify-center>
        <v-dialog v-model="dialog"
                  scrollable
                  fullscreen
                  transition="dialog-bottom-transition"
                  hide-overlay
        >
            <v-btn
                slot="activator"
                color="red"
                dark
                small
                title="Comprovar Item"
            >
                <v-icon>gavel</v-icon>
            </v-btn>
            <v-card>
                <v-toolbar dark color="green darken-3">
                    <v-btn icon dark @click.native="dialog = false">
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Analise de Resultados - Revisão do Parecer Técnico </v-toolbar-title>
                </v-toolbar>

                <v-card-text>

                    <v-flex xs12 sm12 md12>
                        <p><b>Projeto:</b> ano+sequencial - Coisinha tem nome </p>
                    </v-flex>
                    <v-flex xs12 sm12 md12>
                        <p><b>Proponente:</b> {{proponente.CgcCpf}} - {{proponente.Nome}}</p>
                    </v-flex>

                    <v-data-table
                        class="elevation-2"
                        hide-headers
                        hide-actions
                    >
                        <template slot="no-data">
                            <!--v-if="dadosItemComprovacao.dadosItem" -->

                            <tr>
                                <th colspan="4">Parecer Tecnico</th>
                            </tr>
                        </template>
                        <template slot="no-data">
                            <v-container grid-list-sm>
                                <v-layout row wrap class="justify-center">
                                        <v-card  tile flat flex >
                                            <v-card-title class="justify-center" >
                                               <b> Quantidade de Comprovantes </b>
                                            </v-card-title>
                                            <v-card-text>
                                                <v-data-table hide-actions hide-headers>
                                                    <template slot="no-data">
                                                        <tr>
                                                            <td left><b>Total:</b></td>
                                                            <td >valor</td>
                                                            <td left><b>Validados:</b></td>
                                                            <td>valor</td>
                                                        </tr>
                                                        <tr>
                                                            <td left><b>Não Avaliados:</b></td>
                                                            <td left>valor</td>
                                                            <td left><b>Recusados:</b></td>
                                                            <td left>valor</td>
                                                        </tr>
                                                    </template>
                                                </v-data-table>
                                            </v-card-text>
                                        </v-card>

                                        <v-card flat flex="6" xs10 sm7 md7>
                                            <v-card-title class="justify-center" >
                                                <b> Valores Comprovados </b>
                                            </v-card-title>
                                            <v-card-text>
                                                <v-data-table hide-actions hide-headers>
                                                    <template slot="no-data">
                                                        <tr>
                                                            <td left><b>Total:</b></td>
                                                            <td >valor</td>
                                                            <td left><b>Validados:</b></td>
                                                            <td>valor</td>
                                                        </tr>
                                                        <tr>
                                                            <td left><b>Não Avaliados:</b></td>
                                                            <td left>valor</td>
                                                            <td left><b>Recusados:</b></td>
                                                            <td left>valor</td>
                                                        </tr>
                                                    </template>
                                                </v-data-table>
                                            </v-card-text>
                                        </v-card>
                                </v-layout>
                            </v-container>

                        </template>
                    </v-data-table>

                    <v-spacer></v-spacer>


                    <v-subheader >Itens</v-subheader>

                    <v-expansion-panel >
                        <!--v-if="dadosItemComprovacao.comprovantes">-->
                        <v-expansion-panel-content >
                            <!--v-for="(comprovante, i) in dadosItemComprovacao.comprovantes"-->
                            <!--:key="i"-->

                            <v-layout slot="header" class="blue--text">
                                <v-icon class="mr-3 blue--text" >local_shipping</v-icon>
                                Fornecedor: valor - R$ valor
                                <v-spacer></v-spacer>
                                <v-chip small color="green" text-color="white">
                                    <v-avatar>
                                        <v-icon>check_circle</v-icon>
                                    </v-avatar>
                                    Aprovado
                                </v-chip>
                            </v-layout>

                            <v-card
                                color="green lighten-4"
                                flat
                                tile
                            >
                                <v-flex >

                                    <v-toolbar dense>
                                        <v-toolbar-title>Avaliar Parecer Técnico +++ </v-toolbar-title>


                                        <v-btn  icon>
                                            <v-icon>get_app</v-icon>
                                        </v-btn>
                                    </v-toolbar>

                                    <v-card-text>
                                        <v-card>

                                            <v-card-text class="elevation-2">
                                                <v-data-table

                                                    class="elevation-2"
                                                    hide-headers

                                                    :items="[]"
                                                    hide-actions
                                                >
                                                    <template slot="no-data">
                                                        <tr>
                                                            <td left><b>Fornecedor:</b></td>
                                                            <td>Seu juquinha</td>
                                                            <td left><b>CNPJ/CPF:</b></td>
                                                            <td colspan="5">Seu PC</td>
                                                        </tr>
                                                        <tr>
                                                            <td left><b>Comprovante:</b></td>
                                                            <td >valor</td>
                                                            <td left><b>Número:</b></td>
                                                            <td>valor</td>
                                                            <td left><b>S&eacute;rie:</b></td>
                                                            <td colspan="3">valor</td>
                                                        </tr>
                                                        <tr>
                                                            <td left><b>Dt. Emiss&atilde;o do comprovante de despesa:</b></td>
                                                            <td>valor</td>
                                                            <td left><b>Forma de Pagamento:</b></td>
                                                            <td>valor</td>
                                                            <td left><b>Data do Pagamento:</b></td>
                                                            <td>valor</td>
                                                            <td left style="width: 155px;"><b>N&ordm; Documento Pagamento:</b></td>
                                                            <td>valor</td>
                                                        </tr>
                                                        <tr>
                                                            <td left><b>Valor:</b></td>
                                                            <td>valor 1</td>
                                                            <td left><b>Justificativa do Proponente:</b></td>
                                                            <td colspan="5">valor2</td>
                                                        </tr>
                                                        <tr>
                                                            <td left><b>Avaliação:</b></td>
                                                            <td colspan="7">
                                                                <v-radio-group row>
                                                                    <v-radio label="Aprovado" value="radio-1"></v-radio>
                                                                    <v-radio label="Reprovado" value="radio-2" color="red"></v-radio>
                                                                </v-radio-group>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                </v-data-table>

                                                <v-textarea
                                                    solo
                                                    no-resize
                                                    label="Parecer da avaliação"
                                                    value=""
                                                    hint="Digite o parecer da sua avaliação"
                                                    height="180px"
                                                ></v-textarea>
                                                <div>
                                                    <v-btn depressed small color="primary">
                                                        Salvar
                                                    </v-btn>
                                                </div>
                                            </v-card-text>
                                        </v-card>
                                    </v-card-text>
                                </v-flex>
                            </v-card>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-layout>
</template>


<script>
  export default {
      name: 'RevisaoParecer',
  };
</script>

<style scoped>

</style>
