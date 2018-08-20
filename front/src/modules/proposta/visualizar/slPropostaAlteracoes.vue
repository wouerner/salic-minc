<template>
    <div class="alteracoes-proposta">
            <ul class="collapsible" data-collapsible="expandable">
                 <li>
                    <div class="collapsible-header"
                         v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.identificacaoproposta, dadosHistorico.identificacaoproposta)}">
                        <i class="material-icons">assignment</i>
                        <span v-if="dadosAtuais.PRONAC">Projeto - {{dadosAtuais.PRONAC}} - {{dadosAtuais.NomeProjeto}}</span>
                        <span v-else>Proposta - {{idpreprojeto}} - {{dadosAtuais.NomeProjeto}}</span>
                    </div>
                    <div class="collapsible-body padding20">
                        <div class="row">
                            <div class="col s12 m6 l6 scroll historico">
                                <slPropostaIdentificacao
                                        :idpreprojeto="idpreprojeto"
                                        :proposta="dadosHistorico">
                                </slPropostaIdentificacao>
                            </div>
                            <div class="col s12 m6 l6 scroll atual">
                                <slPropostaIdentificacao
                                        :idpreprojeto="idpreprojeto"
                                        :proposta="dadosAtuais">
                                </slPropostaIdentificacao>
                            </div>
                        </div>
                    </div>
                </li>
                 <li>
                    <div class="collapsible-header"><i class="material-icons">history</i>Hist&oacute;rico de avalia&ccedil;&otilde;es</div>
                    <div class="collapsible-body padding10">
                        <div class="card padding10">
                            <slPropostaHistoricoAvaliacoes
                                    :idpreprojeto="idpreprojeto">
                            </slPropostaHistoricoAvaliacoes>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">person</i>Proponente</div>
                    <div class="collapsible-body padding20">
                        <div class="row">
                            <div class="col s12 m12 12 scroll">
                                <slAgenteProponente
                                        :idagente="dadosAtuais.idAgente">
                                </slAgenteProponente>
                                <slAgenteUsuario
                                        :idusuario="dadosAtuais.idUsuario">
                                </slAgenteUsuario>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"
                         v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.FichaTecnica, dadosHistorico.FichaTecnica)}" i>
                        <i class="material-icons">subject</i>Ficha t&eacute;cnica
                    </div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="card">
                            <table>
                                <tr>
                                    <td class="original historico padding20">
                                        <SalicTextoSimples
                                                :texto="dadosHistorico.FichaTecnica">
                                        </SalicTextoSimples>
                                    </td>
                                    <td class="changed atual padding20" >
                                        <SalicTextoSimples
                                                :texto="dadosAtuais.FichaTecnica">
                                        </SalicTextoSimples>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"
                         v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.ResumoDoProjeto, dadosHistorico.ResumoDoProjeto)}">
                        <i class="material-icons">subject</i>Resumo
                    </div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="card">
                            <table>
                                <tr>
                                    <td class="original historico padding20">
                                        <SalicTextoSimples
                                                :texto="dadosHistorico.ResumoDoProjeto">
                                        </SalicTextoSimples>
                                    </td>
                                    <td class="changed atual padding20">
                                        <SalicTextoSimples
                                                :texto="dadosAtuais.ResumoDoProjeto">
                                        </SalicTextoSimples>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"
                         v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.Objetivos, dadosHistorico.Objetivos)}">
                        <i class="material-icons">subject</i>Objetivos
                    </div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="card">
                            <table>
                                <tr>
                                    <td class="original historico padding20">
                                        <SalicTextoSimples
                                                :texto="dadosHistorico.Objetivos">
                                        </SalicTextoSimples>
                                    </td>
                                    <td class="changed atual padding20" >
                                        <SalicTextoSimples
                                                :texto="dadosAtuais.Objetivos">
                                        </SalicTextoSimples>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"
                         v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.EtapaDeTrabalho, dadosHistorico.EtapaDeTrabalho)}">
                        <i class="material-icons">subject</i>Etapa de Trabalho
                    </div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="card">
                            <table>
                                <tr>
                                    <td class="original historico padding20">
                                        <SalicTextoSimples
                                                :texto="dadosHistorico.EtapaDeTrabalho">
                                        </SalicTextoSimples>
                                    </td>
                                    <td class="changed atual padding20" >
                                        <SalicTextoSimples
                                                :texto="dadosAtuais.EtapaDeTrabalho">
                                        </SalicTextoSimples>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"
                         v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.Acessibilidade, dadosHistorico.Acessibilidade)}">
                        <i class="material-icons">subject</i>Acessibilidade
                    </div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="card">
                            <table>
                                <tr>
                                    <td class="original historico padding20">
                                        <SalicTextoSimples
                                                :texto="dadosHistorico.Acessibilidade">
                                        </SalicTextoSimples>
                                    </td>
                                    <td class="changed atual padding20" >
                                        <SalicTextoSimples
                                                :texto="dadosAtuais.Acessibilidade">
                                        </SalicTextoSimples>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"
                         v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.EspecificacaoTecnica, dadosHistorico.EspecificacaoTecnica)}">
                        <i class="material-icons">subject</i>Especifica&ccedil;&otilde;es t&eacute;cnicas do produto
                    </div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="card">
                            <table>
                                <tr>
                                    <td class="original historico padding20">
                                        <SalicTextoSimples :texto="dadosHistorico.EspecificacaoTecnica"></SalicTextoSimples>
                                    </td>
                                    <td class="changed atual padding20" >
                                        <SalicTextoSimples :texto="dadosAtuais.EspecificacaoTecnica"></SalicTextoSimples>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"
                         v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.Sinopse, dadosHistorico.Sinopse)}">
                        <i class="material-icons">subject</i>Sinopse de Obra
                    </div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="card">
                            <table>
                                 <tr>
                                    <td class="original historico padding20">
                                        <SalicTextoSimples :texto="dadosHistorico.Sinopse"></SalicTextoSimples>
                                    </td>
                                    <td class="changed atual padding20" >
                                        <SalicTextoSimples :texto="dadosAtuais.Sinopse"></SalicTextoSimples>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"
                         v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.DemocratizacaoDeAcesso, dadosHistorico.DemocratizacaoDeAcesso)}">
                        <i class="material-icons">subject</i>Democratiza&ccedil;&atilde;o de Acesso
                    </div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                         <div class="card">
                            <table>
                                <tr>
                                    <td class="original historico padding20">
                                        <SalicTextoSimples :texto="dadosHistorico.DemocratizacaoDeAcesso"></SalicTextoSimples>
                                    </td>
                                    <td class="changed atual padding20" >
                                        <SalicTextoSimples :texto="dadosAtuais.DemocratizacaoDeAcesso"></SalicTextoSimples>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"
                         v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.Justificativa, dadosHistorico.Justificativa)}">
                        <i class="material-icons">subject</i>Justificativa
                    </div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="card">
                            <table>
                                <tr>
                                    <td class="original historico padding20">
                                        <SalicTextoSimples :texto="dadosHistorico.Justificativa"></SalicTextoSimples>
                                    </td>
                                    <td class="changed atual padding20" >
                                        <SalicTextoSimples :texto="dadosAtuais.Justificativa"></SalicTextoSimples>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </li>
                 <li>
                    <div class="collapsible-header"
                         v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.DescricaoAtividade, dadosHistorico.DescricaoAtividade)}">
                        <i class="material-icons">subject</i>Descri&ccedil;&atilde;o de Atividades
                    </div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="card">
                            <table>
                                <tr>
                                    <td class="original historico padding20">
                                        <SalicTextoSimples :texto="dadosHistorico.DescricaoAtividade"></SalicTextoSimples>
                                    </td>
                                    <td class="changed atual padding20" >
                                        <SalicTextoSimples :texto="dadosAtuais.DescricaoAtividade"></SalicTextoSimples>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"
                         v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.abrangencia, dadosHistorico.abrangencia)}">
                        <i class="material-icons">place</i>Local de realiza&ccedil;&atilde;o/Deslocamento
                    </div>
                    <div class="collapsible-body padding20">
                        <div class="row">
                            <div class="col s12 m6 l6 scroll historico">
                                <slPropostaLocalRealizacaoDeslocamento
                                        :localizacoes="dadosHistorico"></slPropostaLocalRealizacaoDeslocamento>
                            </div>
                            <div class="col s12 m6 l6 scroll atual">
                                <slPropostaLocalRealizacaoDeslocamento
                                        :localizacoes="dadosAtuais"></slPropostaLocalRealizacaoDeslocamento>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"
                         v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.documentos_proposta, dadosHistorico.documentos_proposta)}">
                        <i class="material-icons">attachment</i>Documentos anexados
                    </div>
                    <div class="collapsible-body padding20">
                        <div class="row">
                            <div class="col s12 m6 l6 scroll historico">
                                <slPropostaDocumentos :arrayDocumentos="dadosHistorico"></slPropostaDocumentos>
                            </div>
                            <div class="col s12 m6 l6 scroll atual">
                                <slPropostaDocumentos :arrayDocumentos="dadosAtuais"></slPropostaDocumentos>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div id="plano-distribuicao" class="collapsible-header"
                         v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.tbdetalhaplanodistribuicao, dadosHistorico.tbdetalhaplanodistribuicao)}">
                        <i class="material-icons">equalizer</i>Plano Distribui&ccedil;&atilde;o
                    </div>
                    <div class="collapsible-body padding20">
                        <div class="row">
                            <div class="col s12 m6 l6 scroll historico">
                                <slPropostaPlanoDistribuicao
                                        :arrayProdutos="dadosHistorico.planodistribuicaoproduto"
                                        :arrayDetalhamentos="dadosHistorico.tbdetalhaplanodistribuicao"
                                ></slPropostaPlanoDistribuicao>
                            </div>
                            <div class="col s12 m6 l6 scroll atual">
                                <slPropostaPlanoDistribuicao
                                        :arrayProdutos="dadosAtuais.planodistribuicaoproduto"
                                        :arrayDetalhamentos="dadosAtuais.tbdetalhaplanodistribuicao"
                                ></slPropostaPlanoDistribuicao>
                            </div>
                        </div>
                    </div>
                </li>
               <li>
                    <div id="planilha-orcamentaria" class="collapsible-header"
                         v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.tbplanilhaproposta, dadosHistorico.tbplanilhaproposta)}">
                        <i class="material-icons">attach_money</i>Planilha
                        or&ccedil;ament&aacute;ria
                    </div>
                    <div class="collapsible-body padding20 active">
                        <div class="row">
                            <div class="col s12 m6 l6 scroll historico">
                                <slPropostaPlanilhaOrcamentaria
                                        :arrayPlanilha="dadosHistorico.tbplanilhaproposta"></slPropostaPlanilhaOrcamentaria>
                            </div>
                            <div class="col s12 m6 l6 scroll atual">
                                <slPropostaPlanilhaOrcamentaria
                                        :arrayPlanilha="dadosAtuais.tbplanilhaproposta"></slPropostaPlanilhaOrcamentaria>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div id="custos-vinculados" class="collapsible-header"
                         v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.tbcustosvinculados, dadosHistorico.tbcustosvinculados)}">
                        <i class="material-icons">equalizer</i>Custos Vinculados
                    </div>
                    <div class="collapsible-body padding20">
                        <div class="row">
                            <div class="col s12 m6 l6 scroll historico">
                                <slPropostaCustosVinculados
                                        :arrayCustos="dadosHistorico.tbcustosvinculados"
                                ></slPropostaCustosVinculados>
                            </div>
                            <div class="col s12 m6 l6 scroll atual">
                                <slPropostaCustosVinculados
                                        :arrayCustos="dadosAtuais.tbcustosvinculados"
                                ></slPropostaCustosVinculados>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
    </div>
</template>
<script>
import slPropostaIdentificacao from './slPropostaIdentificacao'
import slPropostaHistoricoAvaliacoes from './slPropostaHistoricoAvaliacoes'
import slAgenteProponente from '../components/slAgenteProponente'
import slAgenteUsuario from '../components/slAgenteUsuario'
import SalicTextoSimples from '@/components/SalicTextoSimples'
import slPropostaLocalRealizacaoDeslocamento from './slPropostaLocalRealizacaoDeslocamento'
import slPropostaDocumentos from './slPropostaDocumentos'
import slPropostaPlanoDistribuicao from './slPropostaPlanoDistribuicao'
import slPropostaPlanilhaOrcamentaria from './slPropostaPlanilhaOrcamentaria'
import slPropostaCustosVinculados from './slPropostaCustosVinculados'

export default {
    name: 'slPropostaAlteracoes',
    props: ['idpreprojeto', 'dadosAtuais', 'dadosHistorico'],
    components: {
        slPropostaIdentificacao,
        slPropostaHistoricoAvaliacoes,
        slAgenteProponente,
        slAgenteUsuario,
        SalicTextoSimples,
        slPropostaLocalRealizacaoDeslocamento,
        slPropostaDocumentos,
        slPropostaPlanoDistribuicao,
        slPropostaPlanilhaOrcamentaria,
        slPropostaCustosVinculados,
    },
    mounted: function () {
        this.iniciarCollapsible();
        if (this.dadosHistorico != 'undefined') {
            setTimeout(this.mostrar_diferenca, 1000)
        }
    },
    methods: {
        existe_diferenca: function (atual, historico) {

            if (typeof atual == 'object') {
                return JSON.stringify(atual) != JSON.stringify(historico);
            }

            return atual != historico;
        },
        mostrar_diferenca: function () {
            $(".alteracoes-proposta table tr").prettyTextDiff({
                cleanup: true,
                diffContainer: ".diff",
                debug: false
            });
        }, iniciarCollapsible: function () {
            $3('.collapsible').each(function () {
                $3(this).collapsible();
            });
        }
    }
};
</script>