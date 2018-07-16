<template>
    <div v-if="planilha" class="planilha-orcamentaria card">
        <ul class="collapsible no-margin" data-collapsible="expandable">
            <li v-for="(fontes, fonte) of planilhaCompleta" v-if="isObject(fontes)">
                <div class="collapsible-header active red-text fonte" :class="converterStringParaClasseCss(fonte)">
                    <i class="material-icons">beenhere</i>{{fonte}}<span class="badge">R$ {{fontes.total}}</span>
                </div>
                <div class="collapsible-body no-padding">
                    <ul class="collapsible no-border no-margin" data-collapsible="expandable">
                        <li v-for="(produtos, produto) of fontes" v-if="isObject(produtos)">
                            <div class="collapsible-header active green-text" style="padding-left: 30px;"
                                 :class="converterStringParaClasseCss(produto)">
                                <i class="material-icons">perm_media</i>{{produto}}<span class="badge">R$ {{produtos.total}}</span>
                            </div>
                            <div class="collapsible-body no-padding no-border">
                                <ul class="collapsible no-border no-margin" data-collapsible="expandable">
                                    <li v-for="(etapas, etapa) of produtos" v-if="isObject(etapas)">
                                        <div class="collapsible-header active orange-text" style="padding-left: 50px;"
                                             :class="converterStringParaClasseCss(etapa)">
                                            <i class="material-icons">label</i>{{etapa}}<span class="badge">R$ {{etapas.total}}</span>
                                        </div>
                                        <div class="collapsible-body no-padding no-border">
                                            <ul class="collapsible no-border no-margin" data-collapsible="expandable">
                                                <li v-for="(locais, local) of etapas" v-if="isObject(locais)">
                                                    <div class="collapsible-header active blue-text"
                                                         style="padding-left: 70px;"
                                                         :class="converterStringParaClasseCss(local)">
                                                        <i class="material-icons">place</i>{{local}} <span
                                                            class="badge">R$ {{locais.total}}</span>
                                                    </div>
                                                    <div class="collapsible-body no-padding margin20 scroll-x">
                                                        <component :is="componenteTabelaItens" :table="locais"></component>
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
        <div class="card-action right-align">
            <span><b>Valor total do projeto:</b> R$ {{planilhaCompleta.total}}</span>
        </div>
    </div>
    <div v-else>Nenhuma planilha encontrada</div>
</template>

<script>
    import numeral from 'numeral'
    import 'numeral/locales';
    import moment from 'moment'
    import ListaDeItensPadrao from '@/components/planilha/ListaDeItensPadrao'
    import ListaDeItensCurtos from '@/components/planilha/ListaDeItensCurtos'
    import ListaDeItensAutorizados from '@/components/planilha/ListaDeItensAutorizados'
    import ListaDeItensAprovados from '@/components/planilha/ListaDeItensAprovados'
    import ListaDeItensHomologados from '@/components/planilha/ListaDeItensHomologados'
    import ListaDeItensReadequados from '@/components/planilha/ListaDeItensReadequados'

    export default {
        name: 'PlanilhaOrcamentaria',
        data: function () {
            return {
                planilha: []
            }
        },
        components: {
            ListaDeItensPadrao,
            ListaDeItensCurtos,
            ListaDeItensAprovados,
            ListaDeItensAutorizados,
            ListaDeItensHomologados,
            ListaDeItensReadequados
        },
        props: {
            'arrayPlanilha':  {},
            'componenteTabelaItens': {
                default: 'ListaDeItensPadrao',
                type: String
            },
        },
        mounted: function () {
            if (typeof this.arrayPlanilha !== 'undefined') {
                this.planilha = this.arrayPlanilha;
            }

            numeral.locale('pt-br');
            numeral.defaultFormat('0,0.00');
        },
        computed: {
            planilhaCompleta: function () {

                if (!this.planilha) {
                    return 0;
                }

                let novaPlanilha = {}, totalProjeto = 0, totalFonte = 0, totalProduto = 0, totalEtapa = 0,
                    totalLocal = 0;

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
                                    totalLocal += cell.vlSolicitado;
                                });
                                this.$set(this.planilha[fonte][produto][etapa][local], 'total', numeral(totalLocal).format('0,0.00'));
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
        watch: {
            arrayPlanilha: function (value) {
                this.planilha = value;
                this.iniciarCollapsible();
            }
        },
        methods: {
            formatar_data: function (date) {

                date = moment(date).format('DD/MM/YYYY');

                return date;
            },
            isObject: function (el) {

                return typeof el === "object";

            },
            iniciarCollapsible: function () {
                $3('.planilha-orcamentaria .collapsible').each(function () {
                    $3(this).collapsible();
                });
            },
            converterStringParaClasseCss: function (text) {
                return text.toString().toLowerCase().trim()
                    .replace(/&/g, '-and-')
                    .replace(/[\s\W-]+/g, '-');
            },
            ultrapassaValor: function (row) {
                return row.stCustoPraticado == true;

            },
            converterParaReal: function (value) {
                value = parseFloat(value);
                return numeral(value).format('0,0.00');
            }
        }
    };
</script>