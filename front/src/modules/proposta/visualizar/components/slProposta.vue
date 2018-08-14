<template>
    <div>
        <div v-if="idpreprojeto || dados" class="proposta">

            <ul class="collapsible" data-collapsible="expandable">
                 <li>
                    <div class="collapsible-header">
                        <i class="material-icons">assignment</i>
                        <span v-if="proposta.PRONAC">Projeto - {{proposta.PRONAC}} - {{proposta.NomeProjeto}}</span>
                        <span v-else>Proposta - {{idpreprojeto}} - {{proposta.NomeProjeto}}</span>
                    </div>
                    <div class="collapsible-body padding20">
                        <div class="row">
                            <div class="col s12 m12 l12 scroll">
                                 <slPropostaIdentificacao
                                         :idpreprojeto="idpreprojeto"
                                         :proposta="dados">
                                 </slPropostaIdentificacao>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">history</i>Hist&oacute;rico de avalia&ccedil;&otilde;es</div>
                    <div class="collapsible-body padding20">
                        <slPropostaHistoricoAvaliacoes
                                :idpreprojeto="dados.idPreProjeto"
                                :proposta="dados"
                        ></slPropostaHistoricoAvaliacoes>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">person</i>Proponente</div>
                    <div class="collapsible-body padding20">
                        <slAgenteProponente :idagente="dados.idAgente"></slAgenteProponente>
                        <slAgenteUsuario :idusuario="dados.idUsuario"></slAgenteUsuario>
                    </div>
                </li>

                <li>
                    <div class="collapsible-header"><i class="material-icons">subject</i>Ficha t&eacute;cnica</div>
                    <div class="collapsible-body padding20" v-if="dados">
                        <div class="card padding20">
                            <slTextoSimples :texto="dados.FichaTecnica"></slTextoSimples>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">subject</i>Resumo</div>
                    <div class="collapsible-body padding20" v-if="dados">
                        <div class="card padding20">
                            <slTextoSimples :texto="dados.ResumoDoProjeto"></slTextoSimples>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">subject</i>Objetivos</div>
                    <div class="collapsible-body padding20" v-if="dados">
                        <div class="card padding20">
                            <slTextoSimples :texto="dados.Objetivos"></slTextoSimples>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">subject</i>Etapa de Trabalho</div>
                    <div class="collapsible-body padding20" v-if="dados">
                        <div class="card padding20">
                            <slTextoSimples :texto="dados.EtapaDeTrabalho"></slTextoSimples>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">subject</i>Acessibilidade</div>
                    <div class="collapsible-body padding20" v-if="dados">
                        <div class="card padding20">
                            <slTextoSimples :texto="dados.Acessibilidade"></slTextoSimples>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">subject</i>Especifica&ccedil;&otilde;es t&eacute;cnicas
                        do produto
                    </div>
                    <div class="collapsible-body padding20" v-if="dados">
                        <div class="card padding20">
                            <slTextoSimples :texto="dados.EspecificacaoTecnica"></slTextoSimples>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">subject</i>Sinopse de Obra</div>
                    <div class="collapsible-body padding20" v-if="dados">
                        <div class="card padding20">
                            <slTextoSimples :texto="dados.Sinopse"></slTextoSimples>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">subject</i>Democratiza&ccedil;&atilde;o de Acesso</div>
                    <div class="collapsible-body padding20" v-if="dados">
                        <div class="card padding20">
                            <slTextoSimples :texto="dados.DemocratizacaoDeAcesso"></slTextoSimples>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">subject</i>Justificativa</div>
                    <div class="collapsible-body padding20" v-if="dados">
                        <div class="card padding20">
                            <salicTextoSimples :texto="dados.Justificativa"></salicTextoSimples>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">subject</i>Descri&ccedil;&atilde;o de Atividades</div>
                    <div class="collapsible-body padding20" v-if="dados">
                        <div class="card padding20">
                            <slTextoSimples :texto="dados.DescricaoAtividade"></slTextoSimples>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">attachment</i>Documentos anexados</div>
                    <div class="collapsible-body padding20">
                        <slPropostaDocumentos :proposta="dados"></slPropostaDocumentos>
                    </div>
                </li>
                <li>
                    <div id="plano-distribuicao" class="collapsible-header"><i class="material-icons">equalizer</i>Plano
                        Distribui&ccedil;&atilde;o
                    </div>
                    <div class="collapsible-body padding20">
                        <slPropostaPlanoDistribuicao
                                :arrayProdutos="dados.planodistribuicaoproduto"
                                :arrayDetalhamentos="dados.tbdetalhaplanodistribuicao"
                        ></slPropostaPlanoDistribuicao>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">history</i>Fonte de Recurso</div>
                    <div class="collapsible-body padding20">
                        <slPropostaFontesDeRecursos
                                :idpreprojeto="idpreprojeto">
                        </slPropostaFontesDeRecursos>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">place</i>Local de realiza&ccedil;&atilde;o/Deslocamento
                    </div>
                    <div class="collapsible-body padding20">
                        <slPropostaLocalRealizacaoDeslocamento
                                :idpreprojeto="idpreprojeto"></slPropostaLocalRealizacaoDeslocamento>
                    </div>
                </li>
                <li>
                    <div id="planilha-orcamentaria" class="collapsible-header"><i class="material-icons">attach_money</i>Planilha
                        or&ccedil;ament&aacute;ria
                    </div>
                    <div class="collapsible-body padding20">
                        <slPropostaPlanilhaOrcamentaria
                                :arrayPlanilha="dados.tbplanilhaproposta"
                        ></slPropostaPlanilhaOrcamentaria>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">attach_money</i>Custos Vinculados</div>
                    <div class="collapsible-body padding20" v-if="dados">
                         <slPropostaCustosVinculados
                                 :arrayCustos="dados.tbcustosvinculados"
                         ></slPropostaCustosVinculados>
                    </div>
                </li>
            </ul>
        </div>
        <div v-else class="center-align">
            <div class="padding10 green white-text">Opa! Proposta n&atilde;o informada...</div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'slProposta',
    data: function () {
        return {
            dados: {
                type: Object,
                default: function () {
                    return {}
                }
            }
        }
    },
    props: ['idpreprojeto', 'proposta'],
    mounted: function () {
        if(typeof this.idpreprojeto != 'undefined' && typeof this.proposta == 'undefined') {
            this.buscar_dados();
        }

        if(typeof this.proposta != 'undefined') {
            this.dados = this.proposta;
        }

        this.iniciarCollapsible();
    },
    methods: {
        buscar_dados: function () {
            let vue = this;
            $3.ajax({
                url: '/proposta/visualizar/obter-identificacao/idPreProjeto/' + vue.idpreprojeto
            }).done(function (response) {
                vue.dados = response.data;
            });
        },
        iniciarCollapsible: function () {
            $3('.collapsible').each(function () {
                $3(this).collapsible();
            });
        }
    },
};
</script>