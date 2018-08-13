<template>
  <div class="card">
      <div v-if="!disabled" class="card-content">
	<span class="card-title">Solicita&ccedil;&atilde;o de readequa&ccedil;&atilde;o</span>
	<input type="hidden"
	       :value="objReadequacao.idReadequacao"/>
        <div class="row">
          <div class="input-field col s12">
            <textarea
              id="textarea1"
              class="materialize-textarea"
              ref="readequacaoJustificativa"
              :disabled="disabled"      
	      :value="objReadequacao.justificativa"
	      @input="updateJustificativa"
	      ></textarea>
            <label for="textarea1">Justificativa *</label>
          </div>
        </div>
        <component
          :ds-solicitacao="objReadequacao.dsSolicitacao"
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
                       @change="subirDocumento"
		       >
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
              </div>
              <input type="hidden"
		     :value="objReadequacao.idDocumento"
		     />
            </div>
            <div id="carregando-arquivo" class="progress sumir">
              <div class="indeterminate"></div>
            </div>
            <div
	      class="col s12"
	      v-if="readequacao.idDocumento"
	      >
              Arquivo anexado: <a v-bind:href="'/readequacao/readequacoes/abrir-documento-readequacao?id=' + readequacao.idDocumento">
                {{readequacao.nomeArquivo }}
              </a>
              <a
                title="Remover aquivo"
                class=" small waves-effect waves-light red-text lighten-2"
                v-if="!disabled"
                v-show="readequacao.idDocumento"
                v-on:click="excluirDocumento"
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
	    {{readequacao.justificativa}}
	  </p>
	</div>
	<div
	  class="card-content"
	  v-if="readequacao.idDocumento"
	  >
	  <span class="card-title">Arquivo anexado</span>
	  <a
	    v-bind:href="'/readequacao/readequacoes/abrir-documento-readequacao?id=' + readequacao.idDocumento"
	    >
            {{readequacao.nomeArquivo }}
          </a>
	</div>
      </div>
  </div>
</template>
<script>
import _ from "lodash";
import numeral from "numeral";
import { utils } from "@/mixins/utils";
import { mapActions } from 'vuex';

// TODO: implementar usando slot para não ter que importar os módulos
import ReadequacaoSaldoAplicacaoSaldo from "../SaldoAplicacao/components/ReadequacaoSaldoAplicacaoSaldo";

export default {
    name: "ReadequacaoFormulario",
    components: {
	ReadequacaoSaldoAplicacaoSaldo
    },
    data: function() {
	return {
	    readequacao: {
		idPronac: "",
		idReadequacao: "",
		justificativa: "",
		arquivo: "",
		idTipoReadequacao: "",
		dsSolicitacao: "",
		idDocumento: "",
		nomeArquivo: ""
	    },
	    exibirInfo: false,
	    minCaracteresJustificativa: 10,
	    arquivo: {
		tamanhoMaximo: 500000,
		tiposAceitos: ["pdf"]
	    }
	};
    },
    props: {
	idPronac: "",
	idTipoReadequacao: "",
	objReadequacao: {},
	disabled: false,
	componenteDsSolicitacao: ""
    },
    mixins: [utils],
    methods: {
	salvarReadequacao: function() {
	    if (this.readequacao.dsSolicitacao == ''
		|| this.readequacao.dsSolicitacao == undefined
		|| this.readequacao.dsSolicitacao == 0
	    ) {
		this.mensagemAlerta("\xC9 obrigat\xF3rio informar o saldo dispon\xEDvel!");
		this.$children[0].$refs.readequacaoSaldo.$el.focus();
		return;		
	    }
	    
	    if (
		this.readequacao.dsJustificativa.length < this.minCaracteresJustificativa
	    ) {
		this.mensagemAlerta(
		    "\xC9 obrigat\xF3rio preencher a justificativa da readequa\xE7\xE3o!"
		);
		this.$refs.readequacaoJustificativa.focus();
		return;
	    }
	    this.updateReadequacao(this.readequacao);
	    //this.$emit("eventoSalvarReadequacao", this.readequacao);
	},
	subirDocumento: function() {
	    let arquivo = $("#arquivo")[0].files[0],
		self = this;
	    
	    if (!this.validarDocumento(arquivo)) {
		return;
	    }
	    var formData = new FormData();
	    formData.append("arquivo", arquivo);
	    formData.append("idPronac", self.idPronac);
	    formData.append("idTipoReadequacao", self.idTipoReadequacao);
	    formData.append("idDocumentoAtual", self.readequacao.idDocumento);
	    if (self.readequacao.idReadequacao) {
		formData.append("idReadequacao", self.readequacao.idReadequacao);
	    }
	    
	    $3("#carregando-arquivo").fadeIn("slow");
	    $3
		.ajax(
		    Object.assign(
			{},
			{
			    type: "POST",
			    url:
			    "/readequacao/readequacoes/salvar-documento/idPronac/" +
				self.idPronac,
			    processData: false,
			    contentType: false
			},
			{
			    data: formData
			}
		    )
		)
		.done(function(response) {
		    self.readequacao.idDocumento = response.documento.idDocumento;
		    self.readequacao.nomeArquivo = response.documento.nomeArquivo;
		    self.readequacao.idReadequacao = response.readequacao.idReadequacao;
		    // TODO: persistir via store
		    //self.$emit("eventoAtualizarReadequacao", self.readequacao);
		    $3("#carregando-arquivo").fadeOut("slow");
		});
	},
	excluirDocumento: function() {
	    $3("#carregando-arquivo").fadeIn("slow");
	    
	    let self = this;
	    $3
		.ajax({
		    type: "GET",
		    url: "/readequacao/readequacoes/excluir-documento",
		    data: {
			idDocumento: self.readequacao.idDocumento,
			idPronac: self.idPronac,
			idReadequacao: self.readequacao.idReadequacao
		    }
		})
		.done(function(response) {
		    self.mensagemSucesso("Documento excluido com sucesso.");
		    self.readequacao.nomeArquivo = "";
		    self.readequacao.idDocumento = "";
		    // TODO: persistir via store
		    //self.$emit("eventoAtualizarReadequacao", self.readequacao);
		    $3("#carregando-arquivo").fadeOut("slow");
		})
		.fail(function(response) {
		    self.mensagemAlerta(response.mensagem);
		    $3("#carregando-arquivo").fadeOut("slow");
		});
	},
	validarDocumento: function(arquivo) {
	    if (
		!this.arquivo.tiposAceitos.includes(
		    arquivo.name
			.split(".")
			.pop()
			.toLowerCase()
		)
	    ) {
		this.mensagemAlerta(
		    "Extens\xE3o de arquivo inv\xE1lida. Envie arquivos nos tipos: " +
			this.arquivo.tiposAceitos.join(",")
		);
		return;
	    }
	    
	    if (arquivo.size > this.arquivo.tamanhoMaximo) {
		this.mensagemAlerta(
		    "Arquivo ultrapassou o limite de " + this.arquivo.tamanhoMaximo
		);
		return;
	    }
	    return true;
	},
	updateJustificativa: function(event) {
	    this.readequacao.dsJustificativa = event.target.value;
	},
	...mapActions({
            updateReadequacao: 'readequacao/updateReadequacao',
	}),	
    },
    watch: {
	objReadequacao: function() {
	    if (!_.isEmpty(this.objReadequacao)) {
		this.readequacao.idReadequacao = this.objReadequacao.idReadequacao;
		this.readequacao.idTipoReadequacao = this.objReadequacao.idTipoReadequacao;
		this.readequacao.nomeArquivo = this.objReadequacao.nomeArquivo;
		this.readequacao.idDocumento = this.objReadequacao.idDocumento;
	    }
	},
    }
};
</script>
