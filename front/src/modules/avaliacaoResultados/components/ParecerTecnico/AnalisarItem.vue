<template>
    <v-layout row justify-center>
        <v-dialog
            v-model="dialog"
            scrollable
            fullscreen
            transition="dialog-bottom-transition"
            hide-overlay
        >
            <v-snackbar
                v-model="snackbarAlerta"
            >
                {{ snackbarTexto }}
                <v-btn
                    color="pink"
                    flat
                    @click="snackbarAlerta = false"
                >
                    Fechar
                </v-btn>
            </v-snackbar>

            <v-btn
                slot="activator"
                color="red"
                dark
                small
                title="Comprovar Item"
            >
                <v-icon>gavel</v-icon>
            </v-btn>
            <v-card>
                <v-toolbar dark color="green darken-3">
                    <v-btn icon dark @click.native="fecharModal">
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Avaliar itens</v-toolbar-title>
                </v-toolbar>

                <v-card-text v-if="dadosItemComprovacao.comprovantes && !comprovantesIsLoading">
                    <v-subheader>Dados da Comprovação</v-subheader>
                    <v-data-table
                        class="elevation-2"
                        hide-headers
                        :items="[]"
                        hide-actions
                    >
                        <template slot="no-data">
                            <tr>
                                <td left><b>Produto:</b></td>
                                <td>{{dadosItemComprovacao.dadosItem.Produto}}</td>
                                <td left><b>Etapa:</b></td>
                                <td>{{dadosItemComprovacao.dadosItem.Etapa}}</td>
                                <td left><b>Item de Custo:</b></td>
                                <td>{{dadosItemComprovacao.dadosItem.Item}}</td>
                            </tr>
                            <tr>
                                <td left><b>Valor Aprovado:</b></td>
                                <td>{{moeda(dadosItemComprovacao.dadosItem.vlAprovado)}}</td>
                                <td left><b>Valor Comprovado:</b></td>
                                <td>{{moeda(dadosItemComprovacao.dadosItem.vlComprovado)}}</td>
                                <td left><b>Comprovação Validada:</b></td>
                                <td>{{moeda(dadosItemComprovacao.dadosItem.ComprovacaoValidada)}}</td>
                            </tr>
                        </template>
                    </v-data-table>

                    <v-subheader>Comprovantes</v-subheader>
                    <v-data-table
                        :headers="comprovantesHeaders"
                        :items="dadosItemComprovacao.comprovantes"
                        class="elevation-1"
                        item-key="idComprovantePagamento"
                    >
                        <template slot="items" slot-scope="props">
                            <tr @click="props.expanded = !props.expanded">
                                <td>{{props.item.fornecedor.nome}}</td>
                                <td>{{ props.item.tpDocumento }}</td>
                                <td class="text-xs-right">{{ props.item.dtPagamento | formatarData }}</td>
                                <td class="text-xs-right">{{moeda(props.item.vlComprovacao)}}</td>
                                <td class="text-xs-right">
                                    <v-chip small
                                            :color="props.item.stItemAvaliado | filtrarCorSituacao" text-color="white">
                                        <v-avatar>
                                            <v-icon>{{ props.item.stItemAvaliado | filtrarIconeSituacao }}</v-icon>
                                        </v-avatar>
                                        {{ props.item.stItemAvaliado | filtrarLabelSituacao }}
                                    </v-chip>
                                </td>
                            </tr>
                        </template>
                        <template slot="expand" slot-scope="props">
                            <v-layout row justify-center class="blue-grey lighten-5 pa-2">
                                <v-card>
                                    <v-form
                                        v-model="form[props.item.idComprovantePagamento]"
                                        ref="form"
                                    >
                                        <v-card-title class="py-1">
                                            <h3>{{props.item.tpDocumento}} </h3>
                                            <v-btn
                                                round
                                                small
                                                :href="`/upload/abrir/id/${props.item.arquivo.id}`"
                                                target="_blank"
                                            >
                                                {{props.item.arquivo.nome}}
                                                <v-icon right>cloud_download</v-icon>
                                            </v-btn>
                                        </v-card-title>
                                        <v-divider></v-divider>
                                        <v-card-text>
                                            <v-container grid-list-md class="pa-0">
                                                <v-layout wrap>
                                                    <v-flex xs12 sm6 md4>
                                                        <b>CNPJ/CPF</b>
                                                        <div>{{ props.item.CNPJCPF | cnpjFilter }}</div>
                                                    </v-flex>
                                                    <v-flex xs12 sm6 md8>
                                                        <b>Fornecedor</b>
                                                        <div v-html="props.item.fornecedor.nome"></div>
                                                    </v-flex>
                                                    <v-flex xs12 sm6 md4>
                                                        <b>Comprovante</b>
                                                        <div>{{ props.item.tpDocumento }}</div>
                                                    </v-flex>
                                                    <v-flex xs12 sm6 md3>
                                                        <b>Número</b>
                                                        <div>{{ props.item.numero }}</div>
                                                    </v-flex>
                                                    <v-flex xs12 sm6 md4>
                                                        <b>Série</b>
                                                        <div>{{ props.item.serie }}</div>
                                                    </v-flex>
                                                    <v-flex xs12 sm6 md4>
                                                        <b>Dt. Emissão do comprovante de despesa</b>
                                                        <div>{{ props.item.dataEmissao | formatarData }}</div>
                                                    </v-flex>
                                                    <v-flex xs12 sm6 md3>
                                                        <b>Forma de Pagamento</b>
                                                        <div v-html="props.item.tpFormaDePagamento "></div>
                                                    </v-flex>
                                                    <v-flex xs12 sm6 md3>
                                                        <b>Dt. do Pagamento</b>
                                                        <div>{{ props.item.dtPagamento | formatarData }}</div>
                                                    </v-flex>
                                                    <v-flex xs12 sm6 md4>
                                                        <b>N&ordm; Documento Pagamento</b>
                                                        <div>{{ props.item.numeroDocumento }}</div>
                                                    </v-flex>
                                                    <v-flex xs12 sm6 md3>
                                                        <b>Valor</b>
                                                        <div>{{ moeda(props.item.valor) }}</div>
                                                    </v-flex>
                                                    <v-flex xs12 sm6 md9>
                                                        <b>Justificativa do Proponente</b>
                                                        <div v-html="props.item.justificativa"></div>
                                                    </v-flex>
                                                </v-layout>
                                                <v-divider class="my-3"></v-divider>
                                                <v-layout wrap>

                                                    <v-flex xs12>
                                                        <b>Avaliação</b>
                                                        <v-radio-group
                                                            v-model="stItemAvaliadoModel[props.item.idComprovantePagamento]"
                                                            :rules="[rules.required]"
                                                            row
                                                        >
                                                            <v-radio label="Aprovado" value="1"
                                                                     name="stItemAvaliadoModel" color="green"></v-radio>
                                                            <v-radio label="Reprovado" value="3"
                                                                     name="stItemAvaliadoModel" color="red"></v-radio>
                                                        </v-radio-group>
                                                    </v-flex>
                                                    <v-flex xs12>
                                                        <v-textarea
                                                            auto-grow
                                                            box
                                                            label="Parecer da avaliação"
                                                            height="180px"
                                                            v-model="dsJustificativa[props.item.idComprovantePagamento]"
                                                            autofocus
                                                            @input="justificativaInput(props.item.idComprovantePagamento, $event)"
                                                        ></v-textarea>
                                                    </v-flex>

                                                    <template
                                                        v-if="(stItemAvaliadoModel[props.item.idComprovantePagamento] === '3'
                                                            && dsJustificativa[props.item.idComprovantePagamento] == '')">
                                                        <p color="red--text">Por favor preencher o campo acima!</p>
                                                    </template>
                                                </v-layout>
                                            </v-container>
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-container grid-list-xs text-xs-center ma-0 pa-0>
                                                <v-btn
                                                    color="primary"
                                                    :disabled="!form[props.item.idComprovantePagamento] && !loading"
                                                    :loading="loading"
                                                    @click="salvarAvaliacao(props); loader = 'loading'"
                                                >
                                                    <v-icon left dark>save</v-icon>
                                                    Salvar
                                                </v-btn>
                                            </v-container>
                                        </v-card-actions>
                                    </v-form>
                                </v-card>
                            </v-layout>
                        </template>
                    </v-data-table>

                    <!--<v-card-->
                    <!--color="green lighten-4"-->
                    <!--flat-->
                    <!--tile-->
                    <!--&gt;-->
                    <!--<v-flex >-->

                    <!--<v-toolbar dense>-->
                    <!--<v-toolbar-title>Avaliar Comprovante - {{comprovante.arquivo.nome}}</v-toolbar-title>-->

                    <!--<v-btn-->
                    <!--icon-->
                    <!--:href="'/upload/abrir/id/'+ comprovante.arquivo.id"-->
                    <!--&gt;-->
                    <!--<v-icon>get_app</v-icon>-->
                    <!--</v-btn>-->
                    <!--</v-toolbar>-->

                    <!--<v-card-text>-->
                    <!--<v-card>-->
                    <!--<v-card-text class="elevation-2">-->
                    <!--<v-form-->
                    <!--v-if="renderDadosComprovante[i]"-->
                    <!--v-model="form[comprovante.idComprovantePagamento]"-->
                    <!--ref="form"-->
                    <!--&gt;-->
                    <!--<v-data-table-->
                    <!--class="elevation-2"-->
                    <!--hide-headers-->
                    <!--:items="[]"-->
                    <!--hide-actions-->
                    <!--&gt;-->
                    <!--<template slot="no-data">-->
                    <!--<tr>-->
                    <!--<td left><b>Fornecedor:</b></td>-->
                    <!--<td>{{comprovante.fornecedor.nome}}</td>-->
                    <!--<td left><b>CNPJ/CPF:</b></td>-->
                    <!--<td colspan="5">{{comprovante.CNPJCPF}}</td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                    <!--<td left><b>Comprovante:</b></td>-->
                    <!--<td >{{comprovante.tpDocumento}}</td>-->
                    <!--<td left><b>Número:</b></td>-->
                    <!--<td>{{comprovante.numero}}</td>-->
                    <!--<td left><b>S&eacute;rie:</b></td>-->
                    <!--<td colspan="3">{{comprovante.serie}}</td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                    <!--<td left><b>Dt. Emiss&atilde;o do comprovante de despesa:</b></td>-->
                    <!--<td>{{comprovante.dataEmissao | formatarData}}</td>-->
                    <!--<td left><b>Forma de Pagamento:</b></td>-->
                    <!--<td>{{comprovante.tpFormaDePagamento}}</td>-->
                    <!--<td left><b>Data do Pagamento:</b></td>-->
                    <!--<td>{{comprovante.dtPagamento | formatarData}}</td>-->
                    <!--<td left style="width: 155px;"><b>N&ordm; Documento Pagamento:</b></td>-->
                    <!--<td>{{comprovante.numeroDocumento}}</td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                    <!--<td left><b>Valor:</b></td>-->
                    <!--<td>{{moeda(comprovante.valor)}}</td>-->
                    <!--<td left><b>Justificativa do Proponente:</b></td>-->
                    <!--<td colspan="5">{{comprovante.justificativa}}</td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                    <!--<td left><b>Avaliação:</b></td>-->
                    <!--<td colspan="7">-->
                    <!--<v-radio-group-->
                    <!--v-model="stItemAvaliadoModel[comprovante.idComprovantePagamento]"-->
                    <!--:rules="[rules.required]"-->
                    <!--row-->
                    <!--&gt;-->
                    <!--<v-radio label="Aprovado" value="1" name="stItemAvaliadoModel" color="green"></v-radio>-->
                    <!--<v-radio label="Reprovado" value="3" name="stItemAvaliadoModel" color="red"></v-radio>-->
                    <!--</v-radio-group>-->
                    <!--</td>-->
                    <!--</tr>-->
                    <!--</template>-->
                    <!--</v-data-table>-->

                    <!--<v-textarea-->
                    <!--solo-->
                    <!--no-resize-->
                    <!--label="Parecer da avaliação"-->
                    <!--height="180px"-->
                    <!--v-model="dsJustificativa[comprovante.idComprovantePagamento]"-->
                    <!--autofocus-->
                    <!--@input="justificativaInput(comprovante.idComprovantePagamento, $event)"-->
                    <!--&gt;</v-textarea>-->
                    <!--<template-->
                    <!--v-if="(stItemAvaliadoModel[comprovante.idComprovantePagamento] === '3'-->
                    <!--&& dsJustificativa[comprovante.idComprovantePagamento] == '')">-->
                    <!--<p color="red&#45;&#45;text">Por favor preencher o campo acima!</p>-->
                    <!--</template>-->
                    <!--<div>-->
                    <!--<v-btn-->
                    <!--color="primary"-->
                    <!--flat-->
                    <!--:disabled="!form[comprovante.idComprovantePagamento] && !loading"-->
                    <!--:loading="loading"-->
                    <!--@click="salvarAvaliacao({-->
                    <!--// &lt;!&ndash;index: i,&ndash;&gt;-->
                    <!--// &lt;!&ndash;idComprovantePagamento: comprovante.idComprovantePagamento,&ndash;&gt;-->
                    <!--// &lt;!&ndash;stItemAvaliado: stItemAvaliadoModel[comprovante.idComprovantePagamento] || '',&ndash;&gt;-->
                    <!--// &lt;!&ndash;dsJustificativa: dsJustificativa[comprovante.idComprovantePagamento] || '',&ndash;&gt;-->
                    <!--}); loader = 'loading'"-->
                    <!--&gt;-->
                    <!--Salvar-->
                    <!--</v-btn>-->
                    <!--</div>-->
                    <!--</v-form>-->
                    <!--</v-card-text>-->
                    <!--</v-card>-->
                    <!--</v-card-text>-->
                    <!--</v-flex>-->
                    <!--</v-card>-->
                    <!--</v-expansion-panel-content>-->
                    <!--</v-expansion-panel>-->
                </v-card-text>
                <v-card-text v-else>
                    <carregando :text="'Carregando comprovantes...'"></carregando>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import moment from 'moment';
    import cnpjFilter from '@/filters/cnpj';
    import Carregando from '@/components/CarregandoVuetify';
    import Bar from '@/modules/foo/components/Bar';
    import EditorTexto from '../components/EditorTexto';

    export default {
        name: 'AnalisarItem',
        props: [
            'idPronac',
            'uf',
            'produto',
            'idmunicipio',
            'idPlanilhaItem',
            'etapa',
            'stItemAvaliado',
            'cdProduto',
            'cdUf',
        ],
        components: { Bar, Carregando, EditorTexto },
        data() {
            return {
                renderDadosComprovante: [],
                comprovantesIsLoading: null,
                painelComprovantes: [],
                dadosItemComprovacaoCopia: this.dadosItemComprovacao,
                loader: null,
                loading: false,
                form: {},
                snackbarAlerta: false,
                snackbarTexto: '',
                dsJustificativa: {},
                stItemAvaliadoModel: {},
                rules: {
                    required: v => !!v || 'É necessário preencher este campo',
                },
                emAvaliacao: {},
                comprovantesHeaders: [
                    {
                        text: 'Fornecedor',
                        align: 'left',
                        sortable: true,
                        value: 'fornecedor.nome',
                    },
                    {
                        text: 'Tipo',
                        value: 'tpDocumento',
                    },
                    {
                        text: 'Dt. Pagamento',
                        value: 'dataPagamento',
                        width: '10%',
                    },
                    {
                        text: 'Valor (R$)',
                        value: 'vlComprovacao',
                        width: '10%',
                    },
                    {
                        text: 'Situação',
                        value: 'stItemAvaliado',
                        width: '15%',
                    },
                ],
                // projetoHeaders: [
                //     {
                //         text: 'PRONAC',
                //         align: 'center',
                //         sortable: false,
                //         value: 'pronac',
                //     },
                //     {
                //         text: 'Nome do Projeto',
                //         align: 'center',
                //         sortable: false,
                //         value: 'nomeProjeto',
                //     },
                // ],
                // comprovacaoHeaders: [
                //     {
                //         text: 'Produto',
                //         align: 'center',
                //         sortable: false,
                //     },
                //     {
                //         text: 'Etapa',
                //         align: 'center',
                //         sortable: false,
                //     },
                //     {
                //         text: 'Item de Custo',
                //         align: 'center',
                //         sortable: false,
                //     },
                // ],
                // produtoHeaders: [
                //     {
                //         text: 'Valor Aprovado',
                //         align: 'center',
                //         sortable: false,
                //     },
                //     {
                //         text: 'Valor Comprovado',
                //         align: 'center',
                //         sortable: false,
                //     },
                //     {
                //         text: 'Comprovação Validada',
                //         align: 'center',
                //         sortable: false,
                //     },
                // ],
                // itemHeaders: [
                //     {
                //         text: 'Comprovante',
                //         align: 'center',
                //         sortable: false,
                //     },
                //     {
                //         text: 'Dt. Emissão do comprovante',
                //         align: 'center',
                //         sortable: false,
                //     },
                //     {
                //         text: 'c',
                //         align: 'center',
                //         sortable: false,
                //     },
                // ],
                dialog: false,
            };
        },
        computed: {
            ...mapGetters({
                dadosItemComprovacao: 'avaliacaoResultados/dadosItemComprovacao',
            }),
        },
        watch: {
            dialog(val) {
                if (val) this.atualizarComprovantes(true);
            },
            stItemAvaliadoModel: {
                handler(novoValor) {
                    this.stItemAvaliadoModel = novoValor;
                },
                deep: true,
            },
            dadosItemComprovacao() {
                this.dadosItemComprovacaoCopia = this.dadosItemComprovacao;
                this.dadosItemComprovacaoCopia.comprovantes.forEach((comp) => {
                    this.stItemAvaliadoModel[comp.idComprovantePagamento] = comp.stItemAvaliado;
                    this.dsJustificativa[comp.idComprovantePagamento] = comp.dsOcorrenciaDoTecnico;
                });
            },
        },
        methods: {
            ...mapActions({
                alterarAvaliacaoComprovante: 'avaliacaoResultados/alterarAvaliacaoComprovante',
                alterarPlanilha: 'avaliacaoResultados/alterarPlanilha',
                salvarAvaliacaoComprovante: 'avaliacaoResultados/salvarAvaliacaoComprovante',
                obterDadosItemComprovacao: 'avaliacaoResultados/obterDadosItemComprovacao',
            }),
            getUrlParamsToJson() {
                let urlParams = this.$route.params[0];
                urlParams = urlParams.split('/');

                const dados = {};

                urlParams.forEach((valor, index) => {
                    if ((index % 2) !== 0) {
                        dados[urlParams[index - 1]] = valor;
                    }
                });
                return dados;
            },
            getUrlParams() {
                return this.$route.params[0];
            },
            moeda: (moedaString) => {
                const moeda = Number(moedaString);
                return moeda.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });
            },
            salvarAvaliacao(params) {
                console.log('teste', params);
                return;
                if (
                    this.stItemAvaliadoModel[params.idComprovantePagamento] === '3'
                    && this.dsJustificativa[params.idComprovantePagamento] === ''
                ) {
                    return false;
                }

                if (
                    params.stItemAvaliado.length > 0
                /* && params.dsJustificativa.length > 0 */
                ) {
                    this.loading = true;
                    this.salvarAvaliacaoComprovante({
                        index: params.index,
                        idPronac: this.idPronac,
                        dsJustificativa: params.dsJustificativa,
                        stItemAvaliado: params.stItemAvaliado,
                        idComprovantePagamento: params.idComprovantePagamento,
                    }).then(() => {
                        this.snackbarTexto = 'Salvo com sucesso!';
                        this.snackbarAlerta = true;
                        this.alterarAvaliacaoComprovante(params);

                        this.alterarPlanilha({
                            idComprovantePagamento: params.idComprovantePagamento,
                            cdProduto: this.cdProduto,
                            etapa: this.etapa,
                            cdUf: this.cdUf,
                            idmunicipio: this.idmunicipio,
                            stItemAvaliado: this.stItemAvaliado,
                            idPlanilhaItem: this.idPlanilhaItem,
                            stItemAvaliadoAlterado:
                                this.stItemAvaliadoModel[params.idComprovantePagamento],
                        });
                    }).catch(() => {
                        this.snackbarTexto = 'Houve algum problema ao salvar!';
                        this.snackbarAlerta = true;
                    }).then(() => {
                        this.loading = false;
                    });
                }
                return true;
            },
            atualizarComprovantes(loading) {
                let params = '';
                if (typeof this.getUrlParams() !== 'undefined') {
                    params = this.getUrlParams();
                } else {
                    params = `idPronac/${this.idPronac}/uf/${this.uf}/produto/${this.produto}/idmunicipio/${this.idmunicipio}/idPlanilhaItem/${this.idPlanilhaItem}/etapa/${this.etapa}`;
                }

                if (loading) {
                    this.comprovantesIsLoading = true;
                    this.obterDadosItemComprovacao(params).catch().then(() => {
                        this.comprovantesIsLoading = false;
                    });
                }
                // this.comprovantesIsLoading = false;
                // this.obterDadosItemComprovacao(params);
            },
            fecharModal() {
                this.dialog = false;
                this.painelComprovantes = [];
            },
            carregarDadosComprovante(event, index) {
                this.renderDadosComprovante[index] = true;
            },
            justificativaInput(id, value) {
                const dados = {};
                dados[id] = value;

                this.dsJustificativa = Object.assign({}, this.dsJustificativa, dados);
            },
        },
        filters: {
            cnpjFilter,
            formatarData(date) {
                if (date.length === 0) {
                    return '---';
                }
                return moment(date).format('DD/MM/YYYY');
            },
            filtrarCorSituacao(situacao) {
                switch (situacao) {
                case '1':
                    return 'green';
                case '3':
                    return 'red';
                default:
                    return 'grey';
                }
            },
            filtrarIconeSituacao(situacao) {
                switch (situacao) {
                case '1':
                    return 'thumb_up';
                case '3':
                    return 'thumb_down';
                default:
                    return 'thumbs_up_down';
                }
            },
            filtrarLabelSituacao(situacao) {
                switch (situacao) {
                case '1':
                    return 'Aprovado';
                case '3':
                    return 'Reprovado';
                default:
                    return 'Não avaliado';
                }
            },
        },
    };
</script>
