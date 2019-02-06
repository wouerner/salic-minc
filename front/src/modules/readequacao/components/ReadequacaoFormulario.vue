<template>
  <div class="card">
      <div v-if="!disabled" class="card-content">
	<span class="card-title">Solicita&ccedil;&atilde;o de readequa&ccedil;&atilde;o</span>
	<input type="hidden"
	       :value="dadosReadequacao.idReadequacao"/>
        <div class="row">
          <div class="input-field col s12">
            <textarea
              id="textarea1"
              class="materialize-textarea"
              ref="readequacaoJustificativa"
              :disabled="disabled"
	      :value="dadosReadequacao.justificativa"
	      @input="updateJustificativa"
	      ></textarea>
            <label for="textarea1">Justificativa *</label>
          </div>
        </div>
        <component
          :ds-solicitacao="dadosReadequacao.dsSolicitacao"
          :disabled="disabled"
          v-bind:is="componenteDsSolicitacao"
          ></component>
        <div class="row">
          <div class="col s12">
            <div v-if="!disabled" class="file-field input-field">
              <div class="btn">
                <span>Selecionar arquivo</span>
                <input type="file"
                       name="arquivo"
                       id="arquivo"
                       @change="prepararAdicionarDocumento"
		       >
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
              </div>
              <input type="hidden"
		     :value="dadosReadequacao.idDocumento"
		     />
            </div>
            <div id="carregando-arquivo" class="progress sumir">
              <div class="indeterminate"></div>
            </div>
            <div
	      class="col s12"
	      v-show="arquivoAnexado"
	      >
              Arquivo anexado: <a v-bind:href="'/readequacao/readequacoes/abrir-documento-readequacao?id=' + dadosReadequacao.idDocumento">
                {{dadosReadequacao.nomeArquivo }}
              </a>
              <a
                title="Remover aquivo"
                class=" small waves-effect waves-light red-text lighten-2"
                v-if="!disabled"
                v-on:click="preparaExcluirDocumento"
		>
                <i class="material-icons">delete</i>
              </a>
            </div>
          </div>
        </div>
        <div v-if="!disabled" class="row">
          <div class="right-align padding20 col s12">
            <button
	      class="waves-effect waves-light btn btn-primary"
	      v-on:click="salvarReadequacao"
	      >
              <i class="material-icons right">save</i>Salvar
            </button>
          </div>
        </div>
      </div>
      <div v-if="disabled && exibirInfo">
	<div class="card-content">
	  <span class="card-title">Solicita&ccedil;&atilde;o de readequa&ccedil;&atilde;o</span>
	  <p>
	    {{dadosReadequacao.justificativa}}
	  </p>
	</div>
	<div
	  class="card-content"
	  v-if="readequacao.idDocumento"
	  >
	  <span class="card-title">Arquivo anexado</span>
	  <a
	    v-bind:href="'/readequacao/readequacoes/abrir-documento-readequacao?id=' + dadosReadequacao.idDocumento"
	    >
            {{dadosReadequacao.nomeArquivo }}
          </a>
	</div>
      </div>
  </div>
</template>
<script>
import _ from 'lodash';
import { utils } from '@/mixins/utils';
import { mapActions, mapGetters } from 'vuex';

// TODO: implementar usando slot para não ter que importar os módulos
import ReadequacaoSaldoAplicacaoSaldo from '../SaldoAplicacao/components/ReadequacaoSaldoAplicacaoSaldo';

export default {
    name: 'ReadequacaoFormulario',
    components: {
        ReadequacaoSaldoAplicacaoSaldo,
    },
    data() {
        return {
            readequacao: {
                idPronac: '',
                idReadequacao: '',
                justificativa: '',
                arquivo: '',
                idTipoReadequacao: '',
                dsSolicitacao: '',
                idDocumento: '',
                nomeArquivo: '',
            },
            exibirInfo: false,
            minCaracteresJustificativa: 10,
            arquivo: {
                tamanhoMaximo: 500000,
                tiposAceitos: ['pdf'],
            },
            excluindoDocumento: false,
        };
    },
    props: {
        idPronac: '',
        idTipoReadequacao: '',
        objReadequacao: {},
        disabled: false,
        componenteDsSolicitacao: '',
    },
    mixins: [utils],
    methods: {
        salvarReadequacao() {
            if (this.dadosReadequacao.dsSolicitacao === 0 || this.dadosReadequacao.dsSolicitacao === '0,00') {
                this.mensagemAlerta('\xC9 obrigat\xF3rio informar o saldo dispon\xEDvel; o valor deve ser diferente de R$ 0,00!');
                this.$children[0].$children[0].$refs.input.focus();
                return;
            }
            if (this.readequacao.justificativa.length < this.minCaracteresJustificativa) {
                this.mensagemAlerta(
                    `\xC9 obrigat\xF3rio preencher a justificativa da readequa\xE7\xE3o! M\xEDnimo de ${this.minCaracteresJustificativa} caracteres.`,
                );
                this.$refs.readequacaoJustificativa.focus();
                return;
            }
            this.readequacao.dsSolicitacao = this.$parent.$refs.formulario.$children[0].dsSolicitacao;
            this.updateReadequacaoSaldoAplicacao(this.readequacao);
        },
        prepararAdicionarDocumento() {
            const arquivos = document.getElementById('arquivo');
            const arquivo = arquivos.files[0];
            if (!this.validarDocumento(arquivo)) {
                return;
            }
            this.adicionarDocumento({
                arquivo,
                idPronac: this.dadosReadequacao.idPronac,
                idReadequacao: this.dadosReadequacao.idReadequacao,
                idTipoReadequacao: this.dadosReadequacao.idTipoReadequacao,
                idDocumentoAtual: this.dadosReadequacao.idDocumento,
            });
        },
        preparaExcluirDocumento() {
            this.excluindoDocumento = true;
            this.excluirDocumento({
                idDocumento: this.dadosReadequacao.idDocumento,
                idPronac: this.dadosReadequacao.idPronac,
                idReadequacao: this.dadosReadequacao.idReadequacao,
            });
        },
        validarDocumento(arquivo) {
            if (
                !this.arquivo.tiposAceitos.includes(
                    arquivo.name
                        .split('.')
                        .pop()
                        .toLowerCase(),
                )
            ) {
                this.mensagemAlerta(
                    `Extens\xE3o de arquivo inv\xE1lida. Envie arquivos nos tipos: ${this.arquivo.tiposAceitos.join(',')}`,
                );
                return false;
            }
            if (arquivo.size > this.arquivo.tamanhoMaximo) {
                this.mensagemAlerta(
                    `Arquivo ultrapassou o limite de ${this.arquivo.tamanhoMaximo}`,
                );
                return false;
            }
            return true;
        },
        updateJustificativa(event) {
            this.readequacao.justificativa = event.target.value;
        },
        ...mapActions({
            updateReadequacao: 'readequacao/updateReadequacao',
            adicionarDocumento: 'readequacao/adicionarDocumento',
            excluirDocumento: 'readequacao/excluirDocumento',
        }),
    },
    computed: {
        ...mapGetters({
            dadosReadequacao: 'readequacao/readequacao',
        }),
        arquivoAnexado() {
            if (this.dadosReadequacao.idDocumento !== '') {
                return true;
            }
            return false;
        },
    },
    watch: {
        objReadequacao() {
            if (!_.isEmpty(this.objReadequacao)) {
                this.readequacao.idReadequacao = this.objReadequacao.idReadequacao;
                this.readequacao.idTipoReadequacao = this.objReadequacao.idTipoReadequacao;
                this.readequacao.nomeArquivo = this.objReadequacao.nomeArquivo;
                this.readequacao.idDocumento = this.objReadequacao.idDocumento;
                this.readequacao.idPronac = this.objReadequacao.idPronac;
                this.readequacao.justificativa = this.objReadequacao.justificativa;
            }
        },
    },
};
</script>
