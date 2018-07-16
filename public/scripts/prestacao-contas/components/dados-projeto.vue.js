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

numeral.locale('pt-br');

function converteParaReal(value) {
    value = parseFloat(value);
    return numeral(value).format('0,0.00');
}

Vue.component('dados-projeto', {
    props: ['idpronac'],
    template: `<div class="col s12 m12" :informacoes = "informacoes">
                    <div class="card horizontal">
                        <div class="card-stacked">
                            <div class="center-align card-content  lighten-4">
                                <span class="card-title">
                                    Projeto: {{ informacoes.Pronac }} - {{ informacoes.NomeProjeto }}
                                </span>
                            </div>
                            <div class="card-content">
                                 <table class="bordered">
                                    <tbody>
                                        <tr>
                                            <th v-html>Data Inicio da execu&ccedil;&atilde;o</th>
                                            <td>{{ dataInicio }}</td>
                                        </tr>
                                        <tr>
                                            <th v-html>Data Final da execu&ccedil;&atilde;o</th>
                                            <td>{{ dataFim }}</td>
                                        </tr>
                                        <tr>
                                            <th>Valor Aprovado</th>
                                            <td>R$ {{ converterParaReal(informacoes.vlAprovado) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Valor Comprovado</th>
                                            <td>R$ {{ converterParaReal(informacoes.vlComprovado) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Valor a Comprovar</th>
                                            <td>R$ {{ converterParaReal(informacoes.vlComprovar) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-action">
                                <a  :href="'/consultardadosprojeto/index?idPronac=' + idpronac " target="_blank"
                                    class="btn waves-effect waves-dark white-text">Ver Projeto
                                </a>
                            </div>
                        </div>
                    </div>
                </div>`,
    mounted: function () {
        let vue = this;
        $3.ajax({
            url: "/prestacao-contas/pagamento/planilha-dados-projeto/idpronac/" + this.idpronac
        }).done(function( data ) {
            vue.$data.informacoes = data;
        });
    },
    computed: {
        dataInicio() {
            return moment(this.informacoes.dtInicioExecucao).format('DD/MM/YYYY');
        },
        dataFim() {
            return moment(this.informacoes.dtFimExecucao).format('DD/MM/YYYY');
        }
    },
    data: function () {
        return {
            informacoes: []
        };
    },
    methods:{
        converterParaReal: function (value) {
            value = parseFloat(value);
            return numeral(value).format('0,0.00');
        },
        moment: function (value) {
            
            return moment();
        }
    }
})
