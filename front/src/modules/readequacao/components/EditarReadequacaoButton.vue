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
                    <v-toolbar-title>Readequação - {{ dadosReadequacao.dsTipoReadequacao }}</v-toolbar-title>
                    <v-spacer/>
		    <v-toolbar-title>{{ dadosProjeto.Pronac }} - {{ dadosProjeto.NomeProjeto }}</v-toolbar-title>
                </v-toolbar>

		<v-expansion-panel
		  v-model="panel"
		  expand
		  >
		  <v-expansion-panel-content
		    >
		    <div slot="header">Edição</div>
		    <v-card>
		      <template
                          v-for="(componente, index) in templateEdicao"
                          d-inline-block>
                          <component
                            :key="index"
                            :is="componente"
                            :dadosReadequacao="dadosReadequacao"
			    :campoEdicao="dadosReadequacao.dsSolicitacao"
                            />
			</template>
		    </v-card>
		  </v-expansion-panel-content>
		  
		  <v-expansion-panel-content
		    >
		    <div slot="header">Justificativa da readequação</div>
		    <v-card>
                      <v-card-text>
			<FormReadequacao
			  :dadosReadequacao="dadosReadequacao"
			  ></FormReadequacao>
                      </v-card-text>
		    </v-card>
		    
		    <v-btn
		      label="Anexar arquivo"
		      :value="dadosReadequacao.idDocumento"
		      @change="prepararAdicionarDocumento"
		      >Anexar documento</v-btn>

		  </v-expansion-panel-content>
		</v-expansion-panel>
		
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
import TemplateTextarea from './TemplateTextarea';
import TemplatePlanilha from './TemplatePlanilha';

export default {
    name: 'EditarReadequacaoButton',
    components: {
	FormReadequacao,
	TemplateTextarea,
	TemplatePlanilha,
    },
    props: {
	dadosReadequacao: { type: Object, default: () => {} },
	dadosProjeto: { type: Object, default: () => {} },
    },
    data() {
        return {
            dialog: false,
            tiposReadequacoes: {
		"textarea": "TemplateTextarea",
		"input": "TemplateInput",
		"date": "TemplateDate",
		"planilha": "TemplatePlanilha",
            },
	    templateEdicao: [ TemplateTextarea ],
	    panel: [false, true]
        };
    },
    created() {
	// tipo específico dessa readequacao (idTip
    },
    computed: {
    },
    methods: {
	prepararAdicionarDocumento() {
	},
    },
};
</script>
