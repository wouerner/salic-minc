<template>
    <v-container fluid>
        <v-layout
            v-if="!permissao"
            column
        >
            <v-flex
            >
                <v-btn
                    class="green--text text--darken-4"
                    flat
                    @click="voltar()"
                >
                    <v-icon class="mr-2">keyboard_backspace</v-icon>
                </v-btn>
                <v-card>
                    <salic-mensagem-erro :texto="'Sem permiss&atilde;o de acesso para este projeto'"/>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout
            v-else
        >
            <v-flex
                v-if="loading"
                xs9
                offset-xs1
            >
                <carregando :text="'Carregando readequação de saldo de aplicação...'"/>
            </v-flex>
            <v-flex v-else>
                <v-toolbar
                    color="#0A420E"
                    dark
                >
                    <v-btn icon
	                       color="#0A420E"
	                       href="javascript:voltar()"
	                >
	                    <v-icon color="white">arrow_back</v-icon>
                    </v-btn>
                    <v-toolbar-title>Readequação - Saldo de Aplicação</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-title>
                        {{ dadosProjeto.Pronac }} - {{ dadosProjeto.NomeProjeto }}
                    </v-toolbar-title>
                </v-toolbar>
                <v-layout column row pb-2>
                    <v-flex xs12>
	                    <v-expansion-panel
                            popout
                        >
	                        <v-expansion-panel-content
	                            :key="1"
	                        >
	                            <div slot="header">
                                    <h3
                                        class="headline"
                                    >Dados da readequação</h3>
                                </div>
	                            <v-card
                                    class="mb-5"
                                >
                                    <v-card-title
                                        class="green lighten-2 title"
                                    >
                                        Justificativa da readequação
                                    </v-card-title>
                                    <form-readequacao
                                        :dados-readequacao="dadosReadequacao"
                                        :min-char="minChar.justificativa"
                                        @dados-update="atualizarCampo($event, 'dsJustificativa')"
                                        @editor-texto-counter="atualizarContador($event, 'justificativa')"
                                    />
                                </v-card>
                                <v-card
                                    class="mb-5"
                                >
                                    <v-card-title
                                        class="green lighten-2 title"
                                    >
                                        Arquivo anexo
                                    </v-card-title>
                                    <v-card-actions>
                                        <upload-file
                                            :formatos-aceitos="formatosAceitos"
                                            :id-documento="dadosReadequacao.idDocumento"
                                            class="mt-1"
                                            @arquivo-anexado="atualizarArquivo($event)"
                                            @arquivo-removido="removerArquivo()"
                                            @arquivo-tipo-invalido="arquivoTipoInvalido($event)"
                                        />
                                    </v-card-actions>
	                            </v-card>
	                            <v-card
                                    class="mb-5"
                                >
                                    <v-card-title
                                        class="green lighten-2 title"
                                    >
                                        Valor disponível
                                    </v-card-title>
                                    <valor-disponivel
                                        :valor="dadosReadequacao.dsSolicitacao"
                                        @dados-update="atualizarCampo($event, 'dsSolicitacao')"
                                    />
                                </v-card>
	                        </v-expansion-panel-content>
	                        <v-expansion-panel-content
	                            :key="2"
	                        >
	                            <div slot="header">
                                    <h3
                                        class="headline"
                                    >Edição da Planilha</h3>
                                </div>
	                            <v-card>
	                                edição da planilha
	                            </v-card>
	                        </v-expansion-panel-content>
	                    </v-expansion-panel>    
	                </v-flex>
                    <v-footer
                        v-if="true"
                        id="footer"
                        class="pb-4 pt-4 elevation-18"
                        fixed
                    >
                        <v-flex xs11>
                            <v-layout
                                row
                                wrap
                                justify-end
                                text-xs-right
                            >
                                <v-btn
                                    color="green darken-1"
                                    dark
                                    @click="salvarReadequacao()"
                                >Salvar
                                    <v-icon
                                        right
                                        dark
                                    >done</v-icon>
                                </v-btn>
                                <v-btn
                                    color="red lighten-2"
                                    dark
                                >Cancelar
                                    <v-icon
                                        right
                                        dark
                                    >cancel</v-icon>
                                </v-btn>
                                <finalizar-button
                                    :dados-readequacao="dadosReadequacao"
                                    :dados-projeto="dadosProjeto"
                                    :tela-edicao="true"
                                    dark
                                />
                            </v-layout>
                        </v-flex>
                    </v-footer>            
                </v-layout>
            </v-flex>
        </v-layout>
        <mensagem
            :mensagem="mensagem"
        />        
        <div v-show="exibirBotaoIniciar">
            <v-btn
                @click="solicitarUsoSaldo()"
            >
                <v-icon>border_color</v-icon>
                Solicitar uso do saldo de aplicação
            </v-btn>
        </div>
    </v-container>
    <!--
         <div class="readequacao-saldo-aplicacao container-fluid">
         
         <ul
         class="collapsible"
         v-if="!disabled"
         v-show="exibirPaineis"
         >
         <li>
         <div class="collapsible-header">
         <i class="material-icons">list</i>
         Editar planilha or&ccedil;ament&aacute;ria
         </div>
         <div class="collapsible-body" v-if="solicitacaoIniciada">
         <div class="card">
         <div class="card-content">
         <readequacao-saldo-aplicacao-resumo
         :valorSaldoAplicacao="valorSaldoAplicacao"
         :valorEntrePlanilhasLimpo="valorEntrePlanilhasLimpo"
         :valorSaldoDisponivelParaUso="valorSaldoDisponivelParaUso"
         :valorSaldoUtilizado="valorSaldoUtilizado"
         :valorSaldoDisponivelParaUsoNegativo="valorSaldoDisponivelParaUsoNegativo"
         :valorSaldoDisponivelParaUsoNeutro="valorSaldoDisponivelParaUsoNeutro"
         :valorSaldoDisponivelParaUsoPositivo="valorSaldoDisponivelParaUsoPositivo"
         :valorSaldoUtilizadoPositivo="valorSaldoUtilizadoPositivo"
         :valorSaldoUtilizadoNeutro="valorSaldoUtilizadoNeutro"
         :readequacaoAlterada="readequacaoAlterada"                                        
         :valorSaldoUtilizadoNegativo="valorSaldoUtilizadoNegativo"
         >
         </readequacao-saldo-aplicacao-resumo>
         </div>
         </div>
         
         <div class="card">
         <div class="card-content">
         <planilha-orcamentaria
         :id-pronac="idPronac"
         :tipo-planilha="tipoPlanilha"
         :link="1"
         :id-readequacao="dadosReadequacao.idReadequacao"
         :componente-planilha="componentePlanilha"
         :perfil="perfil"
         :disabled="disabled"
         :disponivelParaAdicaoItensReadequacaoPlanilha="disponivelParaAdicaoItensReadequacaoPlanilha"
         v-on:atualizarSaldoEntrePlanilhas="carregarValorEntrePlanilhas"
         >
         </planilha-orcamentaria>
         </div>
         </div>
         
         <div class="card">
         <div class="card-content">
         <readequacao-saldo-aplicacao-resumo
         :valorSaldoAplicacao="valorSaldoAplicacao"
         :valorEntrePlanilhasLimpo="valorEntrePlanilhasLimpo"
         :valorSaldoDisponivelParaUso="valorSaldoDisponivelParaUso"
         :valorSaldoUtilizado="valorSaldoUtilizado"
         :valorSaldoDisponivelParaUsoNegativo="valorSaldoDisponivelParaUsoNegativo"
         :valorSaldoDisponivelParaUsoPositivo="valorSaldoDisponivelParaUsoPositivo"
         :valorSaldoUtilizadoPositivo="valorSaldoUtilizadoPositivo"
         :valorSaldoUtilizadoNeutro="valorSaldoUtilizadoNeutro"
         :readequacaoAlterada="readequacaoAlterada"
         :valorSaldoUtilizadoNegativo="valorSaldoUtilizadoNegativo"
         >
         </readequacao-saldo-aplicacao-resumo>
         </div>
         </div>
         
         </div>
         <div class="collapsible-body card" v-else>
         <span>Preencha o valor do saldo dispon&iacute;vel para poder iniciar as altera&ccedil;&atilde;oes na planilha or&ccedil;ament&aacute;ria.</span>
         </div>
         </li>
         </ul>
         <div v-if="disabled">
         <div class="card">
         <div class="card-content">
         <h4>Saldo de aplica&ccedil;&atildeo declarado</h4>
         <h6 class="blue-text lighten-1">R$ {{valorSaldoAplicacao}}</h6>
         </div>
         </div>
         <div class="card">
         <div class="card-content">
         <planilha-orcamentaria
         :id-pronac="idPronac"
         :tipo-planilha="tipoPlanilha"
         :link="1"
         :id-readequacao="dadosReadequacao.idReadequacao"
         :componente-planilha="componentePlanilha"
         :perfil="perfil"
         :disabled="disabled"
         :disponivelParaAdicaoItensReadequacaoPlanilha="disponivelParaAdicaoItensReadequacaoPlanilha"
         v-on:atualizarSaldoEntrePlanilhas="carregarValorEntrePlanilhas"
         >
         </planilha-orcamentaria>
         </div>
         </div>
         </div>
         
         <div class="card" v-if="mostrarBotoes">
         <div class="card-content">
         <div class="row">
         <div class="right-align padding20 col s12">
         <button
         class="waves-light waves-effect btn red modal-trigger"
         v-on:click="prepararExcluirReadequacao()"
         >Excluir</button>
         <a
         class="waves-light waves-effect btn modal-trigger"
         href="#modalFinalizar"
         :disabled="!podeFinalizarReadequacao"
         >Finalizar</a>
         </div>
         </div>
         </div>
         </div>
         
         <div id="modalExcluir" class="modal">
         <div class="modal-content center-align">
         <h4>Tem certeza que deseja excluir a redequa&ccedil;&atilde;o?</h4>
         </div>
         <div class="modal-footer">
         <a class="waves-effect waves-green btn-flat red white-text"
         v-on:click="excluirReadequacao">Excluir
         </a>
         <a class="modal-close waves-effect waves-green btn-flat"
         href="#!">Cancelar
         </a>                                                                                                
         7    </div>
         </div>                                                
         <div id="modalFinalizar" class="modal">
         <div class="modal-content center-align">
         <h4>Tem certeza que deseja finalizar a redequa&ccedil;&atilde;o?</h4>
         </div>
         <div class="modal-footer">
         <a 
         class="waves-effect waves-green btn-flat green white-text"
         v-on:click="finalizarReadequacao">Finalizar
         </a>
         <a class="modal-close waves-effect waves-green btn-flat"
         href="#!">Cancelar
         </a>                                                                                                
         </div>
         </div>                                                
         
         <div v-if="mostrarMensagemFinal" class="card">
         <div class="card-content">
         <div class="row">
         <div class="col s1 right-align"><i class="medium green-text material-icons">check_circle</i></div>
         <div class="col s11">
         <p><b>Solicita&ccedil;&atilde;o enviada com sucesso!</b></p>
         <p>Sua solicita&ccedil;&atilde;o agora est&aacute; para an&aacute;lise t&eacute;cnica do MinC.</p>
         <p>Para acompanhar, acesse o menu lateral 'Execu&ccedil;&atilde;o -> Dados das readequa&ccedil;&otilde;es'
         em <a :href="'/projeto/#incentivo/' + idPronac">consultar dados do projeto</a>.</p>
         </div>
         </div>
         </div>
         </div>
         </div>

         </div>
    -->
    
</template>
<script>

import { mapActions, mapGetters } from 'vuex';
import { utils } from '@/mixins/utils';
import Const from '../const';
import Mensagem from '../components/Mensagem';
import FinalizarButton from '../components/FinalizarButton';
import validarFormulario from '../mixins/validarFormulario';
import verificarPerfil from '../mixins/verificarPerfil';
import Carregando from '@/components/CarregandoVuetify';
import FormReadequacao from '../components/FormReadequacao';
import UploadFile from './../components/UploadFile';
import ValorDisponivel from '../components/ValorDisponivel';
/* velho abaixo */
import ReadequacaoSaldoAplicacaoResumo from '../components/ReadequacaoSaldoAplicacaoResumo';
// import ReadequacaoFormulario from '../components/ReadequacaoFormulario';
import ReadequacaoSaldoAplicacaoPlanilhaOrcamentaria from '../components/ReadequacaoSaldoAplicacaoPlanilhaOrcamentaria';
import PlanilhaOrcamentariaAlterarItem from '../components/PlanilhaOrcamentariaAlterarItem';
import PlanilhaOrcamentariaIncluirItem from '../components/PlanilhaOrcamentariaIncluirItem';
import PlanilhaOrcamentaria from '../components/PlanilhaOrcamentaria';

export default {
    name: 'SaldoAplicacaoView',
    components: {
        Mensagem,
        FinalizarButton,
        Carregando,
        UploadFile,
        ValorDisponivel,
        FormReadequacao,
        ReadequacaoSaldoAplicacaoResumo,
        PlanilhaOrcamentariaAlterarItem,
        PlanilhaOrcamentariaIncluirItem,
        ReadequacaoSaldoAplicacaoPlanilhaOrcamentaria,
        PlanilhaOrcamentaria,
    },
    mixins: [
        utils,
        validarFormulario,
        verificarPerfil,
    ],
    data() {
        return {
            readequacaoEditada: {
                idReadequacao: 0,
                dsSolicitacao: '',
                dsJustificativa: '',
                dtSolicitacao: '',
                documento: {},
                idDocumento: '',
                dsAvaliacao: '',
            },
            mensagem: {
                ativa: false,
                timeout: 2300,
                conteudo: '',
                cor: '',
                finaliza: false,
            },
            minChar: {
                solicitacao: 3,
                justificativa: 10,
            },
            contador: {
                justificativa: 0,
            },
            perfisAceitos: {
                proponente: [
                    Const.PERFIL_PROPONENTE,
                ],
                analise: [
                    Const.PERFIL_TECNICO_ACOMPANHAMENTO,
                    Const.PERFIL_COORDENADOR_ACOMPANHAMENTO,
                    Const.PERFIL_COORDENADOR_GERAL_ACOMPANHAMENTO,
                    Const.PERFIL_DIRETOR,
                    Const.PERFIL_SECRETARIO,
                ],
            },
            loaded: {
                projeto: false,
                readequacao: false,
                usuario: false,
            },
            loading: true,
            exibirBotaoIniciar: false,
            permissao: true,
            formatosAceitos: ['application/pdf'],
            /* velho em diante
            disabled: false,
            idPronac: '',
            pronac: '',
            nomeProjeto: '',
            idTipoReadequacao: 22,
            siEncaminhamento: 12,
            exibirBotaoIniciar: false,
            exibirPaineis: false,
            solicitacaoIniciada: false,
            mostrarMensagemFinal: false,
            valorEntrePlanilhas: [],
            tipoPlanilha: 7,
            componentePlanilha: 'ReadequacaoSaldoAplicacaoPlanilhaOrcamentaria',
            disponivelParaAdicaoItensReadequacaoPlanilha: false,
            readequacaoAlterada: false, */
        };
    },
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
            dadosReadequacao: 'readequacao/getReadequacao',
            getUsuario: 'autenticacao/getUsuario',
        }),
        perfilAceito() {
            return this.verificarPerfil(this.perfil, this.perfisAceitos);
        },
        perfil() {
            return this.getUsuario.grupo_ativo;
        },
        /* velho em diante 
        vlDiferencaEntrePlanilhas() {
            if (typeof this.valorEntrePlanilhas.vlDiferencaPlanilhas !== 'undefined') {
                return this.valorEntrePlanilhas.vlDiferencaPlanilhas;
            }
            return false;
        },
        valorEntrePlanilhasLimpo() {
            return (
                this.valorEntrePlanilhas.PlanilhaAtivaTotal - this.valorEntrePlanilhas.PlanilhaReadequadaTotal
            ).toFixed(2);
        },
        valorSaldoAplicacao() {
            return this.dadosReadequacao.dsSolicitacao;
        },
        valorSaldoDisponivelParaUso() {
            return Number(this.valorSaldoAplicacao) + Number(this.valorEntrePlanilhasLimpo);
        },
        valorSaldoUtilizado() {
            return this.valorEntrePlanilhas.PlanilhaReadequadaTotal - this.valorEntrePlanilhas.PlanilhaAtivaTotal;
        },
        valorSaldoDisponivelParaUsoPositivo() {
            if (this.valorSaldoDisponivelParaUso > 0) {
                return true;
            }
            return false;
        },
        valorSaldoDisponivelParaUsoNeutro() {
            if (this.valorSaldoDisponivelParaUso === 0) {
                return true;
            }
            return false;
        },
        valorSaldoDisponivelParaUsoNegativo() {
            if (this.valorSaldoDisponivelParaUso < 0) {
                return true;
            }
            return false;
        },
        valorSaldoUtilizadoPositivo() {
            if (this.valorSaldoUtilizado > 0) {
                return true;
            }
            return false;
        },
        valorSaldoUtilizadoNeutro() {
            if (this.valorSaldoUtilizado === 0) {
                return true;
            }
            return false;
        },
        valorSaldoUtilizadoNegativo() {
            if (this.valorSaldoUtilizado < 0) {
                return true;
            }
            return false;
        },
        podeFinalizarReadequacao() {
            if ((this.valorSaldoDisponivelParaUsoPositivo
                 || this.valorSaldoDisponivelParaUsoNeutro)
                && this.valorSaldoUtilizadoPositivo
                && !this.readequacaoAlterada
               ) {
                return true;
            }
            return false;
        },
        mostrarBotoes() {
            if (typeof this.dadosReadequacao === 'undefined') {
                return false;
            }
            return true;
        },*/
    },
    watch: {
        getUsuario(value) {
            if (typeof value === 'object') {
                if (Object.keys(value).length > 0) {
                    this.loaded.usuario = true;
                }
            }
        },
        dadosProjeto(projeto) {
            if (typeof projeto === 'object') {
                if (Object.keys(projeto).length > 0) {
                    if (projeto.permissao === false) {
                        this.permissao = false;
                        return;
                    }
                    this.loaded.projeto = true;
                }
            }
        },
        dadosReadequacao: {
            handler(value) {
                if (value.idPronac && value.idTipoReadequacao) {
                    this.loaded.readequacao = true;
                    this.inicializarReadequacaoEditada();
                    /* velho em diante 
                    this.obterDisponivelEdicaoReadequacaoPlanilha(this.dadosProjeto.idPronac);
                    this.carregarValorEntrePlanilhas();
                    this.solicitacaoIniciada = true;
                    this.exibirPaineis = true;
*/
                } else {
                    this.exibirBotaoIniciar = true;
                }
            }
        },
        mensagem: {
            handler(mensagem) {
                if (mensagem.ativa === false
                    && mensagem.finaliza === true) {
                    this.dialog = false;
                }
            },
            deep: true,
        },
        loaded: {
            handler(value) {
                const fullyLoaded = _.keys(value).every(i => value[i]);
                if (fullyLoaded) {
                    this.loading = false;
                }
            },
            deep: true,
        },
    },
    created() {
        if (typeof this.$route.params.idPronac !== 'undefined') {
            this.idPronac = this.$route.params.idPronac;
            if (Object.keys(this.dadosProjeto).length === 0) {
                this.obterDadosIniciais();
            }
        }
    },
    methods: {
        ...mapActions({
            buscarProjetoCompleto: 'projeto/buscarProjetoCompleto',
            buscaReadequacaoPronacTipo: 'readequacao/buscaReadequacaoPronacTipo',
            excluirReadequacao: 'readequacao/excluirReadequacao',
            obterDisponivelEdicaoReadequacaoPlanilha: 'readequacao/obterDisponivelEdicaoItemSaldoAplicacao',
            obterReadequacao: 'readequacao/obterReadequacao',
            updateReadequacao: 'readequacao/updateReadequacao',
            finalizarReadequacao: 'readequacao/finalizarReadequacao',
        }),
        obterDadosIniciais() {
            this.buscarProjetoCompleto(this.idPronac);
            this.buscaReadequacaoPronacTipo({
                idPronac: this.idPronac,
                idTipoReadequacao: 22,
                stEstagioAtual: 'proponente',
            });            
        },
        inicializarReadequacaoEditada() {
            this.readequacaoEditada = {
                idPronac: this.dadosReadequacao.idPronac,
                idReadequacao: this.dadosReadequacao.idReadequacao,
                idTipoReadequacao: this.dadosReadequacao.idTipoReadequacao,
                dsAvaliacao: this.dadosReadequacao.dsAvaliacao,
                idDocumento: this.dadosReadequacao.idDocumento || '',
                dsSolicitacao: this.dadosReadequacao.dsSolicitacao,
                dsJustificativa: this.dadosReadequacao.dsJustificativa,
            };
        },
        salvarReadequacao() {
            this.updateReadequacao(this.readequacaoEditada).then(() => {
                this.mensagem.conteudo = 'Readequação salva com sucesso!';
                this.mensagem.timeout = 2300;
                this.mensagem.ativa = true;
                this.mensagem.cor = 'green darken-1';
                this.recarregarReadequacoes = true;
            });
        },
        atualizarArquivo(arquivo) {
            this.readequacaoEditada.documento = arquivo;
            this.updateReadequacao(this.readequacaoEditada).then(() => {
                this.mensagem.conteudo = 'Arquivo enviado!';
                this.mensagem.ativa = true;
                this.mensagem.finaliza = false;
                this.mensagem.cor = 'green darken-1';
                this.recarregarReadequacoes = true;
            });
        },
        removerArquivo() {
            this.readequacaoEditada.documento = '';
            this.readequacaoEditada.idDocumento = '';
            this.updateReadequacao(this.readequacaoEditada).then(() => {
                this.mensagem.conteudo = 'Arquivo removido!';
                this.mensagem.ativa = true;
                this.mensagem.finaliza = false;
                this.mensagem.cor = 'green darken-1';
                this.recarregarReadequacoes = true;
            });
        },
        arquivoTipoInvalido(payload) {
            const tiposValidos = payload.formatosAceitos.join(', ');
            this.mensagem.conteudo = `Tipo fornecido (${payload.formatoEnviado}) não é aceito. Tipos aceitos: ${tiposValidos}`;
            this.mensagem.timeout = 5000;
            this.mensagem.ativa = true;
            this.mensagem.finaliza = false;
            this.mensagem.cor = 'red lighten-1';
        },
        atualizarCampo(valor, campo) {
            this.readequacaoEditada[campo] = valor;
        },
        atualizarContador(valor, campo) {
            this.contador[campo] = valor;
            this.validar();
        },
        validar() {
            this.validacao = this.validarFormulario(
                this.readequacaoEditada,
                this.contador,
                this.minChar,
            );
        },
        /* velho em diante */
        solicitarUsoSaldo() {
            const self = this;
	         /*
                $3.ajax({
                url: '/readequacao/saldo-aplicacao/solicitar-uso-saldo',
                type: 'POST',
                data: {
                idPronac: self.idPronac,
                },
                }).done(
                () => {
                const idPronac = self.idPronac;
                const idTipoReadequacao = self.idTipoReadequacao;
                const stEstagioAtual = 'proponente';
                self.buscaReadequacaoPronacTipo({ idPronac, idTipoReadequacao, stEstagioAtual });
                self.exibirPaineis = true;
                self.exibirBotaoIniciar = false;
                self.disponivelEdicaoReadequacaoPlanilha(self.idPronac);
                self.carregarValorEntrePlanilhas();
                },
                );
              */
        },
        atualizarReadequacao(readequacao) {
            this.readequacaoAlterada = true;
            this.readequacao = readequacao;
        },
        carregarValorEntrePlanilhas() {
            const self = this;
	        /*
                $3.ajax({
                type: 'GET',
                url: '/readequacao/saldo-aplicacao/carregar-valor-entre-planilhas',
                data: {
                idPronac: self.idPronac,
                idTipoReadequacao: self.idTipoReadequacao,
                },
                }).done((response) => {
                self.valorEntrePlanilhas = response.valorEntrePlanilhas;
                });
              */
        },
        prepararExcluirReadequacao() {
            this.excluirReadequacao({
                idPronac: this.idPronac,
                idReadequacao: this.dadosReadequacao.idReadequacao,
            });
            /*
                $3('#modalExcluir .modal-content h4').html('');
                $3('#modalExcluir .modal-footer').html('<h5>Removendo os dados, aguarde...</h5>');
                let self = this;
                $3.ajax({
                type: "GET",
                url: "/readequacao/saldo-aplicacao/excluir-readequacao",
                data: {
                idPronac: self.idPronac,
                idReadequacao: self.dadosReadequacao.idReadequacao
                }
                }).done(function (response) {
                // TODO: alterar o store
                self.restaurarFormulario();
                self.mensagemSucesso(response.msg);
                self.solicitacaoIniciada = false;
                self.exibirBotaoIniciar = true;
                self.exibirPaineis = false;
                }).fail(function (response) {
                self.mensagemErro(response.responseJSON.msg)
                });
              */
        },
        restaurarFormulario() {
            this.readequacao = {
                idPronac: null,
                idReadequacao: null,
                justificativa: '',
                arquivo: null,
                idTipoReadequacao: null,
                dsSolicitacao: '',
                idArquivo: null,
                nomeArquivo: null,
            };
            this.readequacaoAlterada = false;
        },
        corValor(valor) {
            let cor = '';
            if (valor > 0) {
                cor = 'positivo';
            } else if (valor < 0) {
                cor = 'negativo';
            }
            return cor;
        },
    },
};
</script>
