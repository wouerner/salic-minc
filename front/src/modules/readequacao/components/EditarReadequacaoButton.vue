<template>
<v-layout>
  <v-btn dark icon flat small color="green" @click.stop="dialog = true">
    <v-tooltip bottom>
      <v-icon slot="activator">edit</v-icon>
      <span>Editar Readequação</span>
    </v-tooltip>
  </v-btn>
  
  <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
    <div v-if="loading">
      <Carregando :text="'Montando edição de readequação...'"/>
    </div>
    
    <v-card v-else-if="campoAtual">
		<v-toolbar dark color="primary">
			<v-btn icon dark @click="dialog = false">
                <v-icon>close</v-icon>
			</v-btn>
			<v-toolbar-title>Readequação - {{ dadosReadequacao.dsTipoReadequacao }}</v-toolbar-title>
			<v-spacer/>
			<v-toolbar-title>{{ dadosProjeto.Pronac }} - {{ dadosProjeto.NomeProjeto }}</v-toolbar-title>
		</v-toolbar>
      
		<v-layout row wrap>   
			<v-flex xs10 offset-xs1>
				<v-expansion-panel v-model="panel" expand>
					<v-expansion-panel-content 
					readonly 
					hide-actions
					>
					<div class="title" slot="header">Edição</div>
					<v-card
					v-if="getTemplateParaTipo()"
					>
						<component
						:is="getTemplateParaTipo()"
						:dadosReadequacao="dadosReadequacao"
						:campo="getDadosCampo()"
						/>
					</v-card>
					</v-expansion-panel-content>
					
					<v-expansion-panel-content
					readonly 
					hide-actions
					>
					<div class="title" slot="header">Justificativa da readequação</div>
					<v-card>
						<FormReadequacao :dadosReadequacao="dadosReadequacao"></FormReadequacao>
					</v-card>
				
					<v-btn
						label="Anexar arquivo"
						:value="dadosReadequacao.idDocumento"
						@change="prepararAdicionarDocumento"
						>Anexar documento</v-btn>
					</v-expansion-panel-content>
				</v-expansion-panel>
			</v-flex>
		</v-layout>
    </v-card>
      
	<v-footer class="pa-4" fixed>
		<v-layout row wrap>   
			<v-flex xs3 offset-xs9>
				<v-btn color="green darken-1" @click="dialog = false" dark>Salvar
					<v-icon right dark>done</v-icon>
				</v-btn>

				<v-btn color="green darken-1" @click="dialog = false" dark>Finalizar
					<v-icon right dark>done_all</v-icon>
				</v-btn>
			</v-flex>
		</v-layout>
	</v-footer>
	
  </v-dialog>
</v-layout>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import FormReadequacao from "./FormReadequacao";
import TemplateTextarea from "./TemplateTextarea";
import TemplateInput from "./TemplateInput";
import TemplateDate from "./TemplateDate";
import TemplatePlanilha from "./TemplatePlanilha";
import Carregando from "@/components/CarregandoVuetify";

export default {
    name: "EditarReadequacaoButton",
    components: {
        Carregando,
        FormReadequacao,
        TemplateTextarea,
        TemplateInput,
        TemplateDate,
        TemplatePlanilha
    },
    props: {
        dadosReadequacao: { type: Object, default: () => {} },
        dadosProjeto: { type: Object, default: () => {} },
        bindClick: { type: Number, default: 0 },
    },
    data() {
        return {
            dialog: false,
            tiposReadequacoes: {
                textarea: "TemplateTextarea",
                input: "TemplateInput",
                date: "TemplateDate",
                planilha: "TemplatePlanilha"
            },
            templateEdicao: [],
            panel: [true, true],
            loading: true
        };
    },
    created() {
        const idPronac = this.dadosReadequacao.idPronac;
        const idTipoReadequacao = this.dadosReadequacao.idTipoReadequacao;
        
        this.obterCampoAtual({ idPronac, idTipoReadequacao });
    },
    watch: {
        campoAtual: {
	        handler(valor) {
		        if (Object.keys(valor).length > 0) {
                    this.loading = false;
		        }
	        },
	        deep: true,
        },
        dadosReadequacao: {
            handler(valor) {
                if (this.bindClick == valor.idReadequacao) {
                    this.dialog = true;
                }
            },
            deep: true,
        },
    },
    computed: {
        ...mapGetters({
            campoAtual: "readequacao/getCampoAtual"
        })
    },
    methods: {
        ...mapActions({
            obterCampoAtual: "readequacao/obterCampoAtual"
        }),
        prepararAdicionarDocumento() {},
        getTemplateParaTipo() {
            let templateName = false;
            let chave = 'key_' + this.dadosReadequacao.idTipoReadequacao;
            if (this.campoAtual.hasOwnProperty(chave)) {
                let tpCampo = this.campoAtual[chave].tpCampo;
                templateName = this.tiposReadequacoes[tpCampo];
            }
            return templateName;
        },
        getDadosCampo() {
            let chave = 'key_' + this.dadosReadequacao.idTipoReadequacao;

            let valor = this.dadosReadequacao.dsSolicitacao;
            let titulo = this.campoAtual[chave].descricao;
            return { valor, titulo };
        }
    }
};
</script>
