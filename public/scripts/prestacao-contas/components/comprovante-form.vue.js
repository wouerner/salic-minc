Vue.component('sl-comprovar-form',
{
    template: `
        <div class="row">
            <div class="col s12">
              <ul class="tabs">
                <li class="tab col s3"><a class="active" href="#test1" v-on:click="visivel()">Nacional</a></li>
                <li class="tab col s3"><a v-on:click="visivel()" href="#test2">Internacional</a></li>
              </ul>
            </div>
            <div v-show="v" id="test1" class="col s12">
                <sl-comprovante-nacional-form
                    tipoform="cadastro"
                    url="/prestacao-contas/gerenciar/cadastrar"
                    :item="itemId"
                    :idplanilhaaprovacao="idplanilhaaprovacaoId"
                    :datainicio="datainicio"
                    :datafim="datafim"
                    :valoraprovado=valoraprovado
                    :valorcomprovado="valorComprovado"
                >
                </sl-comprovante-nacional-form>
            </div>
            <div v-show="!v" id="test2" class="col s12">
                <sl-comprovante-internacional-form
                    tipoform="cadastro"
                    url="/prestacao-contas/gerenciar/cadastrar"
                    :item="itemId"
                    :idplanilhaaprovacao="idplanilhaaprovacaoId"
                    :datainicio="datainicio"
                    :datafim="datainicio"
                    :valoraprovado="valoraprovado"
                    :valorcomprovado="valorComprovado"
                >
                </sl-comprovante-internacional-form>
            </div>
        </div>
    `,
    created: function () {
        let vue = this;
        this.$root.$on('novo-comprovante-nacional', function(data) {
            vue.valorComprovado = parseFloat(vue.valorComprovado) + parseFloat(data.valor);
        })

        this.$root.$on('comprovante-nacional-atualizado', function(data) {
            vue.formVisivel = false;
            if(vue.tipo =='nacional'){
                Vue.set(vue.$data.dados, data._index, data);
                vue.$data.valorComprovado = (parseFloat(vue.valorcomprovado) - parseFloat(data.valorAntigo)) + parseFloat(data.valor);
                console.log(vue.valorComprovado);
            }
        })
    },
    mounted: function() {
    },
    props: ['item', 'idplanilhaaprovacao', 'datainicio', 'datafim', 'valoraprovado', 'valorcomprovado'],
    mounted() {
        this.random = (Math.random() * 10000000000000000);
    },
    data() {
        return {
            itemId: this.item ,
            idplanilhaaprovacaoId: this.idplanilhaaprovacao ,
            v: true,
            valorComprovado: this.valorcomprovado 
        };
    },
    methods: {
        visivel: function () {
            this.v = !this.v;
        },
    }
});
