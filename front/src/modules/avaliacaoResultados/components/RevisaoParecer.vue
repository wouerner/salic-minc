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
                <v-container >
                    <v-card-text>

                        <v-card>
                            <v-card-title primary-title>
                                <div>
                                    <div class="headline">Top western road trips</div>
                                    <span class="black--text">coisa chataaaaaaaaaaaaaaaaaa!!!!!!!!!!!!</span>
                                </div>
                            </v-card-title>

                            <v-card-text>

                                <v-container grid-list-md text-xs-center>

                                    <v-layout row wrap>
                                        <v-flex xs6>

                                            <v-data-table
                                                class="elevation-2"
                                                hide-headers
                                                hide-actions
                                            >
                                                <template slot="no-data">
                                                    <tr>
                                                        <th colspan="6">Quantidade de Comprovantes</th>
                                                    </tr>
                                                    <tr>
                                                        <td left><b>Total:</b></td>
                                                        <td >valor</td>
                                                        <td left><b>Validados:</b></td>
                                                        <td><font color="#006400">valor </font></td>
                                                    </tr>
                                                    <tr>
                                                        <td left><b>Não Avaliados:</b></td>
                                                        <td left>valor</td>
                                                        <td left><b>Recusados:</b></td>
                                                        <td left><font color="red">valor </font></td>
                                                    </tr>
                                                </template>
                                            </v-data-table>

                                        </v-flex>




                                        <v-flex xs6>

                                            <v-data-table
                                                class="elevation-1"
                                                hide-headers
                                                hide-actions
                                            >
                                                <template slot="no-data">
                                                    <tr>
                                                        <th colspan="6">Valores Comprovados</th>
                                                    </tr>
                                                    <tr>
                                                        <td left><b>Total:</b></td>
                                                        <td >valor</td>
                                                        <td left><b>Validados:</b></td>
                                                        <td><font color="#006400">valor </font></td>
                                                    </tr>
                                                    <tr>
                                                        <td left><b>Não Avaliados:</b></td>
                                                        <td left>valor</td>
                                                        <td left><b>Recusados:</b></td>
                                                        <td left><font color="red">valor </font></td>
                                                    </tr>
                                                </template>
                                            </v-data-table>

                                        </v-flex>

                                    </v-layout>
                                </v-container>
                            </v-card-text>
                        </v-card>



                        <v-subheader >Itens</v-subheader>

                        <v-expansion-panel >
                            <v-expansion-panel-content >
                                <v-layout slot="header" class="blue--text">
                                    <v-icon class="mr-3 blue--text" >insert_drive_file
                                    </v-icon>
                                    Coordenador
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
                                            <v-toolbar-title>Avaliar Parecer Técnico </v-toolbar-title>
                                        </v-toolbar>

                                        <v-card-text>
                                            <v-card>

                                                <v-card-text class="elevation-2">
                                                    <v-data-table

                                                        class="elevation-2"
                                                        hide-headers
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
                                                        <v-btn dark depressed small color="primary">
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
                </v-container>
            </v-card>
        </v-dialog>
    </v-layout>
</template>


<script>
  export default {
      name: 'RevisaoParecer',
      data() {
          return {
              dialog: false,
          };
      },
  };
</script>

<style scoped>

</style>
