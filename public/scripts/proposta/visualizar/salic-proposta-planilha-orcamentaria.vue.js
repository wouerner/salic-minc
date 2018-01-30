Vue.component('salic-proposta-planilha-orcamentaria', {
    template: `<div class="planilha-orcamentaria">
            <div class="card">
                <div class="card-content">
                    <h2>Planilha Or&ccedil;ament&aacute;ria</h2>
                        {{novaPlanilha}}
                    <div v-if="proposta">
                        <div v-for="(recursos, fonte) of proposta">
                            <div tipo="fonte">
                                <h3 class="red-text">{{fonte}}</h3>
                                <div v-for="(produtos, produto) of recursos">
                                    <div tipo="produto">
                                        <h4 class="orange-text" v-html="produto"></h4>
                                         <div v-for="(etapas, etapa) of produtos">
                                            <div tipo="etapa">
                                                <h5 class="green-text" v-html="etapa"></h5>
                                                 <div v-for="(locais, local) of etapas">
                                                    <div tipo="local">
                                                        <h6 class="blue-text" v-html="local"></h6>
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
                                                                <tr v-for="row of locais">
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
                                                    </div> 
                                                    <table>
                                                        <tr>
                                                            <td colspan="7">
                                                                    <div class="total">Total var </div>
                                                                  <div class="total">Total {{local}}: {{ locais | calcularFontes}}</div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div> 
                                            </div> 
                                             <table>
                                                <tr><td colspan="7">
                                                 <div class="total">Total {{produto}}: {{ produtos | calcularEtapa}}</div>
                                                </td></tr>
                                            </table>
                                        </div>
                                     </div> 
                                </div> 
                            </div>
                        </div>
                        <div>
                         Valor total do projeto: {{totalFonte}}
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
        novaPlanilha: function() {

            if (!this.proposta) {
                return 0;
            }
            // let titles = [];
            // for(var i = 0; i < this.items.length; i++){
            //     for(var k = 0; k < this.items[i].length; k++){
            //         titles.push(this.items[i][k].title);
            //     }
            // }
            let planilha = [], totalFonte = 0, totalProduto = 0, totalEtapa = 0, totalLocal = 0;

            // planilha = this.proposta;
            // if(this.proposta && this.proposta.length != 'undefined') {
            //
            //         console.log(this.proposta);
            //     for(let fonte = 0; fonte < this.proposta.length; fonte++){
            //         for(let produto = 0; produto < this.proposta[fonte].length; produto++){
            //             for(let etapa = 0; etapa < this.proposta[fonte][produto].length; etapa++){
            //                 for(let local = 0; local < this.proposta[fonte][produto][etapa].length; local++){
            //                     console.log(this.proposta[fonte][produto][etapa][local].vlUnitario);
            //                 }
            //             }
            //         }
            //     }
            // return planilha;
            // }
            // for(let fonte = 0; fonte < this.proposta.length; fonte++) {
            // }

            planilha = this.proposta;

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
                            totalEtapa += totalLocal;
                            console.log(local + ' local ' + totalLocal);
                        });
                        totalProduto += totalEtapa;
                        console.log('etapa' + '' +etapa + '' + totalEtapa);
                    });
                    totalFonte += totalProduto;
                    console.log('produto' + '' +produto+ ''+ totalProduto);
                });
                console.log(produtos);
                console.log('fonte' + '' +fonte+ ''+ totalFonte);
            });


            return planilha;
            //
            // this.proposta.forEach(function (recursos, key) {
            //      console.log(recursos);
            // });
            //

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