<template>
    <div>
        <v-data-table
            :headers="headers"
            :items="dadosListagem"
            class="elevation-1 container-fluid"
            rows-per-page-text="Items por Página"
            hide-actions
        >
            <template slot="items" slot-scope="props">
                <td class="text-xs-center">
                    <v-btn flat icon>
                        <v-tooltip bottom>
                            <v-icon
                                    slot="activator"
                                    @click="showItem(props.item.idFiscalizacao)"
                                    class="material-icons"
                                    color="green"
                                    dark>add
                            </v-icon>
                            <span>Visualizar Dados Fiscalizacao</span>
                        </v-tooltip>
                    </v-btn>
                </td>
                <td class="text-xs-center" v-html="props.item.dtInicio"></td>
                <td class="text-xs-center">{{ props.item.dtFim }}</td>
                <td class="text-xs-center">{{ props.item.cpfTecnico }}</td>
                <td class="text-xs-center">{{ props.item.nmTecnico }}</td>
            </template>
        </v-data-table>
        <v-layout row justify-center>
            <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
            <v-card>
                <v-toolbar dark color="primary">
                    <v-btn icon dark @click="dialog = false">
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Dados Fiscalizacao Completos</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-container style="max-width: 100%;">

                    <v-timeline>
                        <v-timeline-item
                        fill-dot
                        left
                        >
                            <span
                                slot="opposite"
                                :class="`headline font-weight-bold green--text`"
                            >Locais</span>
                            <v-card>
                                <v-container>
                                    <v-layout>
                                        <v-flex xs4 offset-xs1>
                                            <p><b>REGIAO</b></p>
                                        </v-flex>
                                        <v-flex xs4 offset-xs1 class="pl-4">
                                            <p><b>UF</b></p>
                                        </v-flex>
                                        <v-flex xs4 offset-xs1>
                                            <p><b>CIDADE</b></p>
                                        </v-flex>
                                    </v-layout>
                                    <v-layout v-for="(dado, index) in dadosVisualizacao.locaisFiscalizacao" :key="index">
                                        <v-flex xs4 offset-xs1>
                                            <p>{{ dado.regiao }}</p>
                                        </v-flex>
                                        <v-flex xs4 offset-xs1>
                                            <p>{{ dado.uf }}</p>
                                        </v-flex>
                                        <v-flex xs4 offset-xs1>
                                            <p>{{ dado.cidade }}</p>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card>
                        </v-timeline-item>

                        <v-timeline-item  class="justify-center"
                        fill-dot
                        right
                        >
                            <v-card>
                                <v-card-title class="primary justify-center">
                                    <h2 class="display-1 white--text font-weight-light">Oficializar Fiscalização</h2>
                                </v-card-title>
                            </v-card>
                        </v-timeline-item>

                        <v-timeline-item
                        color="amber lighten-1"
                        fill-dot
                        right
                        small
                        >
                            <span
                                slot="opposite"
                                :class="`headline font-weight-bold green--text`"
                            >Datas / Demandante</span>
                            <v-card>
                                <v-container v-for="(dado, index) in dadosVisualizacao.oficializarFiscalizacao" :key="index">
                                    <v-layout >
                                        <v-flex xs6 offset-xs2>
                                            <p><b>Dt. Inicio</b></p>
                                            {{ dado.dtInicio }} <br>
                                        </v-flex>
                                        <v-flex xs6 offset-xs2>
                                            <p><b>Dt. Fim</b></p>
                                            {{ dado.dtFim }} <br>
                                        </v-flex>
                                    </v-layout>
                                    <v-layout >
                                        <v-flex xs6 offset-xs2>
                                            <br><p><b>Demandante da Fiscalização</b></p>
                                            <p v-if="dado.tpDemandante == 0" class="justify-center">SEFIC</p>
                                            <p v-else-if="dado.tpDemandante == 1">SAV</p>
                                        </v-flex>
                                        <v-flex xs6 offset-xs2>
                                            <br><p><b>Data de Resposta</b></p>
                                            <p v-if="dado.dtResposta.length > 1"> {{ dado.dtResposta }} </p>
                                            <p v-else-if="dado.dtResposta.length == 1" class="justify-center"> - </p>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card>
                        </v-timeline-item>

                        <v-timeline-item
                        fill-dot
                        left
                        small
                        >
                        <span
                                slot="opposite"
                                :class="`headline font-weight-bold green--text`"
                            >Identificação do Técnico</span>
                        <v-card>
                            <v-container v-for="(dado, index) in dadosVisualizacao.oficializarFiscalizacao" :key="index">
                                <v-layout>
                                    <v-flex xs6 offset-xs2>
                                        <p><b>CPF</b></p>
                                        {{ dado.cpfTecnico }} <br>
                                    </v-flex>
                                    <v-flex xs6 offset-xs2>
                                        <p><b>Técnico</b></p>
                                        {{ dado.nmTecnico }} <br>
                                    </v-flex>
                                </v-layout>
                                <v-layout>
                                    <v-flex xs10 offset-xs2>
                                        <br><p><b>Dados para Fiscalização</b></p>
                                        {{ dado.dsFiscalizacaoProjeto }}
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card>
                        </v-timeline-item>

                        <v-timeline-item class="justify-center"
                        color="amber lighten-1"
                        fill-dot
                        small
                        >
                            <v-card>
                                <v-card-title class="primary justify-center">
                                    <h2 class="display-1 mr-3 white--text font-weight-light">Fiscalização Concluída para Parecer</h2>
                                </v-card-title>
                            </v-card>
                        </v-timeline-item>

                        <v-timeline-item
                        color="cyan lighten-1"
                        fill-dot
                        right
                        >
                            <span
                                slot="opposite"
                                :class="`headline font-weight-bold green--text`"
                            >Resumo da Execução</span>
                            <v-card>
                                <v-container v-for="(dado, index) in dadosVisualizacao.fiscalizacaoConcluidaParecer" :key="index">
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Ações Programadas</b></p>
                                                {{ dado.resumoExecucao[index].dsAcoesProgramadas }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Ações Executadas</b></p>
                                                {{ dado.resumoExecucao[index].dsAcoesExecutadas }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Benefícios Alcançados</b></p>
                                                {{ dado.resumoExecucao[index].dsBeneficioAlcancado }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Dificuldades Encontradas</b></p>
                                                {{ dado.resumoExecucao[index].dsDificuldadeEncontrada }}
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card>
                        </v-timeline-item>

                        <v-timeline-item
                        color="cyan lighten-1"
                        fill-dot
                        left
                        >
                            <span
                                slot="opposite"
                                :class="`headline font-weight-bold green--text`"
                            >Utilização de Recursos</span>
                            <v-card>
                                <v-container v-for="(dado, index) in dadosVisualizacao.fiscalizacaoConcluidaParecer" :key="index">
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Foi apurado por unidade fiscalizadora ou auditora a aplicação irregular de recursos?</b></p>
                                                {{ dado.utilizacaoRecursos[index].stApuracaoUFiscalizacao }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Comprovou a correta utilização dos recursos da contrapartida?</b></p>
                                                {{ dado.utilizacaoRecursos[index].stComprovacaoUtilizacaoRecurso }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <div v-if="dado.stDtDeCorte == 0"><br><p><b>Há compatibilidade entre os recursos transferidos e a evolução do projeto?</b></p></div>
                                            <div v-else-if="dado.stDtDeCorte == 1"><br><p><b>Há compatibilidade entre o desembolso e a evolução?</b></p></div>
                                            {{ dado.utilizacaoRecursos[index].stCompatibilidadeDesembolsoEvo }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Ocorreu despesas com multas, juros, taxas bancárias ou correção monetária?</b></p>
                                                {{ dado.utilizacaoRecursos[index].stOcorreuDespesas }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout v-if="dado.stDtDeCorte == 1">
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Ocorreu pagamento de servidor público?</b></p>
                                                {{ dado.utilizacaoRecursos[index].stPagamentoServidorPublico }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout v-if="dado.stDtDeCorte == 1">
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Ocorreu despesa com taxa de administração?</b></p>
                                                {{ dado.utilizacaoRecursos[index].stDespesaAdministracao }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout v-if="dado.stDtDeCorte == 1">
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Há transferência de recurso para clubes/associações ou outras entidades congêneres?</b></p>
                                                {{ dado.utilizacaoRecursos[index].stTransferenciaRecurso }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout v-if="dado.stDtDeCorte == 1">
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Há despesas com publicidade, salvo as de caráter educativo, informativo ou de orientação social?</b></p>
                                                {{ dado.utilizacaoRecursos[index].stDespesasPublicidade }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout v-if="dado.stDtDeCorte == 1">
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Ocorreu aditamento prevendo alteração de objeto?</b></p>
                                                {{ dado.utilizacaoRecursos[index].stOcorreuAditamento }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <div v-if="dado.stDtDeCorte == 0"><br><p><b>Os recursos de contrapartida foram depositados na conta do projeto?</b></p></div>
                                            <div v-else-if="dado.stDtDeCorte == 1"><br><p><b>Não foram aplicados os recursos de contrapartida?</b></p></div>
                                            {{ dado.utilizacaoRecursos[index].stAplicadosRecursos }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Ocorreu aplicação de recursos em outra finalidade que não a do objeto pactuado?</b></p>
                                                {{ dado.utilizacaoRecursos[index].stAplicacaoRecursosFinalidade }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout v-if="dado.stDtDeCorte == 0">
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Os recursos captados estão sendo aplicados em conformidade com a legislação vigente?</b></p>
                                                {{ dado.utilizacaoRecursos[index].stRecursosCaptados }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout v-if="dado.stDtDeCorte == 1">
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Ocorreu saldo após o encerramento do projeto?</b></p>
                                                {{ dado.utilizacaoRecursos[index].stSaldoAposEncerramento }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout v-if="dado.stDtDeCorte == 1">
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>O saldo verificado foi recolhido ao FNC?</b></p>
                                                {{ dado.utilizacaoRecursos[index].stSaldoVerificacaoFNC }}
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card>
                        </v-timeline-item>

                        <v-timeline-item
                        color="cyan lighten-1"
                        fill-dot
                        right
                        >
                            <span
                                slot="opposite"
                                :class="`headline font-weight-bold green--text`"
                            >Comprovantes Fiscais de Despesa</span>
                            <v-card>
                                <v-container v-for="(dado, index) in dadosVisualizacao.fiscalizacaoConcluidaParecer" :key="index">
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <div v-if="dado.stDtDeCorte == 0"><br><p><b>O proponente/convenente tem mantido a documentação relativa ao projeto em arquivo próprio?</b></p></div>
                                            <div v-else-if="dado.stDtDeCorte == 1"><br><p><b>O processo está bem documentado?</b></p></div>
                                                {{ dado.comprovantesDespesa[index].stProcessoDocumentado }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout v-if="dado.stDtDeCorte == 1">
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>A documentação está completa e arquivada?</b></p>
                                                {{ dado.comprovantesDespesa[index].stDocumentacaoCompleta }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Guardam conformidade entre o executado e o aprovado?</b></p>
                                                {{ dado.comprovantesDespesa[index].stConformidadeExecucao }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <div v-if="dado.stDtDeCorte == 0"><br><p><b>Identificam o projeto com o número do Pronac/Convênio?</b></p></div>
                                            <div v-if="dado.stDtDeCorte == 1"><br><p><b>Identificam o nome do projeto e o número do convênio?</b></p></div>
                                                {{ dado.comprovantesDespesa[index].stIdentificaProjeto }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Existem despesas anteriores ao prazo de vigência?</b></p>
                                                {{ dado.comprovantesDespesa[index].stDespesaAnterior }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout v-if="dado.stDtDeCorte == 1">
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Existem despesas posteriores ao prazo de vigência?</b></p>
                                                {{ dado.comprovantesDespesa[index].stDespesaPosterior }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>As despesas coincidem com as informadas na relação de pagamentos?</b></p>
                                                {{ dado.comprovantesDespesa[index].stDespesaCoincidem }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>As despesas estão devidamente relacionadas no extrato bancário?</b></p>
                                                {{ dado.comprovantesDespesa[index].stDespesaRelacionada }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Os comprovantes fiscais estão com o atesto do recebimento?</b></p>
                                                {{ dado.comprovantesDespesa[index].stComprovanteFiscal }}
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card>
                        </v-timeline-item>

                        <v-timeline-item
                        color="cyan lighten-1"
                        fill-dot
                        left
                        >
                            <span
                                slot="opposite"
                                :class="`headline font-weight-bold green--text`"
                            >Divulgação</span>
                            <v-card>
                                <v-container v-for="(dado, index) in dadosVisualizacao.fiscalizacaoConcluidaParecer" :key="index">
                                    <v-layout v-if="dado.stDtDeCorte == 1">
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Ciência ao Poder legislativo?</b></p>
                                                {{ dado.divulgacao[index].stCienciaLegislativo }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Contemplou as exigências legais?</b></p>
                                                {{ dado.divulgacao[index].stExigenciaLegal }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Há material informativo do Projeto?</b></p>
                                                {{ dado.divulgacao[index].stMaterialInformativo }}
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card>
                        </v-timeline-item>

                        <v-timeline-item
                        color="cyan lighten-1"
                        fill-dot
                        right
                        >
                            <span
                                slot="opposite"
                                :class="`headline font-weight-bold green--text`"
                            >Execução</span>
                            <v-card>
                                <v-container v-for="(dado, index) in dadosVisualizacao.fiscalizacaoConcluidaParecer" :key="index">
                                    <v-layout v-if="dado.stDtDeCorte == 1">
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Alcançou a finalidade esperada?</b></p>
                                                {{ dado.execucao[index].stFinalidadeEsperada }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout v-if="dado.stDtDeCorte == 1">
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>As metas/etapas do Plano de Trabalho foram executadas integralmente?</b></p>
                                                {{ dado.execucao[index].stPlanoTrabalho }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <v-flex xs10 offset-xs1>
                                            <div v-if="dado.stDtDeCorte == 0"><br><p><b>O projeto está sendo executado de acordo com o aprovado?</b></p></div>
                                            <div v-if="dado.stDtDeCorte == 1"><br><p><b>A execução respeitou o aprovado?</b></p></div>
                                                {{ dado.execucao[index].stExecucaoAprovado }}
                                        </v-flex>
                                    </v-layout>
                                    <v-layout v-if="dado.stDtDeCorte == 0">
                                        <v-flex xs10 offset-xs1>
                                            <br><p><b>Observações</b></p>
                                            <div v-html="dado.execucao[index].dsObservacao"></div>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card>
                        </v-timeline-item>

                        <div v-for="(dado, index) in dadosVisualizacao.fiscalizacaoConcluidaParecer" :key="index">
                            <v-timeline-item
                            color="cyan lighten-1"
                            fill-dot
                            left
                            >
                                <span
                                    slot="opposite"
                                    :class="`headline font-weight-bold green--text`"
                                >Empregos gerados em decorrência do projeto</span>
                                <v-card>
                                    <v-container >
                                        <v-layout>
                                            <v-flex xs4 offset-xs1>
                                                <br><p><b>Diretos: </b>{{ dado.empregosGeradosProjeto[index].qtEmpregoDireto }}</p>
                                            </v-flex>
                                            <v-flex xs4 offset-xs1>
                                                <br><p><b>Indiretos: </b>{{ dado.empregosGeradosProjeto[index].qtEmpregoIndireto }}</p>
                                            </v-flex>
                                            <v-flex xs4 offset-xs1>
                                                <br><p><b>Total: </b>{{ dado.empregosGeradosProjeto[index].qtEmpregoTotal }}</p>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card>
                            </v-timeline-item>

                            <v-timeline-item
                            color="cyan lighten-1"
                            fill-dot
                            right
                            >
                                <span
                                    slot="opposite"
                                    :class="`headline font-weight-bold green--text`"
                                >Evidências</span>
                                <v-card>
                                    <v-container >
                                        <v-layout>
                                            <v-flex xs10 offset-xs1>
                                                <div v-html="dado.empregosGeradosProjeto[index].dsEvidencia"></div>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card>
                            </v-timeline-item>

                            <v-timeline-item
                            color="cyan lighten-1"
                            fill-dot
                            left
                            >
                                <span
                                    slot="opposite"
                                    :class="`headline font-weight-bold green--text`"
                                >Recomendações da Equipe</span>
                                <v-card>
                                    <v-container >
                                        <v-layout>
                                            <v-flex xs10 offset-xs1>
                                                <div v-html="dado.empregosGeradosProjeto[index].dsRecomendacaoEquipe"></div>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card>
                            </v-timeline-item>

                            <v-timeline-item
                            color="cyan lighten-1"
                            fill-dot
                            right
                            >
                                <span
                                    slot="opposite"
                                    :class="`headline font-weight-bold green--text`"
                                >Conclusão da Equipe</span>
                                <v-card>
                                    <v-container >
                                        <v-layout>
                                            <v-flex xs10 offset-xs1>
                                                <div v-if="dado.empregosGeradosProjeto[index].dsConclusaoEquipe.length > 1" v-html="dado.empregosGeradosProjeto[index].dsConclusaoEquipe"></div>
                                                <div v-else>Não se Aplica.</div>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card>
                            </v-timeline-item>

                            <v-timeline-item
                            color="cyan lighten-1"
                            fill-dot
                            left
                            >
                                <span
                                    slot="opposite"
                                    :class="`headline font-weight-bold green--text`"
                                >Parecer da Fiscalização</span>
                                <v-card>
                                    <v-container >
                                        <v-layout>
                                            <v-flex xs10 offset-xs1>
                                                <div v-html="dado.empregosGeradosProjeto[index].dsParecerTecnico"></div>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card>
                            </v-timeline-item>

                            <v-timeline-item
                            color="cyan lighten-1"
                            fill-dot
                            right
                            >
                                <span
                                    slot="opposite"
                                    :class="`headline font-weight-bold green--text`"
                                >Parecer do Coordenador</span>
                                <v-card>
                                    <v-container >
                                        <v-layout>
                                            <v-flex xs10 offset-xs1>
                                                <div v-html="dado.empregosGeradosProjeto[index].dsParecer"></div>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card>
                            </v-timeline-item>
                        </div>
                        <v-timeline-item
                            color="cyan lighten-1"
                            fill-dot
                            left
                            >
                                <span
                                    slot="opposite"
                                    :class="`headline font-weight-bold green--text`"
                                >Anexos</span>
                                <v-card>
                                    <v-container v-for="(dado, index) in dadosVisualizacao.arquivosFiscalizacao" :key="index">
                                        <v-layout>
                                            <v-flex xs10 offset-xs1>
                                                <a :href="`/upload/abrir?id=${dado.idArquivo}`"><v-icon color="black"> file_copy</v-icon>{{ dado.nmArquivo }}</a>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card>
                        </v-timeline-item>
                    </v-timeline>
                </v-container>
            </v-card>
            </v-dialog>
        </v-layout>
    </div>
</template>
<script>

    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: 'DadosFiscalizacao',
        data() {
            return {
                dialog: false,
                loading: true,
                headers: [
                    {
                        text: 'VISUALIZAR',
                        align: 'center',
                        sortable: false,
                        value: 'dados',
                    },
                    {
                        text: 'DT. INICIO',
                        align: 'center',
                        value: 'dtInicio',
                    },
                    {
                        text: 'DT. FIM',
                        align: 'center',
                        value: 'dtFim',
                    },
                    {
                        text: 'CPF TECNICO',
                        align: 'center',
                        value: 'cpfTecnico',
                    },
                    {
                        text: 'NOME TECNICO',
                        align: 'center',
                        value: 'nmTecnico',
                    },
                ],
            };
        },
        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                this.buscarDadosFiscalizacaoLista(this.dadosProjeto.idPronac);
            }
        },
        watch: {
            dadosListagem() {
                this.loading = false;
            },
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dadosListagem: 'projeto/dadosFiscalizacaoLista',
                dadosVisualizacao: 'projeto/dadosFiscalizacaoVisualiza',
            }),
        },
        methods: {
            showItem(idFiscalizacao) {
                const idPronac = this.dadosProjeto.idPronac;

                this.buscarDadosFiscalizacaoVisualiza({ idPronac, idFiscalizacao });
                this.dialog = true;

            },
            ...mapActions({
                buscarDadosFiscalizacaoLista: 'projeto/buscarDadosFiscalizacaoLista',
                buscarDadosFiscalizacaoVisualiza: 'projeto/buscarDadosFiscalizacaoVisualiza',
            }),
        },
    };
</script>

