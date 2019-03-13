<template>
<v-layout>
  <v-btn dark icon flat small color="green" @click.stop="dialog = true">
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
    @keydown.esc="dialog = false"
    >
    <div v-if="loading">
      <Carregando :text="'Montando edição de readequação...'"/>
    </div>

    <v-card v-else-if="campoAtual">
        <v-toolbar dark color="primary" fixed>
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
                        @dados-update="atualizarSolicitacao($event)"
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

                    <UploadFile class="mb-4"
                    @arquivo-anexado="atualizarArquivo($event)"
                    :formatosAceitos="formatosAceitos"
                    ></UploadFile>

                    </v-expansion-panel-content>
                </v-expansion-panel>

                <v-footer id="footer" class="pa-4 elevation-12" fixed>
                    <v-layout row wrap>
                        <v-flex xs3 offset-xs9>
                            <v-btn
                                color="green darken-1"
                                dark
                                @click="salvarReadequacao()"
                                >Salvar
                                <v-icon right dark>done</v-icon>
                            </v-btn>

                            <v-btn color="green darken-1" @click="dialog = false" dark>Finalizar
                                <v-icon right dark>done_all</v-icon>
                            </v-btn>
                        </v-flex>
                    </v-layout>
                </v-footer>
            </v-flex>
        </v-layout>
    </v-card>


  </v-dialog>
</v-layout>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Carregando from '@/components/CarregandoVuetify';
import FormReadequacao from './FormReadequacao';
import TemplateTextarea from './TemplateTextarea';
import TemplateInput from './TemplateInput';
import TemplateDate from './TemplateDate';
import TemplatePlanilha from './TemplatePlanilha';
import UploadFile from './UploadFile'

export default {
    name: "EditarReadequacaoButton",
    components: {
        Carregando,
        FormReadequacao,
        TemplateTextarea,
        TemplateInput,
        TemplateDate,
        TemplatePlanilha,
        UploadFile
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
            formatosAceitos: 'application/pdf',
            panel: [true, true],
            loading: true,
            readequacaoEditada: {
                idReadequacao: 0,
                "dsSolicitacao": "",
                "dsJustificativa": "",
                "dtSolicitacao": "",
                "documento": {},
                "idDocumento": 0,
                "dsAvaliacao": "",
                "nomeProponente": "",
            },
        };
    },
    created() {
        const idPronac = this.dadosReadequacao.idPronac;
        const idTipoReadequacao = this.dadosReadequacao.idTipoReadequacao;

        this.obterCampoAtual({ idPronac, idTipoReadequacao });
        this.atualizarReadequacaoEditada();
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
            obterCampoAtual: 'readequacao/obterCampoAtual',
            updateReadequacao: 'readequacao/updateReadequacao',
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
        },
        salvarReadequacao() {
            console.log(this.readequacaoEditada);
            this.updateReadequacao(this.readequacaoEditada);
        },
        atualizarReadequacaoEditada() {
            this.readequacaoEditada.idReadequacao = this.dadosReadequacao.idReadequacao;
            this.readequacaoEditada.dsSolicitacao = this.dadosReadequacao.dsSolicitacao;
            this.readequacaoEditada.dsJustificativa = this.dadosReadequacao.dsJustificativa;
            this.readequacaoEditada.dsAvaliacao = this.dadosReadequacao.dsAvaliacao;
            this.readequacaoEditada.idDocumento = this.dadosReadequacao.idDocumento;
        },
        atualizarArquivo(arquivo) {
            console.log('Arquivo alterado!');
            this.readequacaoEditada.documento = arquivo;
            //POST ou PUT da Readequação
            // Observar caso arquivo seja undefined, para atualizar
        },
        atualizarSolicitacao(valor) {
            this.readequacaoEditada.dsSolicitacao = valor;
        }

    },
};
</script>
<style>

    #footer {
        z-index: 5;
    }
</style>
