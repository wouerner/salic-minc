Vue.component('comprovantes', {
    template: `
        <div>
            <template v-if="dados.length > 0 ">
            <ul class="collapsible" data-collapsible="accordion">
                <li v-for="(dado, index) in dados">
                  <div class="collapsible-header">
                        Fornecedor: {{dado.fornecedor.nome}} - R$ {{valorFormatado(dado.valor)}}
                        <span :class="['badge white-text', badgeCSS(dado.stItemAvaliado)]">
                            {{situacao(dado.stItemAvaliado)}}
                        </span>
                  </div>
                  <div :class="['collapsible-body lighten-5', badgeCSS(dado.stItemAvaliado)]">
                        <div class="card">
                            <div class="card-content">
                                <template v-if="!formVisivel" >
                                    <template v-if="(tipo == 'nacional')" >
                                        <comprovante-table :dados="dado"></comprovante-table>
                                    </template>
                                    <template v-if="(tipo == 'internacional')" >
                                        <sl-comprovante-internacional-table :dados="dado">
                                        </sl-comprovante-internacional-table>
                                    </template>
                                </template>
                                <div class="center-align">
                                    <button v-if="!formVisivel" v-on:click="mostrarForm()" class="btn ">editar</button>
                                    <button v-if="!formVisivel" type="button" class="btn red white-text center-align"
                                        @click.prevent="excluir(dado.idComprovantePagamento, dado.idArquivo, index)">excluir</button>
                                </div>
                                <template v-if="formVisivel">
                                    <component
                                        :is="componenteform"
                                        :dados="dado"
                                        :index="index"
                                        url="/prestacao-contas/gerenciar/atualizar"
                                        tipoform="edicao"
                                        :item="idplanilhaitem"
                                        :datainicio="datainicio"
                                        :datafim="datafim"
                                        :valoraprovado="valoraprovado"
                                        :valorcomprovado="valorcomprovado"
                                        :valorantigo="dado.valor"
                                    >
                                    </component>
                                </template>
                            </div>
                        </div>
                  </div>
                </li>
            </ul>
            </template>
            <template v-else>
                <p> Sem comprovantes</p>
            </template>
        </div>
    `,
    components:{
        'comprovante-table': comprovanteTable,
    },
    props: [
        'idpronac',
        'produto',
        'stitemavaliado',
        'uf',
        'idmunicipio',
        'idplanilhaitem',
        'etapa',
        'componenteform',
        'tipo',
        'url',
        'datainicio',
        'datafim',
        'valoraprovado',
        'valorcomprovado'
    ],
    created() {
        let vue = this;
            this.$root.$on('novo-comprovante-nacional', function(data) {
                if(vue.tipo =='nacional'){
                    // console.log('evento nacional!!!!', vue._uid)
                    vue.$data.dados.push(data);
                }
            })

            this.$root.$on('comprovante-nacional-atualizado', function(data) {
                vue.formVisivel = false;
                if(vue.tipo =='nacional'){
                    Vue.set(vue.$data.dados, data._index, data);
                }
            })

            this.$root.$on('novo-comprovante-internacional', function(data) {
                // vue.formVisivel = false;
                // vue.dados.push(data);
                // console.log('evento internacional');
                if(vue.tipo =='internacional'){
                    vue.$data.dados.push(data);
                }
            })

            this.$root.$on('atualizado-comprovante-internacional', function(data) {
                vue.formVisivel = false;
            })
    },
    mounted: function() {
        var vue = this;
        url = '/prestacao-contas/comprovante-pagamento';
        $3.ajax({
          type: "GET",
          url:url,
          data:{
              idPronac: this.idpronac,
              idPlanilhaItem: this.idplanilhaitem,
              produto: this.produto,
              uf: this.uf,
              idmunicipio: this.idmunicipio,
              etapa: this.etapa,
              tipo: vue.tipo
          }
        })
        .done(function(data) {
            vue.$data.dados = data.data;
                $3('.collapsible').each(function() {
                    $3(this).collapsible();
                });
        })
        .fail(function(jqXHR) {
            alert('error');
        });
    },
    computed: {
    },
    updated() {
        $3('.collapsible').each(function() {
            $3(this).collapsible();
        });
    },
    methods:{
        badgeCSS: function(id) {
            if (id == 1) {
                return {
                    'green ': true,
                }
            }
            if (id == 3) {
                return {
                    ' red': true,
                }
            }
            if (id == 4) {
                return {
                    'grey': true,
                }
            }
        },
        situacao: function(id) {
            estado = null;
            switch(parseInt(id)) {
                case 1:
                     estado = 'Aprovado';
                    break;
                case 3:
                    estado =  'Recusado'
                    break;
                default:
                    estado =  'N\xE3o avaliado';
            }
            return estado;
        },
        mostrarForm: function() {
            this.formVisivel = true;
        },
        excluir: function(id, idArquivo, index) {
            this.$delete(this.dados, index)
            var vue = this;
            url = '/prestacao-contas/gerenciar/excluir';
            $3.ajax({
              type: "POST",
              url:url,
              data:{
                  comprovante: {idComprovantePagamento: id},
              }
            })
            .done(function(data) {
                Materialize.toast('Excluido com sucesso!', 4000, 'red');
            })
            .fail(function(jqXHR) {
                alert('error');
            });
        },
        valorFormatado: function(valor) {
            return numeral(parseFloat(valor)).format('0,0.00');
        }
    },
    data: function(){
        return {
            dados:{},
            formVisivel: false
        }
    }
});
