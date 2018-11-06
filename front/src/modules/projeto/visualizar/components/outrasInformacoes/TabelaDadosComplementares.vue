<template>
    <v-flex>
        <v-expansion-panel popout focusable>
            <v-expansion-panel-content class="elevation-1">
                <v-layout slot="header" class="green--text">
                    <v-icon class="mr-3 green--text">subject</v-icon>
                    <span v-html="dadoComplementar">{{ dadoComplementar }}</span>
                </v-layout>
                <v-card>
                    <v-card-text>
                        <div v-if="dsDadoComplementar" v-html="dsDadoComplementar">
                            <td>{{ dsDadoComplementar }}</td>
                        </div>
                            <div v-else-if="custosVinculados">
                                <table class="tabela">
                                    <thead>
                                    <tr>
                                        <th>ITEM</th>
                                        <th>PERCENTUAL</th>
                                    </tr>
                                    </thead>
                                    <tbody v-for="(custosVinculado, index) in custosVinculados" :key="index">
                                    <tr>
                                        <td>{{ custosVinculado.Descricao }}</td>
                                        <td>{{ custosVinculado.Percentual }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else>
                                <v-alert :value="true" color="info" icon="warning">
                                    Nenhum dado encontrado
                                </v-alert>
                            </div>
                    </v-card-text>
                </v-card>
            </v-expansion-panel-content>
        </v-expansion-panel>
    </v-flex>
</template>

<script>
    export default {
        name: 'TabelaDadosComplementares',
        props: ['dadoComplementar', 'custosVinculados', 'dsDadoComplementar'],
    };
</script>

