Vue.component('salic-proposta-planilha-orcamentaria', {
    template: `<div class="planilha-orcamentaria">
            <div class="card">
                <div class="card-content">
                    <h2>Planilha Or&ccedil;ament&aacute;ria</h2>
                    <div v-if="proposta">
                        <div tipo="fonte" v-for="(fontes, fonte) of planilhaCompleta" v-if="isObject(fontes)">
                            <h3 class="red-text">{{fonte}}</h3>
                            <div tipo="produto" v-for="(produtos, produto) of fontes" v-if="isObject(produtos)">
                                <h4 class="green-text" v-html="produto"></h4>
                                 <div tipo="etapa"  v-for="(etapas, etapa) of produtos" v-if="isObject(etapas)">
                                    <h5 class="orange-text" v-html="etapa"></h5>
                                     <div tipo="local" v-for="(locais, local) of etapas" v-if="isObject(locais)">
                                        <div class="title">
                                            <h6 class="blue-text" v-html="local"></h6>
                                            <span class="badge" data-badge-caption="custom caption">{{locais.total}}</span>
                                        </div>
                                         <table class="bordered">
                                            <tbody>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Item</th>
                                                    <th>Dias</th>
                                                    <th>Qtde</th>
                                                    <th>Ocor.</th>
                                                    <th>Vl. Unit&aacute;rio</th>
                                                    <th>Vl. Solicitado</th>
                                                </tr>
                                                <tr v-for="row of locais" :key="row.idPlanilhaProposta"  v-if="isObject(row)">
                                                    <td>{{row.Seq}}</td>
                                                    <td>{{row.Item}}</td>
                                                    <td>{{row.QtdeDias}}</td>
                                                    <td>{{row.Quantidade}}</td>
                                                    <td>{{row.Ocorrencia}}</td>
                                                    <td>{{row.vlUnitario}}</td>
                                                    <td>{{row.vlSolicitado}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="total blue-text">Total Local {{local}}: {{locais.total}}</div>
                                    </div> 
                                    <div class="total orange-text">Total Etapa{{etapa}}: {{etapas.total}}</div>
                                </div>
                                <div class="total green-text">Total Produto{{produto}}: {{produtos.total}}</div>
                            </div>
                             <div class="total red-text">Total Fonte:{{fonte}}: {{fontes.total}}</div>
                        </div>
                    </div>
                    <div v-else>Nenhuma planilha encontrada</div>
                </div>
            </div>
        </div>
    `,
    data: function () {
        return {
            proposta: [],
            totalFonte: 0,
            last: 0
        }

    },
    props: [
        'idpreprojeto',
        'planilha'
    ],
    mounted: function () {
        if (typeof this.idpreprojeto != 'undefined') {
            this.fetch(this.idpreprojeto);
        }
        // if (typeof this.planilha != 'undefined') {
        //     this.proposta = this.planilha;
        //     console.log(this.planilha);
        // }
    },
    computed: {
        planilhaCompleta: function() {

            if (!this.proposta) {
                return 0;
            }

            let planilha = {}, totalProjeto = 0, totalFonte = 0, totalProduto = 0, totalEtapa = 0, totalLocal = 0;

            planilha = this.proposta;
            //
            Object.entries(this.proposta).forEach(([fonte, produtos]) => {
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
                            this.$set(this.proposta[fonte][produto][etapa][local], 'total', totalLocal.toFixed(2));
                            totalEtapa += totalLocal;
                        });
                        this.$set(this.proposta[fonte][produto][etapa], 'total', totalEtapa.toFixed(2));
                        totalProduto += totalEtapa;
                    });
                    this.$set(this.proposta[fonte][produto], 'total', totalProduto.toFixed(2));
                    totalFonte += totalProduto;
                });
                this.$set(this.proposta[fonte], 'total', totalFonte.toFixed(2));
                totalProjeto += totalFonte;
            });
            // this.$set(planilha, 'total', totalProjeto.toFixed(2));

            return this.proposta;
        }
    },
    watch: {
        idpreprojeto: function (value) {
            this.fetch(value);
        },
        planilha: function (value) {
            this.proposta = value;
        }
    },
    methods: {
        fetch: function (id) {
            if (id) {
                let vue = this;
                $3.ajax({
                    url: '/proposta/visualizar/obter-planilha-orcamentaria-proposta/idPreProjeto/' + id
                }).done(function (response) {
                    vue.proposta = response.data;
                });
            }
        },
        formatar_data: function (date) {

            date = moment(date).format('DD/MM/YYYY');

            return date;
        },
        isObject: function(el) {

            if(typeof el !== "object") {
                return false;
            }

            return true;
        }

    },
    filters: {
        calcularFontes: function(list) {
                return '';
            // if(typeof list === "object") {
            //    return Object.keys(list).reduce(function (previous, key) {
            //        this.iterarFonte = previous + parseFloat(list[key].vlSolicitado);
            //         return previous + parseFloat(list[key].vlSolicitado);
            //    }, 0);
            // }
            //
            // return list.reduce(function(total, item) {
            //     this.iterarFonte = total + parseFloat(item.vlSolicitado);
            //     return previous + parseFloat(list[key].vlSolicitado);
            // }, 0)
        },
        calcularEtapa: function(list) {
            // return Object.keys(list).reduce(function (total, key) {
            //     // console.log(total + this.$options.filters.calcularFontes(list[key]));
            //     // return total + this.$options.filters.calcularFontes(list[key]);
            // }, 0);
        }
    }
});