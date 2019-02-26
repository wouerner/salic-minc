<template>
    <v-layout>
        <v-btn
            dark
            icon
            flat
            small
            color="green"
            @click.stop="dialog = true"
        >
            <v-tooltip bottom>
                <v-icon slot="activator">edit</v-icon>
                <span>Editar Readequação</span>
            </v-tooltip>
        </v-btn>

        <v-dialog
            v-model="dialog"
            fullscreen 
            hide-overlay 
            transition="dialog-bottom-transition"
        >
            <v-card>
                <v-toolbar
                    dark
                    color="primary">
                    <v-btn
                        icon
                        dark
                        @click="dialog = false"
                    >
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Readequação - Plano de Distribuição</v-toolbar-title>
                    <v-spacer/>
		    <v-toolbar-title>{{ dadosProjeto.Pronac }} - {{ dadosProjeto.NomeProjeto }}</v-toolbar-title>
                </v-toolbar>

                <v-card-text>
                    <template
                        v-for="(componente, index) in templateEdicao"
                        d-inline-block>
                        <component
                            :key="index"
                            :is="componente"
                            :idReadequacao="idReadequacao"
                          />
                    </template>
                </v-card-text>

                <v-card-actions>
                    <v-spacer/>

                    <v-btn
                        color="green darken-1"
                        @click="dialog = false"
                        dark
                    >
                        Salvar
                        <v-icon right dark>done</v-icon>
                    </v-btn>

                    <v-btn
                        color="green darken-1"
                        @click="dialog = false"
                        dark
                    >
                        Finalizar
                        <v-icon right dark>done_all</v-icon>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
import FormReadequacao from './FormReadequacao';
import TemplatePlanilha from './TemplatePlanilha';

export default {
    name: 'EditarReadequacaoButton',
    components: {
	FormReadequacao,
    },
    props: {
        idReadequacao: { type: Number, default: 0 },
        idTipoReadequacao: { type: Number, default: 0 },
	dadosProjeto: { type: Object, default: () => {} },
    },
    data() {
        return {
            dialog: false,
            tiposReadequacoes: {
                1: TemplatePlanilha,
                2: TemplatePlanilha,
            },
            templateEdicao: [FormReadequacao]
        };
    },
    created() {
        if (this.tiposReadequacoes.hasOwnProperty(this.idTipoReadequacao)) {
            this.templateEdicao = [ this.tiposReadequacoes[this.idTipoReadequacao] ];
        }
    },
    computed: {
    },
    methods: {
    },
};
</script>
