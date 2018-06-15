Vue.component('readequacao-saldo-planilha-orcamentaria', {
    template: `
<div v-if="planilha" class="planilha-orcamentaria card">
	<ul class="collapsible no-margin" data-collapsible="expandable">
    <li v-for="(fontes, fonte) of planilhaCompleta" v-if="isObject(fontes)">
    <li v-for="(fontes, fonte) of planilhaCompleta" v-if="isObject(fontes)">
      <div class="collapsible-header active red-text fonte" :class="converterStringParaClasseCss(fonte)">
        <i class="material-icons">beenhere</i>{{fonte}}<span class="badge">R$ {{fontes.total}}</span>
      </div>
      <div class="collapsible-body no-padding">
        <ul class="collapsible no-border no-margin" data-collapsible="expandable">
          <li v-for="(produtos, produto) of fontes" v-if="isObject(produtos)">
            <div class="collapsible-header active green-text" style="padding-left: 30px;" :class="converterStringParaClasseCss(produto)">
              <i class="material-icons">perm_media</i>{{produto}}<span class="badge">R$ {{produtos.total}}</span>
            </div>
            <div class="collapsible-body no-padding no-border">
              <ul class="collapsible no-border no-margin" data-collapsible="expandable">
                <li v-for="(etapas, etapa) of produtos" v-if="isObject(etapas)">
                  <div class="collapsible-header active orange-text" style="padding-left: 50px;" :class="converterStringParaClasseCss(etapa)">
                    <i class="material-icons">label</i>{{etapa}}<span class="badge">R$ {{etapas.total}}</span>
                  </div>
                  <div class="collapsible-body no-padding no-border">
                    <ul class="collapsible no-border no-margin" data-collapsible="expandable">
                      <li v-for="(locais, local) of etapas" v-if="isObject(locais)">
                        <div class="collapsible-header active blue-text" style="padding-left: 70px;" :class="converterStringParaClasseCss(local)">
                          <i class="material-icons">place</i>{{local}} <span class="badge">R$ {{locais.total}}</span>
                        </div>
                        <div class="collapsible-body no-padding margin20 scroll-x">
													<div class="center-align margin20">
														<a class="waves-effect waves-light btn white-text btn-incluir-novo-item"
															 id_fonte="row.idFonte"
															 id_produto="row.idProduto"
															 id_etapa="row.idEtapa"
															 id_uf="row.idUF"
															 id_municipio="row.idMunicipio" >
															<i class="material-icons left">add</i>
															incluir item neste munic&iacute;pio
														</a>
													</div>
                          <table class="bordered">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th class="center-align">Item</th>
                                <th class="center-align">Unidade</th>
                                <th class="center-align">Dias</th>
                                <th class="center-align">Qtde</th>
                                <th class="center-align">Ocor.</th>
                                <th class="center-align">Vl. Unit&aacute;rio</th>
                                <th class="center-align">Vl. Aprovado</th>
                                <th class="center-align">Vl. Comprovado</th>
                                <th class="center-align">Justificativa</th>
                                <th class="center-align">A&ccedil;&atilde;o</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="row of locais" 
                                  :key="row.idPlanilhaProposta"  
                                  v-if="isObject(row)"
                                  v-bind:class="{'orange lighten-2': ultrapassaValor(row)}"
                                  >
                                <td>{{row.Seq}}</td>
                                <td>
																	<template v-if="editarItem(row)">
																		<a class="modal-trigger" href="#modalEditar">{{row.Item}}</a>
																	</template>
																	<template v-else>
																		{{row.Item}}
																	</template>
																</td>
                                <td>{{row.Unidade}}</td>
                                <td>{{row.QtdeDias}}</td>
                                <td>{{row.Quantidade}}</td>
                                <td>{{row.Ocorrencia}}</td>
                                <td>{{converterParaReal(row.vlUnitario)}}</td>
                                <td>{{converterParaReal(row.vlAprovado)}}</td>
                                <td>{{converterParaReal(row.vlComprovado)}}</td>
                                <td>{{row.dsJustificativa}}</td>
                                <td class="center-align">
																	<template v-if="itemExcluido(row)">
																		<span class="grey-text lighten-3">item exclu&iacute;do</span>
																	</template>
																	<template v-if="exibirExcluir(row)">
																		<a
																			v-on:click="excluirItem(row)"
																			title="Excluir item"
																			class=" small waves-effect waves-light red-text lighten-2">
																			<i class="material-icons">delete</i>
																		</a>
																	</template>
																</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </li>
                    </ul>
                  </div>
                </li> 
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </li>
  </ul>
	<div class="card-action">
		<span><b>Valor total do projeto:</b> R$ {{planilhaCompleta.total}}</span>			
	</div>
	<div id="modalEditar" class="modal">
		<div class="modal-content center-align">
			<h4>Edi&ccedil;&atilde;o de item</h4>
		</div>
	</div>						

</div>
<div v-else>Nenhuma planilha encontrada</div>
    `,
    props: {
	objPlanilha: {},
	perfil: '',
	link: '',
	disponivelParaAdicaoItensReadequacaoPlanilha: '',
	disponivelParaEdicaoReadequacaoPlanilha: ''
    },
    mixins: [utils],
    data: function() {
	return {
	    planilha: {}
	};
    },
    mounted: function () {
    },
    methods: {
	iniciarCollapsible: function () {
            $3('.planilha-orcamentaria .collapsible').each(function() {
                $3(this).collapsible();
            });
        },
	converterStringParaClasseCss: function(text) {
            return text.toString().toLowerCase().trim()
                       .replace(/&/g, '-and-')
                       .replace(/[\s\W-]+/g, '-');
        },
	ultrapassaValor: function (row) {
            return row.stCustoPraticado == true;

        },
	exibirExcluir: function(item) {
	    if (this.perfil != 1111) {
		return false;
	    }
	    
	    if (!_.isNull(item.vlComprovado)
		&& item.vlComprovado > 0) {
		return false;
	    } else {
		if (!this.itemExcluido(item)) {
		    return true;
		}
	    }
	},
	editarItem: function(item) {
	    if (this.perfil == 1111
		&& this.link
		&& item.vlComprovado < item.vlAprovado
		&& this.disponivelParaEdicaoReadequacaoPlanilha
		&& (item.tpAcao != 'E'
		 && item.idFonte == 109)) {
		return true;
	    }
	},
	itemExcluido: function(item) {
	    if (item.tpAcao == 'E') {
		return true;
	    }
	},
	excluirItem: function(item) {
	    if (confirm("Tem certeza que deseja excluir o item?")) {
		let self = this;
		
		$3.ajax({
                    type: 'POST',
                    url: '/readequacao/readequacoes/excluir-item-solicitacao',
		    data: {
			idPronac: self.idPronac,
			idPlanilha: item.idPlanilhaAprovacao
		    }
                }).done(function(response) {
		    item.tpAcao = 'E';
		    self.mensagemSucesso("Item exlui&iacute;do com sucesso");
		});
	    }
	}
    },
    watch: {
        objPlanilha: function (value) {
            this.planilha = value;
            this.iniciarCollapsible();
	    $3('#modalEditar').modal();
        }
    },
    computed: {
        planilhaCompleta: function () {
            if (!_.isEmpty(this.objPlanilha)) {
		this.planilha = this.objPlanilha;
            } else {
		return 0;
	    }
	    
            let novaPlanilha = {}, totalProjeto = 0, totalFonte = 0, totalProduto = 0, totalEtapa = 0, totalLocal = 0;

            novaPlanilha = this.planilha;
            Object.entries(this.planilha).forEach(([fonte, produtos]) => {
                totalFonte = 0;
                Object.entries(produtos).forEach(([produto, etapas]) => {
                    totalProduto = 0;
                    Object.entries(etapas).forEach(([etapa, locais]) => {
                        totalEtapa = 0;
                        Object.entries(locais).forEach(([local, itens]) => {
                            totalLocal = 0;
                            Object.entries(itens).forEach(([column, cell]) => {
                                totalLocal += cell.vlAprovado;
                            });
                            this.$set(this.planilha[fonte][produto][etapa][local], 'total',  numeral(totalLocal).format('0,0.00'));
                            totalEtapa += totalLocal;
                        });
                        this.$set(this.planilha[fonte][produto][etapa], 'total', numeral(totalEtapa).format('0,0.00'));
                        totalProduto += totalEtapa;
                    });
                    this.$set(this.planilha[fonte][produto], 'total', numeral(totalProduto).format('0,0.00'));
                    totalFonte += totalProduto;
                });
                this.$set(this.planilha[fonte], 'total', numeral(totalFonte).format('0,0.00'));
                totalProjeto += totalFonte;
            });
            this.$set(novaPlanilha, 'total', numeral(totalProjeto).format('0,0.00'));

            return novaPlanilha;
        }
    },
});
