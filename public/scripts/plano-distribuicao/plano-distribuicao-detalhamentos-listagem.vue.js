Vue.component('plano-distribuicao-detalhamentos-listagem', {
    template: `
        <div class="row center-align">
            <table class="bordered">
                <thead v-if="detalhamentos && detalhamentos.length > 0">
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
                        <th rowspan="2" colspan="2" width="10%" class="center-align">A&ccedil;&otildees</th>
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
                <tbody v-if="detalhamentos && detalhamentos.length > 0">
                    <tr v-for="( detalhamento, index ) in detalhamentos">
                        <td>{{ detalhamento.dsProduto }}</td>
                        <td class="center-align">{{ detalhamento.qtExemplares }}</td>
                        <!--Preço Proponente -->
                        <td class="center-align">{{ detalhamento.qtProponenteIntegral }}</td>
                        <td class="center-align">{{ detalhamento.qtProponenteParcial }}</td>
                        <td class="right-align">{{ formatarValor(detalhamento.vlUnitarioProponenteIntegral) }}</td>
                        <!--Preço Popular -->
                        <td class="center-align">{{ detalhamento.qtPopularIntegral }}</td>
                        <td class="center-align">{{ detalhamento.qtPopularParcial }}</td>
                        <td class="right-align">{{ formatarValor(detalhamento.vlUnitarioPopularIntegral) }}</td>
                        <!-- Distribuicao Gratuita-->
                        <td class="center-align">{{ parseInt(detalhamento.qtGratuitaDivulgacao) +
                            parseInt(detalhamento.qtGratuitaPatrocinador) + parseInt(detalhamento.qtGratuitaPopulacao) }}
                        </td>
                        <td class="right-align">{{ formatarValor(detalhamento.vlReceitaPrevista) }}</td>
                        <td>
                             <a 
                                href="javascript:void(0)"
                                class="btn small waves-effect waves-light tooltipped btn-primary btn-editar"
                                :class="_uid + '_teste'"
                                data-tooltip="Editar detalhamento"
                                v-bind:disabled="disabled"
                                @click.prevent="editar(detalhamento, index)">
                                <i class="material-icons">edit</i>
                            </a>
                        </td>
                        <td>
                            <a
                                href="javascript:void(0)"
                                class="btn small waves-effect waves-light tooltipped btn-danger btn-excluir-item"
                                data-tooltip="Excluir detalhamento"
                                v-bind:disabled="disabled"
                                    @click.prevent="excluir(detalhamento, index)">
                                <i class="material-icons">delete</i>
                            </a>
                            
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="12" class="center-align">Nenhum detalhamento cadastrado</td>
                    </tr>
                </tbody>
                <tfoot v-if="detalhamentos && detalhamentos.length > 0" style="opacity: 0.5">
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
                        <td class="center-align"><b>{{ qtDistribuicaoGratuitaTotal }}</b>
                        </td>
                        <td class="right-align"><b>{{ receitaPrevistaTotal }}</b></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            
            <table style="max-width: 300px" v-if="detalhamentos && detalhamentos.length > 0">
                <tr>
                    <th>
                        <b>Valor m&eacute;dio </b>
                    </th>
                    <td class="center-align red" v-if="((valorMedioProponente.value() > 225) && (this.canalaberto == 0))"> 
                        {{valorMedioProponenteFormatado}}
                    </td>
                    <td class="center-align " v-else>{{valorMedioProponenteFormatado}}</td>
                </tr>
            </table>
        </div>
    `,
    data: function () {
        return {}
    },
    mixins: [utils],
    watch: {
        detalhamentos: function () {
            if ((numeral(this.valorMedioProponente).value() > 225
                && (this.canalaberto == 0))) {
                this.mensagemAlerta("O valor medio:" + this.valorMedioProponenteFormatado + ", n\xE3o pode ultrapassar: 225,00");
                this.$data.detalhamentos.splice(-1, 1)
            }
        }
    },
    props: [
        'idpreprojeto',
        'idplanodistribuicao',
        'idmunicipioibge',
        'iduf',
        'disabled',
        'canalaberto',
        'detalhamentos'
    ],
    computed: {
        qtExemplaresTotal: function () {
            return this.detalhamentos.reduce(function (total, value) {
                return total + parseInt(value.qtExemplares);
            }, 0);
        },
        qtDistribuicaoGratuitaTotal: function () {
            return this.detalhamentos.reduce(function (total, value) {
                return total + (
                    parseInt(value.qtGratuitaDivulgacao) +
                    parseInt(value.qtGratuitaPatrocinador) +
                    parseInt(value.qtGratuitaPopulacao));
            }, 0);
        },
        qtPopularIntegralTotal: function () {
            return this.detalhamentos.reduce(function (total, value) {
                return total + parseInt(value.qtPopularIntegral);
            }, 0);
        },
        qtPopularParcialTotal: function () {
            return this.detalhamentos.reduce(function (total, value) {
                return total + parseInt(value.qtPopularParcial);
            }, 0);
        },
        qtProponenteIntegralTotal: function () {
            return this.detalhamentos.reduce(function (total, value) {
                return total + parseInt(value.qtProponenteIntegral);
            }, 0);
        },
        qtProponenteParcialTotal: function () {
            return this.detalhamentos.reduce(function (total, value) {
                return total + parseInt(value.qtProponenteParcial);
            }, 0);
        },
        receitaPrevistaTotal: function () {
            var soma = numeral();

            soma.add(this.detalhamentos.reduce(function (total, value) {
                return total + parseFloat(value.vlReceitaPrevista);
            }, 0));

            return soma.format();
        },
        valorMedioProponente: function () {
            var vlReceitaProponenteIntegral = numeral();
            var vlReceitaProponenteParcial = numeral();
            var qtProponenteIntegral = numeral();
            var qtProponenteParcial = numeral();

            for (var i = 0; i < this.detalhamentos.length; i++) {
                vlReceitaProponenteIntegral.add(this.detalhamentos[i]['vlReceitaProponenteIntegral']);
                vlReceitaProponenteParcial.add(parseFloat(this.detalhamentos[i]['vlReceitaProponenteParcial']));
                qtProponenteIntegral.add(parseFloat(this.detalhamentos[i]['qtProponenteIntegral']));
                qtProponenteParcial.add(parseFloat(this.detalhamentos[i]['qtProponenteParcial']));
            }

            let media = numeral(parseFloat(vlReceitaProponenteIntegral.value() + vlReceitaProponenteParcial.value()) / (qtProponenteIntegral.value() + qtProponenteParcial.value()));

            return media;
        },
        valorMedioProponenteFormatado: function () {
            return this.valorMedioProponente.format();
        }
    },
    methods: {
        excluir: function (detalhamento, index) {
            this.$emit('eventoRemoverDetalhamento', detalhamento, index);
        },
        editar: function(detalhamento, index) {

            let elm = $3("div[formIdMunicipio='"+ detalhamento.idMunicipio + "']");
            console.error('editar', "div[formIdMunicipio='"+ detalhamento.idMunicipio + "']", elm,detalhamento.idMunicipio);
            $3("html, body").animate({
                scrollTop: $3(elm).offset().top + 30
            }, 600);

            this.$emit('eventoEditarDetalhamento', detalhamento, index);
        }
    }
});