<template>
    <div id="conteudo">
        <div v-if="loading" class="row">
            <Carregando :text="'Carregando o projeto'"></Carregando>
        </div>
        <div v-show="Object.keys(projeto).length > 0">
            <table class="tabela">
                <tr class="destacar">
                    <td><b>PRONAC</b></td>
                    <td><b>Nome do Projeto</b></td>
                </tr>
                <tr>
                    <td>{{ projeto.Pronac }}</td>
                    <td>{{ projeto.NomeProjeto }}</td>
                </tr>
                <tr class="destacar">
                    <td><b>CNPJ/CPF</b></td>
                    <td><b>Proponente</b></td>
                </tr>
                <tr>
                    <td>
                        <router-link :to="{ name: 'proponente', params: { idPronac: idPronac }}">
                            <SalicFormatarCpfCnpj :cpf="projeto.CgcCPf"/>
                        </router-link>
                    </td>
                    <td>{{ projeto.Proponente }}</td>
                </tr>
            </table>
            <div class="row" v-if="ProponenteInabilitado">
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
                        <SalicTextoSimples :texto="projeto.UfProjeto"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="projeto.Mecanismo"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="projeto.Area"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="projeto.Segmento"/>
                    </td>
                    <td align="center" class="bold">
                        <SalicTextoSimples :texto="projeto.Enquadramento"/>
                    </td>
                </tr>
            </table>

            <table class="tabela">
                <tr class="destacar">
                    <td class="centro"><b>N&ordm; Proposta</b></td>
                    <td class="centro"><b>Data Fixa</b></td>
                    <td class="centro"><b>Processo</b></td>
                    <td class="centro"><b>Prorroga&ccedil;&atilde;o autom&aacute;tica</b></td>
                    <td class="centro"><b>Plano de Execu&ccedil;&atilde;o Imediata</b></td>
                </tr>
                <tr>
                    <td align="center">
                        <SalicTextoSimples :texto="projeto.idPreProjeto"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="projeto.DataFixa"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="projeto.Processo"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="projeto.ProrrogacaoAutomatica"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="projeto.PlanoExecucaoImediata"/>
                    </td>
                </tr>
            </table>

            <table class="tabela">
                <tr class="destacar">
                    <td colspan="2" class="centro bold">Per&iacute;odo de capta&ccedil;&atilde;o</td>
                    <td colspan="2" class="centro bold">Per&iacute;odo de execu&ccedil;&atilde;o</td>
                    <td colspan="3" class="centro bold">Per&iacute;odo Vigente</td>
                </tr>
                <tr class="destacar">
                    <td class="centro"><b>Dt. In&iacute;cio</b></td>
                    <td class="centro"><b>Dt. Final</b></td>
                    <td class="centro"><b>Dt. In&iacute;cio</b></td>
                    <td class="centro"><b>Dt. Final</b></td>
                    <td class="centro"><b>Tipo de portaria</b></td>
                    <td class="centro"><b>N&ordm; Portaria</b></td>
                    <td class="centro"><b>Dt. Publica&ccedil;&atilde;o</b></td>
                </tr>
                <tr>
                    <td align="center" class="bold">{{ projeto.DtInicioCaptacao | moment }}</td>
                    <td align="center" class="bold">{{ projeto.DtFimCaptacao | moment }}</td>
                    <td align="center" class="bold">{{ projeto.DtInicioExecucao | moment }}</td>
                    <td align="center" class="bold">{{ projeto.DtFimExecucao | moment }}</td>
                    <td align="center">
                        <SalicTextoSimples :texto="projeto.NrPortariaVigente"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="projeto.TipoPortariaVigente"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="projeto.DtPublicacaoPortariaVigente"/>
                    </td>
                </tr>
            </table>

            <table class="tabela">
                <tr class="destacar">
                    <td align="center" colspan="5"><b>Informa&ccedil;&otilde;es banc&aacute;rias</b></td>
                </tr>
                <tr class="destacar">
                    <td class="centro" rowspan="2"><b>Ag&ecirc;ncia</b></td>
                    <td class="centro" colspan="2"><b>N&uacute;meros das Contas</b></td>
                    <td class="centro" rowspan="2"><b>Conta Liberada</b></td>
                    <td class="centro" rowspan="2"><b>Dt. Libera&ccedil;&atilde;o</b></td>
                </tr>
                <tr class="destacar">
                    <td class="centro"><b>Capta&ccedil;&atilde;o</b></td>
                    <td class="centro"><b>Movimenta&ccedil;&atilde;o</b></td>
                </tr>
                <tr>
                    <td align="center">
                        <SalicTextoSimples :texto="projeto.AgenciaBancaria"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="projeto.ContaCaptacao"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="projeto.ContaMovimentacao"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="projeto.ContaBancariaLiberada"/>
                    </td>
                    <td align="center">
                        <SalicTextoSimples :texto="projeto.DtLiberacaoDaConta"/>
                    </td>
                </tr>
            </table>

            <table class="tabela">
                <tr class="destacar">
                    <td class="centro"><b>S&iacute;ntese do projeto</b></td>
                </tr>
                <tr>
                    <td>
                        <SalicTextoSimples :texto="projeto.ResumoProjeto"/>
                    </td>
                </tr>
            </table>

            <div v-if="emAnaliseNaCNIC" class="row">
                <div style="background-color: #EF5350" class="darken-2 padding10 white-text">
                    A T E N &Ccedil; &Atilde; O: Projeto em an&aacute;lise pela Comiss&atilde;o Nacional
                    de Incentivo &agrave; Cultura-CNIC. Aguardar resultado da avalia&ccedil;&atilde;o.
                </div>
            </div>
            <table v-else class="tabela">
                <tr class="destacar">
                    <td align="center" colspan="4"><b>Situa&ccedil;&atilde;o do projeto</b></td>
                </tr>
                <tr class="destacar">
                    <td align="center"><b>Dt.Situa&ccedil;&atilde;o</b></td>
                    <td class="left-align"><b>Situa&ccedil;&atilde;o</b></td>
                    <td class="left-align"><b>Provid&ecirc;ncia Tomada</b></td>
                    <td align="center"><b>Localiza&ccedil;&atilde;o atual</b></td>
                </tr>
                <tr>
                    <td align="center">{{ projeto.DtSituacao | moment}}</td>
                    <td class="left-align">{{ projeto.Situacao }}</td>
                    <td class="left-align">{{ projeto.ProvidenciaTomada }}</td>
                    <td align="center" class="bold">{{ projeto.LocalizacaoAtual }}</td>
                </tr>
            </table>

            <table class="tabela">
                <tr class="destacar">
                    <td align="center" colspan="2"><b>Fase do projeto</b></td>
                </tr>
                <tr class="destacar">
                    <td class="left-align"><b>Fase</b></td>
                    <td align="center"><b>Dt. in&iacute;cio</b></td>
                </tr>
                <tr>
                    <td class="left-align">{{ projeto.FaseProjeto }}</td>
                    <td align="center">{{ projeto.dtInicioFase | moment }}</td>
                </tr>
            </table>

            <table class="tabela" v-if="projeto.DtArquivamento">
                <caption style="color: red !important;">Arquivado Definitivamente</caption>
                <tr class="destacar">
                    <td align="center"><b>Dt.Arquivamento</b></td>
                    <td align="center"><b>Cx.Inicial</b></td>
                    <td align="center"><b>Cx.Final</b></td>
                </tr>
                <tr>
                    <td align="center">{{ projeto.DtArquivamento }}</td>
                    <td align="center">{{ projeto.CaixaInicio }}</td>
                    <td align="center">{{ projeto.CaixaFinal }}</td>
                </tr>
            </table>

            <fieldset>
                <legend>Valores em R$</legend>
                <table class="tabela">
                    <tr class="destacar">
                        <td align="center" colspan="5"><b>Solicita&ccedil;&atilde;o da proposta original</b></td>
                    </tr>
                    <tr class="destacar">
                        <td class="right-align"><b>Vl. Solicitado (A)</b></td>
                        <td class="right-align"><b>Vl. Outras Fontes (B)</b></td>
                        <td class="right-align"><b>Vl.Proposta (C = A + B)</b></td>
                    </tr>
                    <tr>
                        <td class="right-align"><b>
                            <SalicFormatarValor :valor="projeto.vlSolicitadoOriginal"/>
                        </b></td>
                        <td class="right-align"><b>
                            <SalicFormatarValor :valor="projeto.vlOutrasFontesPropostaOriginal"/>
                        </b>
                        </td>
                        <td class="right-align">
                            <b>
                                <router-link v-if="projeto.vlTotalPropostaOriginal > 0"
                                             :to="{ name: 'planilhaproposta', params: { idPronac: idPronac }}">
                                    <SalicFormatarValor :valor="projeto.vlTotalPropostaOriginal"/>
                                </router-link>
                                <SalicFormatarValor v-else :valor="projeto.vlTotalPropostaOriginal"/>
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
                    <tr>
                        <td class="right-align"><b>
                            <SalicFormatarValor :valor="projeto.vlAutorizado"/>
                        </b></td>
                        <td class="right-align"><b>
                            <SalicFormatarValor :valor="projeto.vlAutorizadoOutrasFontes"/>
                        </b></td>
                        <td class="right-align">
                            <b>
                                <router-link v-if="projeto.vlTotalAutorizado > 0"
                                             :to="{ name: 'planilhaaprovada', params: { idPronac: idPronac }}">
                                    <SalicFormatarValor :valor="projeto.vlTotalAutorizado"/>
                                </router-link>
                                <SalicFormatarValor v-else :valor="projeto.vlTotalAutorizado"/>
                            </b>
                        </td>
                    </tr>
                </table>

                <table class="tabela">
                    <tr class="destacar">
                        <td align="center" colspan="3"><b>Adequado &agrave; realidade de execu&ccedil;&atilde;o pelo
                            proponente</b></td>
                    </tr>
                    <tr class="destacar">
                        <td class="right-align"><b>Adequado (G)</b></td>
                        <td class="right-align"><b>Outras fontes (H)</b></td>
                        <td class="right-align"><b>Total Adequado (I=G+H)</b></td>
                    </tr>
                    <tr>
                        <td class="right-align"><b>
                            <SalicFormatarValor :valor="projeto.vlAdequadoIncentivo"/>
                        </b></td>
                        <td class="right-align"><b>
                            <SalicFormatarValor :valor="projeto.vlAdequadoOutrasFontes"/>
                        </b></td>
                        <td class="right-align">
                            <b>
                                <router-link v-if="projeto.vlTotalAdequado > 0"
                                             :to="{ name: 'planilhaaprovada', params: { idPronac: idPronac }}">
                                    <SalicFormatarValor :valor="projeto.vlTotalAdequado"/>
                                </router-link>
                                <SalicFormatarValor v-else :valor="projeto.vlTotalAdequado"/>
                            </b>
                        </td>
                    </tr>
                </table>

                <table class="tabela">
                    <tr class="destacar">
                        <td align="center" colspan="3"><b>Homologado para execu&ccedil;&atilde;o</b></td>
                    </tr>
                    <tr class="destacar">
                        <td class="right-align"><b>Homologado (J)</b></td>
                        <td class="right-align"><b>Outras fontes (K)</b></td>
                        <td class="right-align"><b>Total Homologado (L=J+K)</b></td>
                    </tr>
                    <tr>
                        <td class="right-align"><b>
                            <SalicFormatarValor :valor="projeto.vlHomologadoIncentivo"/>
                        </b></td>
                        <td class="right-align"><b>
                            <SalicFormatarValor :valor="projeto.vlHomologadoOutrasFontes"/>
                        </b></td>
                        <td class="right-align">
                            <b>
                                <router-link v-if="projeto.vlTotalHomologado > 0"
                                             :to="{ name: 'planilhaaprovada', params: { idPronac: idPronac }}">
                                    <SalicFormatarValor :valor="projeto.vlTotalHomologado"/>
                                </router-link>
                                <SalicFormatarValor v-else :valor="projeto.vlTotalHomologado"/>
                            </b>
                        </td>
                    </tr>
                </table>

                <table class="tabela">
                    <tr class="destacar">
                        <td align="center" colspan="3"><b>Readequa&ccedil;&atilde;o na execu&ccedil;&atilde;o</b></td>
                    </tr>
                    <tr class="destacar">
                        <td class="right-align"><b>Readequado (M)</b></td>
                        <td class="right-align"><b>Outras fontes (N)</b></td>
                        <td class="right-align"><b>Total Readequado (O=M+N)</b></td>
                    </tr>
                    <tr>
                        <td class="right-align">
                            <b>
                                <router-link v-if="projeto.vlReadequadoIncentivo > 0"
                                             :to="{ name: 'planilhaaprovada', params: { idPronac: idPronac }}">
                                    <SalicFormatarValor :valor="projeto.vlReadequadoIncentivo"/>
                                </router-link>
                                <SalicFormatarValor v-else :valor="projeto.vlReadequadoIncentivo"/>
                            </b>
                        </td>
                        <td class="right-align"><b>
                            <SalicFormatarValor :valor="projeto.vlReadequadoOutrasFontes"/>
                        </b></td>
                        <td class="right-align">
                            <b>
                                <router-link v-if="projeto.vlTotalReadequado > 0"
                                             :to="{ name: 'planilhaaprovada', params: { idPronac: idPronac }}">
                                    <SalicFormatarValor :valor="projeto.vlTotalReadequado"/>
                                </router-link>
                                <SalicFormatarValor v-else :valor="projeto.vlTotalReadequado"/>
                            </b>
                        </td>
                    </tr>
                </table>

                <table class="tabela">
                    <tr class="destacar">
                        <td align="center" colspan="5"><b>Capta&ccedil;&atilde;o de recursos</b></td>
                    </tr>
                    <tr class="destacar">
                        <td class="right-align"><b>Captado(P)</b></td>
                        <td class="right-align"><b>Transferido(Q)</b></td>
                        <td class="right-align"><b>Recebido(R)</b></td>
                        <td class="right-align"><b>Saldo a captar(S)</b></td>
                        <td class="right-align"><b>% Captado(T)</b></td>
                    </tr>
                    <tr>
                        <td class="right-align">
                            <b>
                                <a v-if="projeto.vlCaptado > 0"
                                   :href="'/default/consultardadosprojeto/dados-bancarios-captacao?idPronac=' + idPronac">
                                    <SalicFormatarValor :valor="projeto.vlCaptado"/>
                                </a>
                                <SalicFormatarValor v-else :valor="projeto.vlCaptado"/>
                            </b>
                        </td>
                        <td class="right-align"><b>
                            <SalicFormatarValor :valor="projeto.vlTransferido"/>
                        </b></td>
                        <td class="right-align"><b>
                            <SalicFormatarValor :valor="projeto.vlRecebido"/>
                        </b></td>
                        <td class="right-align"><b>
                            <SalicFormatarValor :valor="projeto.vlSaldoACaptar"/>
                        </b></td>
                        <td class="right-align">
                            <b>
                                <a v-if="projeto.PercentualCaptado > 0"
                                   :href="'/default/consultardadosprojeto/dados-bancarios-captacao?idPronac=' + idPronac">
                                    <SalicFormatarValor :valor="projeto.PercentualCaptado"/>
                                </a>
                                <SalicFormatarValor v-else :valor="projeto.PercentualCaptado"/>
                            </b>
                        </td>
                    </tr>
                </table>
                <table class="tabela">
                    <tr class="destacar">
                        <td align="center" colspan="3"><b>Comprova&ccedil;&atilde;o</b></td>
                    </tr>
                    <tr class="destacar">
                        <td class="right-align"><b>Comprovado(N)</b></td>
                        <td class="right-align"><b>A Comprovar(O=G-N)</b></td>
                        <td class="right-align"><b>% Comprovado(P)</b></td>
                    </tr>
                    <tr>
                        <td class="right-align">
                            <b>
                                <router-link v-if="projeto.vlComprovado > 0"
                                             :to="{ name: 'relacaodepagamentos', params: { idPronac: idPronac }}">
                                    <SalicFormatarValor :valor="projeto.vlComprovado"/>
                                </router-link>
                                <SalicFormatarValor v-else :valor="projeto.vlComprovado"/>
                            </b>
                        </td>
                        <td class="right-align"><b>{{ projeto.PercentualComprovado }}</b></td>
                        <td class="right-align">
                            <b>
                                <router-link v-if="projeto.PercentualComprovado > 0"
                                             :to="{ name: 'relacaodepagamentos', params: { idPronac: idPronac }}">
                                    <SalicFormatarValor :valor="projeto.PercentualComprovado"/>
                                </router-link>
                                <SalicFormatarValor v-else :valor="projeto.PercentualComprovado"/>
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
            SalicFormatarValor,
            SalicFormatarCpfCnpj
        },
        created() {
            if (Object.keys(this.projeto).length > 0) {
                this.loading = false;
            }
        },
        watch: {
            projeto: function (value) {

                if (Object.keys(value).length > 0) {
                    this.loading = false;
                }
            }
        },
        computed: {
            ...mapGetters({
                projeto: 'projeto/projeto',
            }),
        },
        filters: {
            moment: function (date) {
                return moment(date).format('DD/MM/YYYY');
            }
        }
    };
</script>