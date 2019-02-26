<template>
    <v-layout>
        <v-btn
            dark
            icon
            flat
            small
            color="red"
            @click.stop="dialog = true"
        >
            <v-tooltip bottom>
                <v-icon slot="activator">close</v-icon>
                <span>Excluir Readequação</span>
            </v-tooltip>
        </v-btn>

        <v-dialog
            v-model="dialog"
            max-width="350"
        >
            <v-card>
                <v-card-title class="headline">Excluir Readequação?</v-card-title>

                <v-card-text>
                    <h3>Projeto: 7º Festival do Japão do Rio Grande do Sul</h3>
                    Readequação do Tipo: Plano de Distribuição
                    Data de abertura: 04/12/2018 14:24:43
                </v-card-text>

                <v-card-actions>
                    <v-spacer/>

                    <v-btn
                        color="red darken-1"
                        flat="flat"
                        @click="dialog = false"
                    >
                        Cancelar
                    </v-btn>

                    <v-btn
                        color="green darken-1"
                        flat="flat"
                        @click="dialog = false"
                    >
                        OK
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
export default {
    name: 'ExcluirButton',
    props: {
	obj: { type: Object, default: () => {} },
	dadosProjeto: { type: Object, default: () => {} },
	dadosReadequacao: { type: Object, default: () => {} },
    },
    data() {
        return {
            dialog: false,
        };
    },
    computed: {
    },
    methods: {
    },
};
</script>
