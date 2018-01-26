Vue.component('salic-proposta-diff', {
    template: `
        <div v-if="idpreprojeto" class="proposta">
            <ul class="collapsible" data-collapsible="expandable">
                 <li>
                    <div class="collapsible-header"><i class="material-icons">assignment</i>Proposta - {{idpreprojeto}} - {{dadosAtuais.NomeProjeto}}</div>
                    <div class="collapsible-body padding20">
                        <div class="row">
                            <div class="col s6 scroll">
                                <salic-proposta-identificacao :idpreprojeto="idpreprojeto" :proposta="dadosHistorico"></salic-proposta-identificacao>
                            </div>
                            <div class="col s6 scroll">
                                <salic-proposta-identificacao :idpreprojeto="idpreprojeto" :proposta="dadosAtuais"></salic-proposta-identificacao>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header" ><i class="material-icons">person</i>Proponente</div>
                    <div class="collapsible-body padding20">
                        <div class="row">
                            <div class="col s6 scroll">
                                <salic-agente-proponente :idagente="dadosHistorico.idAgente"></salic-agente-proponente>
                                <salic-agente-usuario :idusuario="dadosHistorico.idUsuario"></salic-agente-usuario>
                            </div>
                            <div class="col s6 scroll">
                                <salic-agente-proponente :idagente="dadosAtuais.idAgente"></salic-agente-proponente>
                                <salic-agente-usuario :idusuario="dadosAtuais.idUsuario"></salic-agente-usuario>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header" v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.FichaTecnica, dadosHistorico.FichaTecnica)}" i><i class="material-icons">subject</i>Ficha t&eacute;cnica</div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="row">
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosHistorico.FichaTecnica"></salic-texto-simples>
                            </div>
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosAtuais.FichaTecnica"></salic-texto-simples>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header" v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.ResumoDoProjeto, dadosHistorico.ResumoDoProjeto)}"><i class="material-icons">subject</i>Resumo</div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="row">
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosHistorico.ResumoDoProjeto"></salic-texto-simples>
                            </div>
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosAtuais.ResumoDoProjeto"></salic-texto-simples>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header" v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.Objetivos, dadosHistorico.Objetivos)}"><i class="material-icons">subject</i>Objetivos</div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="row">
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosHistorico.Objetivos"></salic-texto-simples>
                            </div>
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosAtuais.Objetivos"></salic-texto-simples>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header" v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.EtapaDeTrabalho, dadosHistorico.EtapaDeTrabalho)}"><i class="material-icons">subject</i>Etapa de Trabalho</div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="row">
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosHistorico.EtapaDeTrabalho"></salic-texto-simples>
                            </div>
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosAtuais.EtapaDeTrabalho"></salic-texto-simples>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header" v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.Acessibilidade, dadosHistorico.Acessibilidade)}"><i class="material-icons">subject</i>Acessibilidade</div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="row">
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosHistorico.Acessibilidade"></salic-texto-simples>
                            </div>
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosAtuais.Acessibilidade"></salic-texto-simples>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header" v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.Sinopse, dadosHistorico.Sinopse)}"><i class="material-icons">subject</i>Especifica&ccedil;&otilde;es t&eacute;cnicas do produto
                    </div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="row">
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosHistorico.Sinopse"></salic-texto-simples>
                            </div>
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosAtuais.Sinopse"></salic-texto-simples>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header" v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.EspecificacaoTecnica, dadosHistorico.EspecificacaoTecnica)}"><i class="material-icons">subject</i>Sinopse de Obra</div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="row">
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosHistorico.EspecificacaoTecnica"></salic-texto-simples>
                            </div>
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosAtuais.EspecificacaoTecnica"></salic-texto-simples>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header" v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.ImpactoAmbiental, dadosHistorico.ImpactoAmbiental)}"><i class="material-icons">subject</i>Impacto Ambiental</div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="row">
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosHistorico.ImpactoAmbiental"></salic-texto-simples>
                            </div>
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosAtuais.ImpactoAmbiental"></salic-texto-simples>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header" v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.Justificativa, dadosHistorico.Justificativa)}"><i class="material-icons">subject</i>Justificativa</div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="row">
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosHistorico.Justificativa"></salic-texto-simples>
                            </div>
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosAtuais.Justificativa"></salic-texto-simples>
                            </div>
                        </div>
                    </div>
                </li>
                 <li>
                    <div class="collapsible-header" v-bind:class="{'orange lighten-4': existe_diferenca(dadosAtuais.DescricaoAtividade, dadosHistorico.DescricaoAtividade)}"><i class="material-icons">subject</i>Descri&ccedil;&atilde;o de Atividades</div>
                    <div class="collapsible-body padding20" v-if="dadosAtuais">
                        <div class="row">
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosHistorico.DescricaoAtividade"></salic-texto-simples>
                            </div>
                            <div class="col s6 scroll">
                                <salic-texto-simples :texto="dadosAtuais.DescricaoAtividade"></salic-texto-simples>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">place</i>Local de realiza&ccedil;&atilde;o/Deslocamento
                    </div>
                    <div class="collapsible-body padding20">
                        <div class="row">
                            <div class="col s6 scroll">
                                <salic-proposta-local-realizacao-deslocamento
                                :idpreprojeto="dadosAtuais.idPreProjeto"></salic-proposta-local-realizacao-deslocamento>
                            </div>
                            <div class="col s6 scroll">
                                <salic-proposta-local-realizacao-deslocamento
                                :idpreprojeto="dadosHistorico.idPreProjeto"></salic-proposta-local-realizacao-deslocamento>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">attachment</i>Documentos anexados</div>
                    <div class="collapsible-body padding20">
                        <div class="row">
                            <div class="col s6 scroll">
                                <salic-proposta-documentos :proposta="dadosHistorico"></salic-proposta-documentos>
                            </div>
                            <div class="col s6 scroll">
                                <salic-proposta-documentos :proposta="dadosAtuais"></salic-proposta-documentos>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">history</i>Hist&oacute;rico</div>
                    <div class="collapsible-body padding20">
                        <salic-proposta-historico-avaliacoes :idpreprojeto="dadosAtuais.idPreProjeto"
                                                             v-bind:proposta="dadosAtuais"></salic-proposta-historico-avaliacoes>
                    </div>
                </li>
                <li>
                    <div id="plano-distribuicao" class="collapsible-header"><i class="material-icons">equalizer</i>Plano
                        Distribui&ccedil;&atilde;o
                    </div>
                    <div class="collapsible-body padding20">
                        <div id="html-plano-distribuicao"></div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">history</i>Fonte de Recurso</div>
                    <div class="collapsible-body padding20">
                        <salic-proposta-fontes-de-recursos :idpreprojeto="idpreprojeto"></salic-proposta-fontes-de-recursos>
                    </div>
                </li>
                <li>
                    <div id="planilha-orcamentaria" class="collapsible-header"><i class="material-icons">attach_money</i>Planilha
                        or&ccedil;ament&aacute;ria
                    </div>
                    <div class="collapsible-body padding20">
                        <div id="planilhaOrcamentariaMontada"></div>
                    </div>
                </li>
            </ul>
        </div>
        <div v-else class="center-align">
            <div class="padding10 green white-text">Opa! Proposta não informada...</div>
        </div>
    `,
    data: function () {
        return {
            dadosAtuais: {
                type: Object,
                default: function () {
                    return {}
                }
            },
            dadosHistorico: {
                type: Object,
                default: function () {
                    return {}
                }
            }
        }
    },
    props: ['idpreprojeto', 'tipo'],
    mounted: function () {
        this.buscar_dados();
    },
    methods: {
        buscar_dados: function () {
            let vue = this;
            $3.ajax({
                url: '/proposta/visualizar/obter-proposta-cultural-versionamento/idPreProjeto/' + vue.idpreprojeto + '/tipo/' + vue.tipo
            }).done(function (response) {
                vue.dadosAtuais = response.data.atual;
                vue.dadosHistorico= response.data.historico
            });
        },
        existe_diferenca: function (atual, historico) {

            if(atual == historico) {
                return false;
            }

            return true;
        }
    }
});

