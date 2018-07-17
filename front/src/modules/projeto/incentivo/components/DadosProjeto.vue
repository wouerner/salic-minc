<template>
    <div id="conteudo">
        <div v-if="loading" class="row">
            <Carregando :text="'Carregando o projeto'"></Carregando>
        </div>
        <div v-show="Object.keys(dadosProjeto).length > 0">
            <table class="tabela">
                <tr class="destacar">
                    <td><b>PRONAC</b></td>
                    <td><b>Nome do Projeto</b></td>
                </tr>
                <tr>
                    <td>{{ dadosProjeto.Pronac }}</td>
                    <td>{{ dadosProjeto.NomeProjeto }}</td>
                </tr>
                <tr class="destacar">
                    <td><b>CNPJ/CPF</b></td>
                    <td><b>Proponente</b></td>
                </tr>
                <tr>
                    <td>
                        <span v-if="dadosProjeto.idUsuarioExterno" ><SalicFormatarCpfCnpj :cpf="dadosProjeto.CgcCPf"/></span>
                        <a  v-else
                           :href="'/default/relatorio/resultado-projeto?cnpfcpf=' + dadosProjeto.CgcCPf">
                            <SalicFormatarCpfCnpj :cpf="dadosProjeto.CgcCPf"/>
                        </a>
                    </td>
                    <td>
                        <router-link :to="{ name: 'proponente', params: { idPronac: idPronac }}">
                            <span v-html="dadosProjeto.Proponente"></span>
                        </router-link>
                    </td>
                </tr>
            </table>
            <div class="row" v-if="dadosProjeto.ProponenteInabilitado">
                <div style="background-color: #EF5350" class="darken-2 padding10 white-text">
                    <div><b>Proponente Inabilitado</b></div>
                </div>
            </div>
            <table class="tabela">
                <tr class="destacar">
                    <td class="centro"><b>UF</b></td>
                    <td class="centro"><b>Mecanismo</b></td>
                    <td class="centro"><b>&Aacute;rea Cultural</b></td>
                    <td class="centro"><b>Segmento Cultural</b></td>
                    <td class="centro"><b>Enquadramento</b></td>
                </tr>
                <tr>
                    <td align="center">
                        <SalicTextoSimples :texto="dadosProjeto.UfProjeto"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="dadosProjeto.Mecanismo"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="dadosProjeto.Area"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="dadosProjeto.Segmento"/>
                    </td>
                    <td align="center" class="bold destacar">
                        <SalicTextoSimples :texto="dadosProjeto.Enquadramento"/>
                    </td>
                </tr>
            </table>

            <table class="tabela">
                <tr class="destacar">
                    <td class="centro">
                        <b>
                            <CharsetEncode :texto="'N&ordm; Proposta'"></CharsetEncode>
                        </b>
                    </td>
                    <td class="centro"><b>Data Fixa</b></td>
                    <td class="centro"><b>Processo</b></td>
                    <!-- <td class="centro"><b>Prorroga&ccedil;&atilde;o autom&aacute;tica</b></td> -->
                    <td class="centro">
                        <b>
                            <CharsetEncode :texto="'Prorroga&ccedil;&atilde;o autom&aacute;tica'"></CharsetEncode>
                        </b>
                    </td>
                    <td class="centro">
                        <b>
                            <CharsetEncode :texto="'Plano de Execu&ccedil;&atilde;o Imediata'"></CharsetEncode>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <SalicTextoSimples :texto="dadosProjeto.idPreProjeto"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="dadosProjeto.DataFixa"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="dadosProjeto.Processo"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="dadosProjeto.ProrrogacaoAutomatica"/>
                    </td>
                    <td align="center" class="destacar">
                        <SalicTextoSimples :texto="dadosProjeto.PlanoExecucaoImediata"/>
                    </td>
                </tr>
            </table>

            <table class="tabela">
                <tr class="destacar">
                    <td colspan="2" class="centro bold">
                        <CharsetEncode :texto="'Per&iacute;odo de capta&ccedil;&atilde;o'"></CharsetEncode>
                    </td>
                    <td colspan="2" class="centro bold">
                        <CharsetEncode :texto="'Per&iacute;odo de execu&ccedil;&atilde;o'"></CharsetEncode>
                    </td>
                    <td colspan="3" class="centro bold">
                        <CharsetEncode :texto="'Per&iacute;odo Vigente'"></CharsetEncode>
                    </td>
                </tr>
                <tr class="destacar">
                    <td class="centro">
                        <b>
                            <CharsetEncode :texto="'Dt. In&iacute;cio'"></CharsetEncode>
                        </b>
                    </td>
                    <td class="centro">
                        <b>
                            Dt. Final
                        </b>
                    </td>
                    <td class="centro">
                        <b>
                            <CharsetEncode :texto="'Dt. In&iacute;cio'"></CharsetEncode>
                        </b>
                    </td>
                    <td class="centro">
                        <b>
                            Dt. Final
                        </b>
                    </td>
                    <td class="centro">
                        <b>
                            Tipo de portaria
                        </b>
                    </td>
                    <td class="centro">
                        <b>
                            <CharsetEncode :texto="'N&ordm; Portaria'"></CharsetEncode>
                        </b>
                    </td>
                    <td class="centro">
                        <b>
                            <CharsetEncode :texto="'Dt. Publica&ccedil;&atilde;o'"></CharsetEncode>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td align="center"
                        class="bold destacar text-darken-2"
                        :class="[ isDataExpirada(dadosProjeto.DtFimCaptacao) ? 'orange-text' : 'green-text' ]"
                    >{{ dadosProjeto.DtInicioCaptacao | formatarData }}
                    </td>
                    <td align="center"
                        class="bold destacar text-darken-2"
                        :class="[ isDataExpirada(dadosProjeto.DtFimCaptacao) ? 'orange-text' : 'green-text' ]"
                    >{{ dadosProjeto.DtFimCaptacao | formatarData }}
                    </td>
                    <td align="center"
                        class="bold destacar text-darken-2"
                        :class="[ isDataExpirada(dadosProjeto.DtFimExecucao) ? 'orange-text' : 'green-text' ]"
                    >{{ dadosProjeto.DtInicioExecucao | formatarData }}
                    </td>
                    <td align="center"
                        class="bold destacar text-darken-2"
                        :class="[ isDataExpirada(dadosProjeto.DtFimExecucao) ? 'orange-text' : 'green-text' ]"
                    >{{ dadosProjeto.DtFimExecucao | formatarData }}
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="dadosProjeto.NrPortariaVigente"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="dadosProjeto.TipoPortariaVigente"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="dadosProjeto.DtPublicacaoPortariaVigente"/>
                    </td>
                </tr>
            </table>

            <table class="tabela">
                <tr class="destacar">
                    <td align="center" colspan="5">
                        <b>
                            <CharsetEncode :texto="'Informa&ccedil;&otilde;es banc&aacute;rias'"></CharsetEncode>
                        </b>
                    </td>
                </tr>
                <tr class="destacar">
                    <td class="centro" rowspan="2">
                        <b>
                            <CharsetEncode :texto="'Ag&ecirc;ncia'"></CharsetEncode>
                        </b>
                    </td>
                    <td class="centro" colspan="2">
                        <b>
                            <CharsetEncode :texto="'N&uacute;meros das Contas'"></CharsetEncode>
                        </b>
                    </td>
                    <td class="centro" rowspan="2" width="10%">
                        <b>
                            Conta Liberada
                        </b>
                    </td>
                    <td class="centro" rowspan="2">
                        <b>
                            <CharsetEncode :texto="'Dt. Libera&ccedil;&atilde;o'"></CharsetEncode>
                        </b>
                    </td>
                </tr>
                <tr class="destacar">
                    <td class="centro">
                        <b>
                            <CharsetEncode :texto="'Capta&ccedil;&atilde;o'"></CharsetEncode>
                        </b>
                    </td>
                    <td class="centro">
                        <b>
                            <CharsetEncode :texto="'Movimenta&ccedil;&atilde;o'"></CharsetEncode>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <SalicTextoSimples :texto="dadosProjeto.AgenciaBancaria"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="dadosProjeto.ContaCaptacao"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="dadosProjeto.ContaMovimentacao"/>
                    </td>
                    <td align="center" class="destacar">
                        <SalicTextoSimples :texto="dadosProjeto.ContaBancariaLiberada"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="dadosProjeto.DtLiberacaoDaConta"/>
                    </td>
                </tr>
            </table>

            <table class="tabela">
                <tr class="destacar">
                    <td class="centro">
                        <b>
                            <CharsetEncode :texto="'S&iacute;ntese do projeto'"></CharsetEncode>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <SalicTextoSimples :texto="dadosProjeto.ResumoProjeto"/>
                    </td>
                </tr>
            </table>

            <div v-if="dadosProjeto.EmAnaliseNaCNIC" class="row">
                <div style="background-color: #EF5350" class="darken-2 padding10 white-text">
                    A T E N &Ccedil; &Atilde; O: Projeto em an&aacute;lise pela Comiss&atilde;o Nacional
                    de Incentivo &agrave; Cultura-CNIC. Aguardar resultado da avalia&ccedil;&atilde;o.
                </div>
            </div>
            <table v-else class="tabela">
                <tr class="destacar">
                    <td align="center" colspan="4">
                        <b>
                            <CharsetEncode :texto="'Situa&ccedil;&atilde;o do projeto'"></CharsetEncode>
                        </b>
                    </td>
                </tr>
                <tr class="destacar">
                    <td align="center">
                        <b>
                            <CharsetEncode :texto="'Dt.Situa&ccedil;&atilde;o'"></CharsetEncode>
                        </b>
                    </td>
                    <td class="left-align">
                        <b>
                            <CharsetEncode :texto="'Situa&ccedil;&atilde;o'"></CharsetEncode>
                        </b>
                    </td>
                    <td class="left-align">
                        <b>
                            <CharsetEncode :texto="'Provid&ecirc;ncia Tomada'"></CharsetEncode>
                        </b>
                    </td>
                    <td align="center">
                        <b>
                            <CharsetEncode :texto="'Localiza&ccedil;&atilde;o atual'"></CharsetEncode>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td align="center">{{ dadosProjeto.DtSituacao | formatarData }}</td>
                    <td class="left-align destacar">
                        <SalicTextoSimples :texto="dadosProjeto.Situacao"/>
                    </td>
                    <td class="left-align">
                        <SalicTextoSimples :texto="dadosProjeto.ProvidenciaTomada"/>
                    </td>
                    <td align="center" class="bold">{{ dadosProjeto.LocalizacaoAtual }}</td>
                </tr>
            </table>

            <table class="tabela">
                <tr class="destacar">
                    <td align="center" colspan="2"><b>Fase do projeto</b></td>
                </tr>
                <tr class="destacar">
                    <td class="left-align"><b>Fase</b></td>
                    <td align="center">
                        <b>
                            <CharsetEncode :texto="'Dt. in&iacute;cio'"></CharsetEncode>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td class="left-align">{{ dadosProjeto.FaseProjeto }}</td>
                    <td align="center">{{ dadosProjeto.dtInicioFase | formatarData }}</td>
                </tr>
            </table>

            <table class="tabela">
                <tr class="destacar">
                    <td align="center" colspan="3">
                        <b>
                            <CharsetEncode
                                :texto="'Normativo vigente na apresenta&ccedil;&atilde;o do projeto'"
                            >
                            </CharsetEncode>
                        </b>
                    </td>
                </tr>
                <tr class="destacar">
                    <td class="left-align"><b>Normativo</b></td>
                    <td align="center">
                        <b>
                            <CharsetEncode :texto="'Dt. Publica&ccedil;&atilde;o'"></CharsetEncode>
                        </b>
                    </td>
                    <td align="center">
                        <b>
                            <CharsetEncode :texto="'Dt. Revoga&ccedil;&atilde;o'"></CharsetEncode>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td class="left-align destacar">{{ dadosProjeto.Normativo }}</td>
                    <td align="center">{{ dadosProjeto.dtPublicacaoNormativo | formatarData }}</td>
                    <td align="center">{{ dadosProjeto.dtRevogacaoNormativo | formatarData }}</td>
                </tr>
            </table>

            <table class="tabela" v-if="dadosProjeto.DtArquivamento">
                <caption style="color: red !important;">Arquivado Definitivamente</caption>
                <tr class="destacar">
                    <td align="center"><b>Dt.Arquivamento</b></td>
                    <td align="center"><b>Cx.Inicial</b></td>
                    <td align="center"><b>Cx.Final</b></td>
                </tr>
                <tr>
                    <td align="center">{{ dadosProjeto.DtArquivamento | formatarData }}</td>
                    <td align="center">{{ dadosProjeto.CaixaInicio }}</td>
                    <td align="center">{{ dadosProjeto.CaixaFinal }}</td>
                </tr>
            </table>

            <fieldset>
                <legend>Valores em R$</legend>
                <table class="tabela">
                    <tr class="destacar">
                        <td align="center" colspan="5">
                            <b>
                                <CharsetEncode
                                    :texto="'Solicita&ccedil;&atilde;o da proposta original'"
                                >
                                </CharsetEncode>
                            </b>
                        </td>
                    </tr>
                    <tr class="destacar">
                        <td class="right-align"><b>Solicitado (A)</b></td>
                        <td class="right-align"><b>Outras Fontes (B)</b></td>
                        <td class="right-align"><b>Total Proposta (C=A+B)</b></td>
                    </tr>
                    <tr>
                        <td class="right-align destaque-texto"><b>
                            <SalicFormatarValor :valor="dadosProjeto.vlSolicitadoOriginal"/>
                        </b></td>
                        <td class="right-align destaque-texto-secondary"><b>
                            <SalicFormatarValor :valor="dadosProjeto.vlOutrasFontesPropostaOriginal"/>
                        </b>
                        </td>
                        <td class="right-align destaque-texto-primary">
                            <b>
                                <router-link v-if="dadosProjeto.vlTotalPropostaOriginal > 0"
                                             :to="{ name: 'planilhaproposta', params: { idPronac: idPronac }}">
                                    <SalicFormatarValor :valor="dadosProjeto.vlTotalPropostaOriginal"/>
                                </router-link>
                                <SalicFormatarValor v-else :valor="dadosProjeto.vlTotalPropostaOriginal"/>
                            </b>
                        </td>
                    </tr>
                </table>

                <table class="tabela">
                    <tr class="destacar">
                        <td align="center" colspan="3"><b>Autorizado p/ Captar</b></td>
                    </tr>
                    <tr class="destacar">
                        <td class="right-align"><b>Autorizado (D)</b></td>
                        <td class="right-align"><b>Outras fontes (E)</b></td>
                        <td class="right-align"><b>Total Autorizado (F=D+E)</b></td>
                    </tr>
                    <tr v-if="parseInt(dadosProjeto.idNormativo) > 6">
                        <td class="right-align destaque-texto"><b>
                            <SalicFormatarValor :valor="dadosProjeto.vlAutorizado"/>
                        </b></td>
                        <td class="right-align destaque-texto-secondary"><b>
                            <SalicFormatarValor :valor="dadosProjeto.vlAutorizadoOutrasFontes"/>
                        </b></td>
                        <td class="right-align destaque-texto-primary">
                            <b>
                                <router-link v-if="dadosProjeto.vlTotalAutorizado > 0"
                                             :to="{ name: 'planilhaautorizada', params: { idPronac: idPronac }}">
                                    <SalicFormatarValor :valor="dadosProjeto.vlTotalAutorizado"/>
                                </router-link>
                                <SalicFormatarValor v-else :valor="dadosProjeto.vlTotalAutorizado"/>
                            </b>
                        </td>
                    </tr>
                    <tr v-else> <!--@todo pensar melhor essa parte para não duplicar o código -->
                        <td class="right-align destaque-texto"><b>
                            <SalicFormatarValor :valor="dadosProjeto.vlHomologadoIncentivo"/>
                        </b></td>
                        <td class="right-align destaque-texto-secondary"><b>
                            <SalicFormatarValor :valor="dadosProjeto.vlHomologadoOutrasFontes"/>
                        </b></td>
                        <td class="right-align destaque-texto-primary">
                            <b>
                                <router-link v-if="dadosProjeto.vlTotalHomologado > 0"
                                             :to="{ name: 'planilhahomologada', params: { idPronac: idPronac }}">
                                    <SalicFormatarValor :valor="dadosProjeto.vlTotalHomologado"/>
                                </router-link>
                                <SalicFormatarValor v-else :valor="dadosProjeto.vlTotalHomologado"/>
                            </b>
                        </td>
                    </tr>
                </table>

                <table class="tabela" v-if="parseInt(dadosProjeto.idNormativo) > 6">
                    <tr class="destacar">
                        <td align="center" colspan="3">
                            <b>
                                <CharsetEncode
                                    :texto="'Adequado &agrave; realidade de execu&ccedil;&atilde;o pelo proponente'"
                                >
                                </CharsetEncode>
                            </b>
                        </td>
                    </tr>
                    <tr class="destacar">
                        <td class="right-align"><b>Adequado (G)</b></td>
                        <td class="right-align"><b>Outras fontes (H)</b></td>
                        <td class="right-align"><b>Total Adequado (I=G+H)</b></td>
                    </tr>
                    <tr>
                        <td class="right-align destaque-texto"><b>
                            <SalicFormatarValor :valor="dadosProjeto.vlAdequadoIncentivo"/>
                        </b></td>
                        <td class="right-align destaque-texto-secondary"><b>
                            <SalicFormatarValor :valor="dadosProjeto.vlAdequadoOutrasFontes"/>
                        </b></td>
                        <td class="right-align destaque-texto-primary">
                            <b>
                                <router-link v-if="dadosProjeto.vlTotalAdequado > 0"
                                             :to="{ name: 'planilhaadequada', params: { idPronac: idPronac }}">
                                    <SalicFormatarValor :valor="dadosProjeto.vlTotalAdequado"/>
                                </router-link>
                                <SalicFormatarValor v-else :valor="dadosProjeto.vlTotalAdequado"/>
                            </b>
                        </td>
                    </tr>
                </table>

                <table class="tabela" v-if="parseInt(dadosProjeto.idNormativo) > 6">
                    <tr class="destacar">
                        <td align="center" colspan="3">
                            <b>
                                <CharsetEncode :texto="'Homologado para execu&ccedil;&atilde;o'"></CharsetEncode>
                            </b>
                        </td>
                    </tr>
                    <tr class="destacar">
                        <td class="right-align"><b>Homologado (J)</b></td>
                        <td class="right-align"><b>Outras fontes (K)</b></td>
                        <td class="right-align"><b>Total Homologado (L=J+K)</b></td>
                    </tr>
                    <tr>
                        <td class="right-align destaque-texto"><b>
                            <SalicFormatarValor :valor="dadosProjeto.vlHomologadoIncentivo"/>
                        </b></td>
                        <td class="right-align destaque-texto-secondary"><b>
                            <SalicFormatarValor :valor="dadosProjeto.vlHomologadoOutrasFontes"/>
                        </b></td>
                        <td class="right-align destaque-texto-primary">
                            <b>
                                <router-link v-if="dadosProjeto.vlTotalHomologado > 0"
                                             :to="{ name: 'planilhahomologada', params: { idPronac: idPronac }}">
                                    <SalicFormatarValor :valor="dadosProjeto.vlTotalHomologado"/>
                                </router-link>
                                <SalicFormatarValor v-else :valor="dadosProjeto.vlTotalHomologado"/>
                            </b>
                        </td>
                    </tr>
                </table>

                <table class="tabela">
                    <tr class="destacar">
                        <td align="center" colspan="3">
                            <b>
                                <CharsetEncode :texto="'Readequa&ccedil;&atilde;o na execu&ccedil;&atilde;o'"></CharsetEncode>
                            </b>
                        </td>
                    </tr>
                    <tr class="destacar">
                        <td class="right-align"><b>Readequado (M)</b></td>
                        <td class="right-align"><b>Outras fontes (N)</b></td>
                        <td class="right-align"><b>Total Readequado (O=M+N)</b></td>
                    </tr>
                    <tr>
                        <td class="right-align destaque-texto">
                            <b>
                                <router-link v-if="dadosProjeto.vlReadequadoIncentivo > 0"
                                             :to="{ name: 'planilhareadequada', params: { idPronac: idPronac }}">
                                    <SalicFormatarValor :valor="dadosProjeto.vlReadequadoIncentivo"/>
                                </router-link>
                                <SalicFormatarValor v-else :valor="dadosProjeto.vlReadequadoIncentivo"/>
                            </b>
                        </td>
                        <td class="right-align destaque-texto-secondary"><b>
                            <SalicFormatarValor :valor="dadosProjeto.vlReadequadoOutrasFontes"/>
                        </b></td>
                        <td class="right-align destaque-texto-primary">
                            <b>
                                <router-link v-if="dadosProjeto.vlTotalReadequado > 0"
                                             :to="{ name: 'planilhareadequada', params: { idPronac: idPronac }}">
                                    <SalicFormatarValor :valor="dadosProjeto.vlTotalReadequado"/>
                                </router-link>
                                <SalicFormatarValor v-else :valor="dadosProjeto.vlTotalReadequado"/>
                            </b>
                        </td>
                    </tr>
                </table>

                <table class="tabela">
                    <tr class="destacar">
                        <td align="center" colspan="5">
                            <b>
                                <CharsetEncode :texto="'Capta&ccedil;&atilde;o de recursos'"></CharsetEncode>
                            </b>
                        </td>
                    </tr>
                    <tr class="destacar">
                        <td class="right-align"><b>Captado(P)</b></td>
                        <td class="right-align"><b>Transferido(Q)</b></td>
                        <td class="right-align"><b>Recebido(R)</b></td>
                        <td class="right-align"><b>Saldo a captar(S)</b></td>
                        <td class="right-align"><b>% Captado(T)</b></td>
                    </tr>
                    <tr>
                        <td class="right-align destaque-texto-primary destacar">
                            <b>
                                <a v-if="dadosProjeto.vlCaptado > 0"
                                   :href="'/default/consultardadosprojeto/dados-bancarios-captacao?idPronac=' + idPronac">
                                    <SalicFormatarValor :valor="dadosProjeto.vlCaptado"/>
                                </a>
                                <SalicFormatarValor v-else :valor="dadosProjeto.vlCaptado"/>
                            </b>
                        </td>
                        <td class="right-align"><b>
                            <SalicFormatarValor :valor="dadosProjeto.vlTransferido"/>
                        </b></td>
                        <td class="right-align"><b>
                            <SalicFormatarValor :valor="dadosProjeto.vlRecebido"/>
                        </b></td>
                        <td class="right-align destacar"><b>
                            <SalicFormatarValor :valor="dadosProjeto.vlSaldoACaptar"/>
                        </b></td>
                        <td class="right-align destaque-texto-primary">
                            <b>
                                <a v-if="dadosProjeto.PercentualCaptado > 0"
                                   :href="'/default/consultardadosprojeto/dados-bancarios-captacao?idPronac=' + idPronac">
                                    <SalicFormatarValor :valor="dadosProjeto.PercentualCaptado"/>
                                </a>
                                <SalicFormatarValor v-else :valor="dadosProjeto.PercentualCaptado"/>
                            </b>
                        </td>
                    </tr>
                </table>
                <table class="tabela">
                    <tr class="destacar">
                        <td align="center" colspan="3">
                            <b>
                                <CharsetEncode :texto="'Comprova&ccedil;&atilde;o'"></CharsetEncode>
                            </b>
                        </td>
                    </tr>
                    <tr class="destacar">
                        <td class="right-align"><b>Comprovado(U)</b></td>
                        <td class="right-align"><b>A Comprovar(V=S-U)</b></td>
                        <td class="right-align"><b>% Comprovado(X)</b></td>
                    </tr>
                    <tr>
                        <td class="right-align destaque-texto-primary destacar">
                            <b>
                                <router-link v-if="dadosProjeto.vlComprovado > 0"
                                             :to="{ name: 'relacaodepagamentos', params: { idPronac: idPronac }}">
                                    <SalicFormatarValor :valor="dadosProjeto.vlComprovado"/>
                                </router-link>
                                <SalicFormatarValor v-else :valor="dadosProjeto.vlComprovado"/>
                            </b>
                        </td>
                        <td class="right-align destacar">
                            <b>
                                <SalicFormatarValor :valor="dadosProjeto.vlAComprovar"/>
                            </b>
                        </td>
                        <td class="right-align destaque-texto-primary">
                            <b>
                                <router-link v-if="dadosProjeto.PercentualComprovado > 0"
                                             :to="{ name: 'relacaodepagamentos', params: { idPronac: idPronac }}">
                                    <SalicFormatarValor :valor="dadosProjeto.PercentualComprovado"/>
                                </router-link>
                                <SalicFormatarValor v-else :valor="dadosProjeto.PercentualComprovado"/>
                            </b>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import Carregando from '@/components/Carregando';
    import SalicTextoSimples from '@/components/SalicTextoSimples';
    import CharsetEncode from '@/components/CharsetEncode';
    import SalicFormatarValor from '@/components/SalicFormatarValor';
    import SalicFormatarCpfCnpj from '@/components/SalicFormatarCpfCnpj';
    import {utils} from '@/mixins/utils';
    import moment from 'moment';

    export default {
        data: function () {
            return {
                loading: true,
                idPronac: this.$route.params.idPronac,
                ProponenteInabilitado: false,
                emAnaliseNaCNIC: false
            }
        },
        mixins: [utils],
        components: {
            Carregando,
            SalicTextoSimples,
            CharsetEncode,
            SalicFormatarValor,
            SalicFormatarCpfCnpj
        },
        created() {
            if (Object.keys(this.dadosProjeto).length > 0) {
                this.loading = false;
            }
        },
        watch: {
            dadosProjeto: function (value) {
                if (Object.keys(value).length > 0) {
                    this.loading = false;
                    this.idPronac = this.dadosProjeto.idPronac
                }
            }
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
            }),
        },
        methods: {
            isDataExpirada: function (date) {
                return moment().diff(date, 'days') > 0;
            }
        },
        filters: {
            formatarData: function (date) {

                if(date.length == 0) {
                    return '-';
                }

                return moment(date).format('DD/MM/YYYY');
            }
        }
    };
</script>
