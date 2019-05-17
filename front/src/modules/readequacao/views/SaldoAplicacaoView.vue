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
                <carregando :text="'Montando readequação de saldo de aplicação...'"/>
            </v-flex>
            <v-flex v-else>
                <v-toolbar
                    color="#0A420E"
                    dark
                >
                    <v-btn
                        icon
                        color="#0A420E"
                        href="voltar()"
                    >
                        <v-icon color="white">arrow_back</v-icon>
                    </v-btn>
                    <v-toolbar-title>Readequação - Saldo de Aplicação</v-toolbar-title>
                    <v-spacer/>
                    <v-toolbar-title>
                        {{ dadosProjeto.Pronac }} - {{ dadosProjeto.NomeProjeto }}
                    </v-toolbar-title>
                </v-toolbar>
                <v-layout
                    column
                    row
                    pb-2
                >
                    <v-flex
                        v-if="novaReadequacao"
                        offset-xs5
                        class="mt-4"
                    >
                        <div v-show="novaReadequacao">
                            <v-btn
                                dark
                                class="blue"
                                @click="acionarSolicitarUsoSaldo()"
                            >
                                <v-icon>border_color</v-icon>
                                Solicitar uso do saldo de aplicação
                            </v-btn>
                        </div>
                    </v-flex>
                    <v-flex
                        v-if="!novaReadequacao"
                        xs12
                    >
                        <v-expansion-panel
                            popout
                        >
                            <v-expansion-panel-content
                                :key="1"
                            >
                                <div
                                    slot="header"
                                    class="inline-block"
                                >
                                    <v-icon
                                        color="green darken-3"
                                    >assignment</v-icon>
                                    <span
                                        class="headline grey--text text--darken-3">
                                        Dados da readequação
                                    </span>
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
                                        @editor-texto-counter="atualizarContador($event, 'solicitacao')"
                                    />
                                </v-card>
                            </v-expansion-panel-content>
                            <v-expansion-panel-content
                                :key="2"
                            >
                                <div
                                    slot="header"
                                >
                                    <v-icon
                                        color="green darken-4"
                                    >grid_on</v-icon>
                                    <span
                                        class="headline grey--text text--darken-3"
                                    >Edição da Planilha</span>
                                </div>
                                <v-card>
                                    <saldo-aplicacao-resumo
                                        :saldo-declarado="dadosReadequacao.dsSolicitacao"
                                        :saldo-disponivel="saldoDisponivel"
                                        :saldo-utilizado="saldoUtilizado"
                                    />
                                    <s-planilha
                                        :array-planilha="getPlanilha"
                                        :expand-all="true"
                                        :list-items="true"
                                        :agrupamentos="agrupamentos"
                                        :totais="totaisPlanilha"
                                    >
                                        <template
                                            slot="badge"
                                            slot-scope="slotProps"
                                        >
                                            <v-chip
                                                v-if="slotProps.planilha.VlSolicitado"
                                                outline="outline"
                                                label="label"
                                                color="#565555"
                                            >
                                                R$ {{ formatarParaReal(slotProps.planilha.VlSolicitado) }}
                                            </v-chip>
                                        </template>
                                        <template slot-scope="slotProps">
                                            <!--<s-analise-de-custos-planilha-itens-solicitado :table="slotProps.itens" />-->
                                        </template>
                                    </s-planilha>
                                </v-card>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                    </v-flex>
                    <v-footer
                        v-if="!novaReadequacao"
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
                                <excluir-button
                                    :dados-readequacao="dadosReadequacao"
                                    :dados-projeto="dadosProjeto"
                                    :origem="'saldo'"
                                    :perfis-aceitos="getPerfis('proponente')"
                                    :perfil="perfil"
                                    :tela-edicao="true"
                                    @excluir-readequacao="excluirReadequacao"
                                />
                                <finalizar-button
                                    :dados-readequacao="readequacaoEditada"
                                    :dados-projeto="dadosProjeto"
                                    :tela-edicao="true"
                                    :perfis-aceitos="getPerfis('proponente')"
                                    :perfil="perfil"
                                    :min-char="minChar"
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
    </v-container>
</template>
<script>

import _ from 'lodash';
import { mapActions, mapGetters } from 'vuex';
import { utils } from '@/mixins/utils';
import Const from '../const';
import Mensagem from '../components/Mensagem';
import FinalizarButton from '../components/FinalizarButton';
import validarFormulario from '../mixins/validarFormulario';
import verificarPerfil from '../mixins/verificarPerfil';
import Carregando from '@/components/CarregandoVuetify';
import FormReadequacao from '../components/FormReadequacao';
import UploadFile from '../components/UploadFile';
import ValorDisponivel from '../components/ValorDisponivel';
import SaldoAplicacaoResumo from '../components/SaldoAplicacaoResumo';
import ExcluirButton from '../components/ExcluirButton';
import SPlanilha from '@/components/Planilha/Planilha';
import MxPlanilha from '@/mixins/planilhas';

export default {
    name: 'SaldoAplicacaoView',
    components: {
        Mensagem,
        FinalizarButton,
        Carregando,
        UploadFile,
        ValorDisponivel,
        FormReadequacao,
        SaldoAplicacaoResumo,
        ExcluirButton,
        SPlanilha,
    },
    mixins: [
        utils,
        validarFormulario,
        verificarPerfil,
        MxPlanilha,
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
                solicitacao: 0,
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
            permissao: true,
            formatosAceitos: ['application/pdf'],
            novaReadequacao: true,
            totaisPlanilha: [
                {
                    label: 'Valor Solicitado',
                    column: 'VlSolicitado',
                },
            ],
            planilhaSaldo: [],
            agrupamentos: ['FonteRecurso', 'Produto', 'Etapa', 'UF', 'Cidade'],
        };
    },
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
            dadosReadequacao: 'readequacao/getReadequacao',
            getUsuario: 'autenticacao/getUsuario',
            getPlanilha: 'readequacao/getPlanilha',
        }),
        perfilAceito() {
            return this.verificarPerfil(this.perfil, this.perfisAceitos);
        },
        perfil() {
            return this.getUsuario.grupo_ativo;
        },
        saldoDisponivel() {
            return this.dadosReadequacao.dsSolicitacao;
        },
        saldoUtilizado() {
            return this.dadosReadequacao.dsSolicitacao;
        },
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
                this.loaded.readequacao = true;
                if (typeof value !== 'undefined') {
                    this.novaReadequacao = false;
                    if (value.idPronac && value.idTipoReadequacao) {
                        this.inicializarReadequacaoEditada();
                    } else {
                        this.novaReadequacao = true;
                    }
                }
            },
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
            obterDisponivelEdicaoReadequacaoPlanilha: 'readequacao/obterDisponivelEdicaoItemSaldoAplicacao',
            obterReadequacao: 'readequacao/obterReadequacao',
            updateReadequacao: 'readequacao/updateReadequacao',
            finalizarReadequacao: 'readequacao/finalizarReadequacao',
            solicitarUsoSaldo: 'readequacao/solicitarUsoSaldo',
            obterPlanilha: 'readequacao/obterPlanilha',
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
            this.obterPlanilha({
                idPronac: this.dadosReadequacao.idPronac,
                idTipoReadequacao: this.dadosReadequacao.idTipoReadequacao,
            });
        },
        salvarReadequacao() {
            this.updateReadequacao(this.readequacaoEditada).then(() => {
                this.mensagem.conteudo = 'Readequação salva com sucesso!';
                this.mensagem.timeout = 2300;
                this.mensagem.ativa = true;
                this.mensagem.cor = 'green darken-1';
            });
        },
        atualizarArquivo(arquivo) {
            this.readequacaoEditada.documento = arquivo;
            this.updateReadequacao(this.readequacaoEditada).then(() => {
                this.mensagem.conteudo = 'Arquivo enviado!';
                this.mensagem.ativa = true;
                this.mensagem.finaliza = false;
                this.mensagem.cor = 'green darken-1';
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
        getPerfis(tipo) {
            return this.perfisAceitos[tipo];
        },
        voltar() {
            this.$router.back();
        },
        excluirReadequacao() {
            this.loading = true;
            this.novaReadequacao = true;
        },
        acionarSolicitarUsoSaldo() {
            this.solicitarUsoSaldo({
                idPronac: this.idPronac,
            });
        },
    },
};
</script>
