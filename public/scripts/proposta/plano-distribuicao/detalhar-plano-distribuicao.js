(function (global, factory) {
    if (typeof define === 'function' && define.amd) {
        define(['../numeral'], factory);
    } else if (typeof module === 'object' && module.exports) {
        factory(require('../numeral'));
    } else {
        factory(global.numeral);
    }
}(this, function (numeral) {
    numeral.register('locale', 'pt-br', {
        delimiters: {
            thousands: '.',
            decimal: ','
        },
        abbreviations: {
            thousand: 'mil',
            million: 'milhões',
            billion: 'b',
            trillion: 't'
        },
        ordinal: function (number) {
            return 'º';
        },
        currency: {
            symbol: 'R$'
        }
    });
}));

// switch between locales
numeral.locale('pt-br');
numeral.defaultFormat('0,0.00');

// register
Vue.component('select-percent', {
    template: '<select style="width: 75px; display: inline-block; display: inline-block;" @change="valorSelecionado($event.target.value)" ref="combo" tabindex="-1" class="browser-default"><option v-for="item in items">{{ item }}%</option></select>',
    props: {
        disabled: {
            type: Boolean,
            default: false
        },
        maximoCombo: {}
    },
    data: function () {
        return {
            retorno: 1
        }
    },
    computed: {
        items: function () {
            var total = [];
            for (var i = this.maximoCombo; i >= 0; i--) {
                total.push(parseInt(i));
            }
            return total;
        }
    },
    watch: {
        disabled: function () {
            this.$refs.combo.disabled = this.disabled;
            if (this.disabled) {
                this.value = 0;
            }
        }
    },
    methods: {
        valorSelecionado: function (value) {
            this.retorno = value;
            this.$emit('evento', parseInt(this.retorno))
        }
    },
    mounted: function () {
        this.$refs.combo.disabled = this.disabled;
    }
});

// register
Vue.component('input-money', {
    template: '<div>\
                <input\
                    type="text"\
                    class="browser-default right-align"\
                    v-bind:disabled="false"\
                    v-bind:value="value"\
                    ref="input"\
                    v-on:input="updateMoney($event.target.value)"\
                    v-on:blur="formatValue">\
                </div>',
    props: {
        value: {
            default: 0
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    data: function () {
        return {
            val: 1
        }
    },
    mounted: function () {
        this.formatValue();
        this.$refs.input.disabled = this.disabled;
    },
    methods: {
        formatValue: function () {
            this.$refs.input.value = numeral(this.$refs.input.value).format();
        },
        updateMoney: function (value) {
            // console.log(value);
            this.val = value;
            this.$emit('ev', this.val)
        }
    },
    watch: {
        disabled: function () {
            this.$refs.input.disabled = this.disabled;
            if (this.disabled) {
                this.val = 0;
            }
        }
    }
});


Vue.component('proposta-plano-distribuicao-detalhamento-listagem', {
    template: `
        <table class="bordered">
            <thead v-if="produtos && produtos.length > 0">
            <tr>
                <th rowspan="2">Categoria</th>
                <th rowspan="2">Quantidade</th>
                <th class="proponente" colspan="3">
                    Proponente
                </th>
                <th class="popular" colspan="3">
                    Pre&ccedil;o Popular
                </th>
                <th class="gratuito" rowspan="2">
                    Distribui&ccedil;&atilde;o <br>Gratuita
                </th>
                <th rowspan="2" class="center-align">Receita <br> Prevista</th>
                <th rowspan="2" width="5%">A&ccedil;&otildees</th>
            </tr>
            <tr>
                <th class="proponente">Qtd. Inteira</th>
                <th class="proponente">Qtd. Meia</th>
                <th class="proponente">Pre&ccedil;o <br> Unitario</th>
                <th class="popular">Qtd. Inteira</th>
                <th class="popular">Qtd. Meia</th>
                <th class="popular">Pre&ccedil;o <br> Unitario</th>
            </tr>
            </thead>
            <tbody v-if="produtos && produtos.length > 0">
            <tr v-for="( produto, index ) in produtos">
                <td>{{ produto.dsProduto }}</td>
                <td class="center-align">{{ produto.qtExemplares }}</td>
                <!--Preço Proponente -->
                <td class="center-align">{{ produto.qtProponenteIntegral }}</td>
                <td class="center-align">{{ produto.qtProponenteParcial }}</td>
                <td class="right-align">{{ formatarValor(produto.vlUnitarioProponenteIntegral) }}</td>
                <!--Preço Popular -->
                <td class="center-align">{{ produto.qtPopularIntegral }}</td>
                <td class="center-align">{{ produto.qtPopularParcial }}</td>
                <td class="right-align">{{ formatarValor(produto.vlUnitarioPopularIntegral) }}</td>
                <!-- Distribuicao Gratuita-->
                <td class="center-align">{{ parseInt(produto.qtGratuitaDivulgacao) +
                    parseInt(produto.qtGratuitaPatrocinador) + parseInt(produto.qtGratuitaPopulacao) }}
                </td>
                <td class="right-align">{{ formatarValor(produto.vlReceitaPrevista) }}</td>
                <td>
                    <button class="btn red white-text small" v-bind:disabled="!disabled"
                            v-on:click="excluir(produto.idDetalhaPlanoDistribuicao)">
                        <i class="material-icons">delete</i>
                    </button>
                </td>
            </tr>
            </tbody>
            <tbody v-else>
            <tr>
                <td colspan="12" class="center-align">Nenhum detalhamento cadastrado</td>
            </tr>
            </tbody>
            <tfoot v-if="produtos && produtos.length > 0" style="opacity: 0.5">
            <tr>
                <td><b>Totais</b></td>
                <td class="center-align"><b>{{ qtExemplaresTotal }}</b></td>
                <!--Fim: Preço Popular -->
                <td class="center-align"><b>{{ qtProponenteIntegralTotal }}</b></td>
                <td class="center-align"><b>{{ qtProponenteParcialTotal }}</b></td>
                <td class="right-align"> -</td>
                <!--Preço Popular -->
                <td class="center-align"><b>{{ qtPopularIntegralTotal }}</b></td>
                <td class="center-align"><b>{{ qtPopularParcialTotal }}</b></td>
                <td class="right-align"> -</td>
                <td class="center-align"><b>{{ parseInt(qtGratuitaDivulgacaoTotal) +
                        parseInt(qtGratuitaPatrocinadorTotal) + parseInt(qtGratuitaPopulacaoTotal)}}</b>
                </td>
                <td class="right-align"><b>{{ receitaPrevistaTotal }}</b></td>
                <td></td>
            </tr>
            <tr>
                <th class=""><b>Valor m&eacute;dio </b></th>
                <td class="center-align red"
                    v-if="((valorMedioProponente.value() > 225) && (this.canalaberto == 0))">
                    {{valorMedioProponenteFormatado}}
                </td>
                <td class="center-align " v-else>{{valorMedioProponenteFormatado}}</td>
            </tr>
            </tfoot>
        </table>
    `,
    data: function () {
        return {
            produtos: [],
        }
    },
    props: [
        'idpreprojeto',
        'idplanodistribuicao',
        'idmunicipioibge',
        'iduf',
        'disabled',
        'canalaberto'
    ],
    computed: {
        // Total de exemplares
        qtExemplaresTotal: function () {
            total = 0;
            for (var i = 0; i < this.produtos.length; i++) {
                total += parseInt(this.produtos[i]['qtExemplares']);
            }
            return total;
        },
        // Total de divulgação gratuita.
        qtGratuitaDivulgacaoTotal: function () {
            total = 0;
            for (var i = 0; i < this.produtos.length; i++) {
                total += parseInt(this.produtos[i]['qtGratuitaDivulgacao']);
            }
            return total;
        },
        // Total de divulgação Patrocinador
        qtGratuitaPatrocinadorTotal: function () {
            total = 0;
            for (var i = 0; i < this.produtos.length; i++) {
                total += parseInt(this.produtos[i]['qtGratuitaPatrocinador']);
            }
            return total;
        },
        // Total de divulgação gratuita.
        qtGratuitaPopulacaoTotal: function () {
            total = 0;
            for (var i = 0; i < this.produtos.length; i++) {
                total += parseInt(this.produtos[i]['qtGratuitaPopulacao']);
            }
            return total;
        },
        //Preço Popular: Quantidade de Inteira
        qtPopularIntegralTotal: function () {
            total = 0;
            for (var i = 0; i < this.produtos.length; i++) {
                total += parseInt(this.produtos[i]['qtPopularIntegral']);
            }
            return total;
        },
        //Preço Popular: Quantidade de meia entrada
        qtPopularParcialTotal: function () {
            total = 0;
            for (var i = 0; i < this.produtos.length; i++) {
                total += parseInt(this.produtos[i]['qtPopularParcial']);
            }
            return total;
        },
        vlReceitaPopularIntegralTotal: function () {
            total = 0;
            for (var i = 0; i < this.produtos.length; i++) {
                var vl = (this.produtos[i]['vlReceitaPopularIntegral']);
                total += numeral(vl).value();
            }
            return numeral(total).format();
        },
        vlReceitaPopularParcialTotal: function () {
            total = 0;
            for (var i = 0; i < this.produtos.length; i++) {
                var vl = (this.produtos[i]['vlReceitaPopularParcial']);
                total += numeral(vl).value();
            }
            return numeral(total).format();
        },
        qtProponenteIntegralTotal: function () {
            total = 0;
            for (var i = 0; i < this.produtos.length; i++) {
                total += parseInt(this.produtos[i]['qtProponenteIntegral']);
            }
            return total;
        },
        qtProponenteParcialTotal: function () {
            total = 0;
            for (var i = 0; i < this.produtos.length; i++) {
                total += parseInt(this.produtos[i]['qtProponenteParcial']);
            }
            return total;
        },
        vlReceitaProponenteIntegralTotal: function () {
            total = 0;
            for (var i = 0; i < this.produtos.length; i++) {
                vl = (this.produtos[i]['vlReceitaProponenteIntegral']);
                total += this.converterParaMoedaAmericana(vl);
            }
            return numeral(total).format();
        },
        vlReceitaProponenteParcialTotal: function () {
            total = 0;
            for (var i = 0; i < this.produtos.length; i++) {
                var vl = (this.produtos[i]['vlReceitaProponenteParcial']);
                total += this.converterParaMoedaAmericana(vl);
            }
            return numeral(total).format();
        },
        receitaPrevistaTotal: function () {
            var total = numeral();

            for (var i = 0; i < this.produtos.length; i++) {
                var vl = this.produtos[i]['vlReceitaPrevista'];
                total.add(parseFloat(vl));
            }
            return total.format();
        },
        valorMedioProponente: function () {
            var vlReceitaProponenteIntegral = numeral();
            var vlReceitaProponenteParcial = numeral();
            var qtProponenteIntegral = numeral();
            var qtProponenteParcial = numeral();

            for (var i = 0; i < this.produtos.length; i++) {
                vlReceitaProponenteIntegral.add(this.produtos[i]['vlReceitaProponenteIntegral']);
                vlReceitaProponenteParcial.add(parseFloat(this.produtos[i]['vlReceitaProponenteParcial']));
                qtProponenteIntegral.add(parseFloat(this.produtos[i]['qtProponenteIntegral']));
                qtProponenteParcial.add(parseFloat(this.produtos[i]['qtProponenteParcial']));
            }

            var media = numeral(parseFloat(vlReceitaProponenteIntegral.value() + vlReceitaProponenteParcial.value()) / (qtProponenteIntegral.value() + qtProponenteParcial.value()));

            return media;
        },
        valorMedioProponenteFormatado: function () {
            return this.valorMedioProponente.format();
        }
    },
    watch: {},
    mounted: function () {
        this.t();
    },
    methods: {
        t: function () {
            var vue = this;

            // this.$data.produtos = [];
            url = "/proposta/plano-distribuicao/detalhar-mostrar/idPreProjeto/" + this.idpreprojeto + "?idPlanoDistribuicao=" + this.idplanodistribuicao + "&idMunicipio=" + this.idmunicipioibge + "&idUF=" + this.iduf
            $3.ajax({
                type: "GET",
                url: url
            }).done(function (data) {
                // if ((numeral(this.valorMedioProponente).value() > 225
                //     && (this.canalaberto == 0))) {
                //     this.mensagemAlerta("O valor medio:" + this.valorMedioProponenteFormatado + ", n\xE3o pode ultrapassar: 225,00");
                //     this.$data.produtos.splice(-1, 1)
                // }

                vue.$data.produtos = data.data;
            }).fail(function () {
                vue.mensagemErro('Erro ao buscar detalhamento');
            });
        },
        excluir: function (index) {

            var vue = this;
            $3.ajax({
                type: "POST",
                url: "/proposta/plano-distribuicao/detalhar-excluir/idPreProjeto/" + this.idpreprojeto,
                data: {
                    idDetalhaPlanoDistribuicao: index,
                    idPlanoDistribuicao: this.idplanodistribuicao
                },
            }).done(function () {
                vue.t();
                vue.mensagemSucesso("Excluido com sucesso");
            });
        },
        converterParaMoedaAmericana: function (valor) {
            if (!valor)
                valor = '0';

            valor = valor.replace(/\./g, '');
            valor = valor.replace(/\,/g, '.');
            valor = parseFloat(valor);
            valor = valor.toFixed(2);

            if (isNaN(valor))
                valor = 0;

            return valor;
        },
        mensagemSucesso: function (msg) {
            Materialize.toast(msg, 8000, 'green white-text');
        },
        mensagemErro: function (msg) {
            Materialize.toast(msg, 8000, 'red darken-1 white-text');
        },
        mensagemAlerta: function (msg) {
            Materialize.toast(msg, 8000, 'mensagem1 orange darken-3 white-text');
        },
        formatarValor: function (valor) {
            valor = parseFloat(valor);
            return numeral(valor).format();
        }
    }
});

const TIPO_EXEMPLAR = 'e';
const TIPO_INGRESSO = 'i';
const NAO = 'n';
const SIM = 's';
const TIPO_LOCAL_ABERTO = 'a';
const TIPO_LOCAL_FECHADO = 'f';
const TIPO_ESPACO_PUBLICO = 's';
const TIPO_ESPACO_PRIVADO = 'n';

const DISTRIBUICAO_GRATUITA_PERCENTUAL_PADRAO = 0.3;
const PRECO_POPULAR_PERCENTUAL_PADRAO = 0.2;
const PROPONENTE_PERCENTUAL_PADRAO = 0.5;

// register
Vue.component('proposta-plano-distribuicao-form-detalhamento', {
    template: `
        <div>
            <div class="row">
                <div class="center">
                    <proposta-plano-distribuicao-detalhamento-listagem
                        disabled="disabled"
                        idplanodistribuicao="idplanodistribuicao"
                        idpreprojeto="idpreprojeto"
                        iduf="iduf"
                        idmunicipioibge="idmunicipioibge"
                        canalaberto="canalaberto"
                    ></proposta-plano-distribuicao-detalhamento-listagem>
                </div>
            </div>
            <div class="row center-align">
                <br>
                <button class="btn waves-effect waves-light" ref="mostrarForm"
                        v-on:click.prevent="mostrarFormulario(_uid + '_form_detalhamento')">
                        Novo detalhamento
                    <i class="material-icons right">add</i>
                </button>
            </div>
            <div :id="_uid + '_form_detalhamento'" class="card">
                <form v-show="visualizarFormulario" class="card-content">
                    <span class="card-title">Cadastrar novo detalhamento</span>
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <span>
                                <b>Tipo de venda</b><br>
                                <input 
                                    name="tipoVenda" 
                                    type="radio" 
                                    :id="_uid + 'tipoVendaIngresso'" 
                                    value="i" 
                                    v-model="distribuicao.tpVenda"
                                />
                                <label :for=" _uid + 'tipoVendaIngresso'">Ingresso</label>
                                <input 
                                    name="tipoVenda" 
                                    type="radio" 
                                    :id="_uid + 'tipoVendaExemplar'" 
                                    value="e" 
                                    v-model="distribuicao.tpVenda"
                                />
                                <label :for=" _uid + 'tipoVendaExemplar'">Exemplar</label>
                            </span>
                        </div>
                        <div class="col s12 m6 l6">
                            <span>
                                <b>Distribui&ccedil;&atilde;o ser&aacute; totalmente gratuita?</b><br>
                                <input 
                                    name="group1" 
                                    type="radio" 
                                    :id="_uid + '1'" 
                                    value="s" 
                                    v-model="distribuicaoGratuita"
                                />
                                <label :for="_uid + '1'">Sim</label>
                                <input 
                                    name="group1" 
                                    type="radio" 
                                    :id="_uid + '2'" 
                                    value="n" 
                                    v-model="distribuicaoGratuita"
                                />
                                <label :for="_uid + '2'">N&atilde;o</label>
                            </span>
                        </div>
                    </div>

                    <div class="row" v-if="distribuicao.tpVenda == 'i'">
                        <div class="col col s12 m6 l6">
                            <span>
                                <b>Tipo do local de apresenta&ccedil;&atilde;o</b><br>
                                <input 
                                    name="tipoLocalRealizacao" 
                                    type="radio" 
                                    :id="_uid + 'tipoAberto'" 
                                    value="a" 
                                    v-model="distribuicao.tpLocal"
                                />
                                <label :for=" _uid + 'tipoAberto'">Aberto</label>
                                <input 
                                    name="tipoLocalRealizacao" 
                                    type="radio" :id=" _uid + 'tipoFechado'" 
                                    value="f" 
                                    v-model="distribuicao.tpLocal"
                                />
                                <label :for=" _uid + 'tipoFechado'">Fechado</label>
                            </span>
                        </div>
                        <div class="col col s12 m6 l6">
                            <span>
                                <b>Espa&ccedil;o p&uacute;blico</b><br>
                                <input 
                                    type="radio" 
                                    :id="_uid + 'espacoPublicoSim'" 
                                    value="s" 
                                    v-model="distribuicao.tpEspaco"
                                />
                                <label :for="_uid + 'espacoPublicoSim'">Sim</label>
                                <input 
                                    type="radio" 
                                    id="espacoPublicoNao" 
                                    :id=" _uid + 'espacoPublicoNao'" 
                                    value="n" 
                                    v-model="distribuicao.tpEspaco"/>
                                <label :for="_uid + 'espacoPublicoNao'">N&atilde;o</label>
                            </span>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="input-field col s12 m6 l6">
                            <input 
                                :id="_uid + 'dsProduto'" 
                                type="text" 
                                class="browser-default validate" 
                                ref="dsProduto"
                                placeholder="Ex: Arquibancada" 
                                v-model="distribuicao.dsProduto"
                            />
                            <label class="active" :for="_uid + 'dsProduto'">Categoria</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <input 
                                :id="_uid + 'qtExemplares'" 
                                type="number" 
                                class="validate browser-default"
                                ref="qtExemplares"
                                placeholder="0" 
                                v-model.number.lazy="distribuicao.qtExemplares"
                            />
                            <label class="active" :for="_uid + 'qtExemplares'">Quantidade</label>
                        </div>
                    </div>

                    <fieldset class="proponente-s" v-show="distribuicaoGratuita =='s' ? false : true">
                        <legend>
                            <strong>Proponente </strong>(at&eacute; {{ percentualProponentePadrao * 100 }}%)
                            <select-percent
                                v-bind:disabled="distribuicaoGratuita =='s' ? true: false"
                                v-bind:maximoCombo="(percentualProponentePadrao *  100)"
                                v-on:evento="percentualProponente = $event/100">
                            </select-percent>
                        </legend>
                        <div class="row">
                            <div class="input-field col s12 m6 l2">
                                <input-money
                                    v-bind:disabled="distribuicaoGratuita =='s'? true: false"
                                    v-bind:value="distribuicao.vlUnitarioProponenteIntegral"
                                    v-on:ev="distribuicao.vlUnitarioProponenteIntegral = $event">
                                </input-money>
                                <label 
                                    class="active" 
                                    :for="_uid + 'vlUnitarioProponenteIntegral'"
                                >Pre&ccedil;o Unit&aacute;rio R$</label>
                            </div>
                            <div class="input-field col s12 m6 l2">
                                <input 
                                    type="text" 
                                    class="browser-default disabled" 
                                    disabled 
                                    v-model="distribuicao.qtProponenteIntegral" 
                                    ref="qtProponenteIntegral"
                                />
                                <label 
                                    class="active" 
                                    :for="_uid + 'qtProponenteIntegral'"
                                >Quantidade {{labelInteira}}</label>
                            </div>
                            <div class="input-field col s12 m6 l2" v-if="distribuicao.tpVenda == 'i'">
                                <input 
                                    type="text" 
                                    class="browser-default disabled" 
                                    disabled 
                                    v-model="distribuicao.qtProponenteParcial"
                                />
                                <label 
                                    class="active" 
                                    :for="_uid + 'qtProponenteParcial'"
                                >Quantidade Meia</label>
                            </div>
                            <div class="input-field col s12 m6 l3">
                                <input 
                                    type="text" 
                                    class="browser-default disabled" 
                                    disabled 
                                    v-model="distribuicao.vlReceitaProponenteIntegral"
                                />
                                <label 
                                    class="active" 
                                    :for="_uid + 'vlReceitaProponenteIntegral'"
                                >Valor {{labelInteira}} R$</label>
                            </div>
                            <div class="input-field col s12 m6 l3" v-if="distribuicao.tpVenda == 'i'">
                                <input 
                                    type="text" 
                                    class="browser-default disabled" 
                                    disabled 
                                    v-model="distribuicao.vlReceitaProponenteParcial"
                                />
                                <label 
                                    class="active" 
                                    :for="_uid + 'vlReceitaProponenteParcial'"
                                >Valor meia R$</label>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="preco-popular" v-show="distribuicaoGratuita =='s' ? false : true">
                        <legend>
                            <strong>Pre&ccedil;o Popular</strong> (Padr&atilde;o: {{ percentualPrecoPopularPadrao * 100 }}%)
                            <select-percent
                                v-bind:disabled="distribuicaoGratuita =='s'? true: false"
                                v-bind:maximoCombo="(percentualMaximoPrecoPopular *  100)"
                                v-on:evento="percentualPrecoPopular = $event/100">
                            </select-percent>
                        </legend>
                        <div class="row">
                            <div class="input-field col s12 m6 l2">
                                <input-money
                                    v-bind:disabled="distribuicaoGratuita=='s' ? true: false"
                                    v-bind:value="distribuicao.vlUnitarioPopularIntegral"
                                    v-on:ev="distribuicao.vlUnitarioPopularIntegral = $event">
                                </input-money>
                                <label 
                                    class="active" 
                                    v-bind:disabled="distribuicaoGratuita=='s' ? true: false"
                                    :for="_uid + 'vlUnitarioPopularIntegral'"
                                >Pre&ccedil;o Unit&aacute;rio R$
                                </label>
                            </div>
                            <div class="input-field col s12 m6 l2">
                                <input 
                                    type="text" 
                                    class="browser-default right-align disabled" 
                                    disabled
                                    v-model="distribuicao.qtPopularIntegral" 
                                    ref="qtPopularIntegral"
                                />
                                <label 
                                    class="active" 
                                    :for="_uid + 'qtPopularIntegral'">
                                    Quantidade {{labelInteira}}
                                </label>
                            </div>
                            <div class="input-field col s12 m6 l2" v-if="distribuicao.tpVenda == 'i'">
                                <input 
                                    type="text" 
                                    class="browser-default right-align disabled" 
                                    disabled
                                    v-model="distribuicao.qtPopularParcial" 
                                    ref="distribuicao.qtPopularParcial"
                                />
                                <label class="active" :for="_uid + 'qtPopularParcial'">
                                    Quantidade Meia
                                </label>
                            </div>
                            <div class="input-field col s12 m6 l3">
                                <input 
                                    type="text" 
                                    class="browser-default disabled" 
                                    disabled 
                                    v-model="distribuicao.vlReceitaPopularIntegral"
                                />
                                <label class="active" :for="_uid + 'vlReceitaPopularIntegral'">
                                    Valor {{labelInteira}} R$
                                </label>
                            </div>
                            <div class="input-field col s12 m6 l3" v-if="distribuicao.tpVenda == 'i'">
                                <input 
                                    type="text" 
                                    class="browser-default disabled" 
                                    disabled 
                                    v-model="distribuicao.vlReceitaPopularParcial"
                                />
                                <label class="active" :for="_uid + 'vlReceitaPopularParcial'">Valor meia R$</label>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="distribuicao-gratuita">
                        <legend>
                            <strong>Distribui&ccedil;&atilde;o Gratuita</strong> (m&iacute;nimo {{percentualGratuitoPadrao * 100 }}%)
                            <span v-if="percentualGratuitoPadrao !== this.percentualGratuito"> 
                                <b>Atual {{ parseInt(this.percentualGratuito *  100) }}%</b>
                            </span>
                        </legend>
                        <div class="row">
                            <div class="input-field col s12 m6 l3">
                                <input 
                                    type="number" 
                                    class="browser-default right-align" 
                                    v-model.number="distribuicao.qtGratuitaDivulgacao"
                                    ref="divulgacao"
                                />
                                <label class="active" :for="_uid + 'qtGratuitaDivulgacao'">
                                    Divulga&ccedil;&atilde;o (At&eacute; {{ parseInt(distribuicao.qtExemplares * 0.1) }})
                                </label>
                            </div>
                            <div class="input-field col s12 m6 l3">
                                <input 
                                    type="number" 
                                    class="browser-default right-align" 
                                    v-model="distribuicao.qtGratuitaPatrocinador"
                                    ref="patrocinador"
                                />
                                <label class="active" :for="_uid + 'qtGratuitaPatrocinador'">
                                    Patrocinador (At&eacute; {{ parseInt(distribuicao.qtExemplares * 0.1) }})
                                </label>
                            </div>
                            <div class="input-field col s12 m6 l3">
                                <input 
                                    type="text" 
                                    class="browser-default right-align disabled" 
                                    disabled
                                    v-model.number.lazy="distribuicao.qtGratuitaPopulacao"
                                    ref="populacao" 
                                />
                                <label class="active" :for="_uid + 'qtGratuitaPopulacao'">
                                    Popula&ccedil;&atilde;o 
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    <div class="row receita-prevista center-align">
                        <div class="col s12 l12 offset-l8">
                            <p><strong>Receita Prevista: </strong> R$ {{vlReceitaPrevista}}</p>
                        </div>
                    </div>
                    <div class="row salvar center-align">
                        <br>
                        <button class="btn waves-effect waves-light" ref="add" v-on:click.prevent="salvar">
                            Salvar
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `,
    data: function () {
        return {
            distribuicao: {
                idPlanoDistribuicao: this.idplanodistribuicao,
                idUF: this.iduf,
                idMunicipio: this.idmunicipioibge,
                dsProduto: '',
                qtExemplares: 0,
                qtGratuitaDivulgacao: 0,
                qtGratuitaPatrocinador: 0,
                qtGratuitaPopulacao: 0,
                qtPopularIntegral: 0,
                qtPopularParcial: 0,
                vlUnitarioPopularIntegral: 0,
                vlReceitaPopularIntegral: 0,
                vlReceitaPopularParcial: 0,
                qtProponenteIntegral: 0,
                qtProponenteParcial: 0,
                vlUnitarioProponenteIntegral: 0,
                vlReceitaProponenteIntegral: 0,
                vlReceitaProponenteParcial: 0,
                vlReceitaPrevista: 0,
                tpVenda: TIPO_INGRESSO,
                tpLocal: TIPO_LOCAL_ABERTO,
                tpEspaco: TIPO_ESPACO_PRIVADO
            },
            active: false,
            visualizarFormulario: false,
            icon: 'add',
            "distribuicaoGratuita": NAO,
            "percentualGratuitoPadrao": DISTRIBUICAO_GRATUITA_PERCENTUAL_PADRAO,
            "percentualPrecoPopularPadrao": PRECO_POPULAR_PERCENTUAL_PADRAO,
            "percentualPrecoPopular": PRECO_POPULAR_PERCENTUAL_PADRAO,
            "percentualProponentePadrao": PROPONENTE_PERCENTUAL_PADRAO,
            "percentualProponente": PROPONENTE_PERCENTUAL_PADRAO,
            "labelInteira": 'Inteira',
            activeForm: false
        }
    },
    props: [
        'idpreprojeto',
        'idplanodistribuicao',
        'idmunicipioibge',
        'iduf',
        'disabled',
        'canalaberto'
    ],
    computed: {
        qtPrecoPopularValorIntegralLimite: function () {
            var percentualPopularIntegral = 0.5;

            if (this.distribuicao.tpVenda == TIPO_EXEMPLAR) {
                percentualPopularIntegral = 1;
            }
            return parseInt((this.distribuicao.qtExemplares * this.percentualPrecoPopular) * percentualPopularIntegral);
        },
        qtPrecoPopularValorParcialLimite: function () {
            let percentualPopularParcial = 0.5;

            if (this.distribuicao.tpVenda == TIPO_EXEMPLAR) {
                percentualPopularParcial = 0
            }
            return parseInt((this.distribuicao.qtExemplares * this.percentualPrecoPopular) * percentualPopularParcial);
        },
        qtGratuitaPopulacaoMinimo: function () {
            let soma =
                parseInt(this.distribuicao.qtExemplares)
                * this.percentualGratuito
                - (parseInt(this.distribuicao.qtGratuitaPatrocinador) + parseInt(this.distribuicao.qtGratuitaDivulgacao));
            return parseInt(soma)
        },
        percentualGratuito: function () {
            if (this.distribuicaoGratuita == SIM) {
                return 1;
            }
            return DISTRIBUICAO_GRATUITA_PERCENTUAL_PADRAO + (this.percentualMaximoPrecoPopular - this.percentualPrecoPopular);
        },
        percentualMaximoPrecoPopular: function () {
            return PRECO_POPULAR_PERCENTUAL_PADRAO + (PROPONENTE_PERCENTUAL_PADRAO - this.percentualProponente);
        },
        vlReceitaPopularIntegral: function () {
            return numeral(parseInt(this.distribuicao.qtPopularIntegral) * this.converterParaMoedaAmericana(this.distribuicao.vlUnitarioPopularIntegral)).format();
        },
        vlReceitaPopularParcial: function () {
            return numeral(this.distribuicao.qtPopularParcial * this.converterParaMoedaAmericana(this.distribuicao.vlUnitarioPopularIntegral) * 0.5).format();
        },
        vlReceitaProponenteIntegral: function () {
            return numeral(this.converterParaMoedaAmericana(this.distribuicao.vlUnitarioProponenteIntegral) * parseInt(this.distribuicao.qtProponenteIntegral)).format();
        },
        vlReceitaProponenteParcial: function () {
            return numeral((this.converterParaMoedaAmericana(this.distribuicao.vlUnitarioProponenteIntegral) * 0.5 ) * this.distribuicao.qtProponenteParcial).format();
        },
        vlReceitaPrevista: function () {
            let calc = numeral();

            calc.add(this.converterParaMoedaAmericana(this.distribuicao.vlReceitaPopularIntegral));
            calc.add(this.converterParaMoedaAmericana(this.distribuicao.vlReceitaPopularParcial));
            calc.add(this.converterParaMoedaAmericana(this.distribuicao.vlReceitaProponenteIntegral));
            calc.add(this.converterParaMoedaAmericana(this.distribuicao.vlReceitaProponenteParcial));

            return numeral(calc).format();
        },
        atualizarCalculosDistribuicao: function () {
            return [
                this.distribuicao.qtExemplares,
                this.distribuicaoGratuita,
                this.distribuicao.tpVenda,
                this.distribuicao.vlUnitarioProponenteIntegral,
                this.distribuicao.vlUnitarioPopularIntegral,
                this.percentualPrecoPopular
            ].join()
        }
    },
    watch: {
        atualizarCalculosDistribuicao: function (val) {

            this.labelInteira = 'Inteira';
            this.distribuicao.qtProponenteIntegral = 0;
            this.distribuicao.qtProponenteParcial = 0;
            this.distribuicao.qtPopularIntegral = 0;
            this.distribuicao.qtPopularParcial = 0;
            this.distribuicao.vlReceitaProponenteIntegral = 0;
            this.distribuicao.vlReceitaProponenteParcial = 0;
            this.distribuicao.vlReceitaPopularIntegral = 0;
            this.distribuicao.vlReceitaPopularParcial = 0;

            if (this.distribuicaoGratuita == NAO) {
                this.distribuicao.qtProponenteIntegral = this.obterQuantidadePorPercentual(this.percentualProponente);
                this.distribuicao.qtProponenteParcial = this.obterQuantidadePorPercentual(this.percentualProponente);
                this.distribuicao.qtPopularIntegral = this.obterQuantidadePorPercentual(this.percentualPrecoPopular);
                this.distribuicao.qtPopularParcial = this.obterQuantidadePorPercentual(this.percentualPrecoPopular);
                this.distribuicao.vlReceitaProponenteIntegral = this.vlReceitaProponenteIntegral;
                this.distribuicao.vlReceitaProponenteParcial = this.vlReceitaProponenteParcial;
                this.distribuicao.vlReceitaPopularIntegral = this.vlReceitaPopularIntegral;
                this.distribuicao.vlReceitaPopularParcial = this.vlReceitaPopularParcial;

                this.$refs.populacao.disabled = false;
                this.$refs.divulgacao.disabled = false;
                this.$refs.patrocinador.disabled = false;
            } else {
                this.distribuicao.vlUnitarioProponenteIntegral = 0;
                this.distribuicao.vlUnitarioPopularIntegral = 0;
            }

            if (this.distribuicao.tpVenda == TIPO_EXEMPLAR) {
                this.distribuicao.qtPopularParcial = 0;
                this.distribuicao.qtProponenteParcial = 0;
                this.distribuicao.vlReceitaProponenteParcial = 0;
                this.distribuicao.vlReceitaPopularParcial = 0;
                this.labelInteira = '';
            }

            this.distribuicao.qtGratuitaDivulgacao = parseInt(this.distribuicao.qtExemplares * 0.1);
            this.distribuicao.qtGratuitaPatrocinador = parseInt(this.distribuicao.qtExemplares * 0.1);
            this.distribuicao.qtGratuitaPopulacao = this.qtGratuitaPopulacaoMinimo;
        },
        "distribuicao.qtGratuitaDivulgacao": function (val) {
            let limiteQuantidadeDivulgacao = this.distribuicao.qtExemplares * 0.1;

            if (val > limiteQuantidadeDivulgacao) {
                this.mensagemErro("A quantidade n\xE3o pode passar de " + limiteQuantidadeDivulgacao);
                this.distribuicao.qtGratuitaDivulgacao = limiteQuantidadeDivulgacao;
            }

            this.distribuicao.qtGratuitaPopulacao = this.qtGratuitaPopulacaoMinimo;
        },
        "distribuicao.qtGratuitaPatrocinador": function (val) {
            let limitePatrocinador = this.distribuicao.qtExemplares * 0.1;

            if (val > limitePatrocinador) {
                this.mensagemErro("A quantidade n\xE3o pode passar de " + limitePatrocinador);
                this.distribuicao.qtGratuitaPatrocinador = limitePatrocinador;
            }

            this.distribuicao.qtGratuitaPopulacao = this.qtGratuitaPopulacaoMinimo;
        },
        "distribuicao.vlUnitarioPopularIntegral": function () {
            if (this.converterParaMoedaAmericana(this.distribuicao.vlUnitarioPopularIntegral) > 75.00) {
                this.mensagemErro('O pre\xE7o unit\xE1rio n\xE3o pode ser maior que R$ 75,00');
                this.distribuicao.vlUnitarioPopularIntegral = numeral(75.00).format();
                console.log('vlunitarioPopularIntegral', this.distribuicao.vlUnitarioPopularIntegral);
            }
        },
        percentualProponente: function () {
            this.percentualPrecoPopular = this.percentualMaximoPrecoPopular;
        }
    },
    mounted: function () {
        // this.t();
        this.$refs.add.disabled = !this.disabled;
    },
    methods: {
        obterDiferencaDosItensDistribuidos: function () {
            let soma = numeral();

            soma.add(this.distribuicao.qtProponenteIntegral);
            soma.add(this.distribuicao.qtProponenteParcial);
            soma.add(this.distribuicao.qtPopularIntegral);
            soma.add(this.distribuicao.qtPopularParcial);
            soma.add(this.distribuicao.qtGratuitaDivulgacao);
            soma.add(this.distribuicao.qtGratuitaPatrocinador);
            soma.add(this.distribuicao.qtGratuitaPopulacao);
            console.log('numeral', numeral(soma).value());
            console.log('exemplares', parseInt(this.distribuicao.qtExemplares));
            return parseInt(numeral(soma).value() - parseInt(this.distribuicao.qtExemplares));
        },
        obterQuantidadePorPercentual: function (percentualDistribuicao) {
            let divisao = 0.5;

            if (this.distribuicao.tpVenda == TIPO_EXEMPLAR) {
                divisao = 1;
            }
            return parseInt((this.distribuicao.qtExemplares * percentualDistribuicao) * divisao);
        },
        converterParaMoedaAmericana: function (valor) {
            if (!valor)
                valor = '0';

            valor = valor.replace(/\./g, '');
            valor = valor.replace(/\,/g, '.');
            valor = parseFloat(valor);
            valor = valor.toFixed(2);

            if (isNaN(valor))
                valor = 0;

            return valor;
        },
        mostrar: function () {
            this.active = this.active == true ? false : true;
            this.icon = this.icon == 'visibility_off' ? 'add' : 'visibility_off';
        },
        mostrarFormulario: function (el) {
            this.visualizarFormulario = this.visualizarFormulario == true ? false : true;

            if (this.visualizarFormulario == true) {
                let element = $('#' + el).offset().top - 60;
                $('body').animate({
                    scrollTop: element
                }, 500);
            }
        },
        limparFormulario: function () {
            Object.assign(this.$data, this.$options.data.apply(this))
        },
        mensagemSucesso: function (msg) {
            Materialize.toast(msg, 8000, 'green white-text');
        },
        mensagemErro: function (msg) {
            Materialize.toast(msg, 8000, 'red darken-1 white-text');
        },
        mensagemAlerta: function (msg) {
            Materialize.toast(msg, 8000, 'mensagem1 orange darken-3 white-text');
        },
        salvar: function (event) {

            if (this.distribuicao.dsProduto == '' && this.distribuicao.tpVenda == 'i') {
                this.mensagemAlerta("\xC9 obrigat\xF3rio informar a categoria");
                this.$refs.dsProduto.focus();
                return;
            }

            if (this.distribuicao.qtExemplares == 0) {
                this.mensagemAlerta("Quantidade \xE9 obrigat\xF3rio!");
                this.$refs.qtExemplares.focus();
                return;
            }

            if (this.distribuicaoGratuita == NAO) {
                if (this.distribuicao.vlUnitarioProponenteIntegral == 0 && this.percentualProponente > 0) {
                    this.mensagemAlerta("Pre\xE7o unit\xE1rio no Proponente \xE9 obrigat\xF3rio!");
                    return;
                }

                if (this.distribuicao.vlUnitarioPopularIntegral == 0 && this.percentualPrecoPopular > 0) {
                    this.mensagemAlerta("Pre\xE7o unit\xE1rio no Pre\xE7o Popular \xE9 obrigat\xF3rio!");
                    return;
                }
            }

            if (this.distribuicao.qtGratuitaPopulacao < this.qtGratuitaPopulacaoMinimo) {
                this.mensagemAlerta("Quantidade para popula\xE7\xE3o n\xE3o pode ser menor que " + this.qtGratuitaPopulacaoMinimo);
                this.distribuicao.qtGratuitaPopulacao = this.qtGratuitaPopulacaoMinimo;
                this.$refs.populacao.focus();
                return;
            }

            // this.$data.produtos.push(this.distribuicao);

            this.visualizarFormulario = false;

            let vue = this;
            $3.ajax({
                type: "POST",
                url: "/proposta/plano-distribuicao/detalhar-salvar/idPreProjeto/" + this.idpreprojeto,
                data: this.distribuicao
            }).done(function () {
                // vue.t();
                vue.limparFormulario();
                vue.mensagemSucesso('Detalhamento salvo com sucesso');
            }).fail(function () {
                vue.mensagemErro('Erro ao salvar o detalhamento!');
            });
        }
    }
});

var app6 = new Vue({
    el: '#container-vue'
});

$3(document).ajaxStart(function () {
    $3('#container-loading').show();
});

$3(document).ajaxComplete(function () {
    $3('#container-loading').hide();
});