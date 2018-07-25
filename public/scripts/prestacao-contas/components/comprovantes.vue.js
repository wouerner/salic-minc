Vue.component('comprovantes', {
    template: `
        <div>
            <template v-if="dados.length > 0 || Object.keys(dados).length > 0 ">
              <transition-group  
                tag="ul" 
                class="collapsible" 
                name="list" 
                data-collapsible="accordion" 
                enter-active-class="animated tada"
                leave-active-class="animated bounceOutRight"
              >
                <li 
                    v-for="dado in dados" 
                    :key="dado.idComprovantePagamento">
                  <div class="collapsible-header">
                        Fornecedor: {{dado.fornecedor.nome}} - R$ {{valorFormatado(dado.valor)}}
                        <span :class="['badge white-text ', badgeStatus(dado.status)]">
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
                                        @click.prevent="excluir(dado.idComprovantePagamento, dado.idArquivo, dado.idComprovantePagamento)">excluir</button>
                                </div>
                                <template v-if="formVisivel">
                                    <component
                                        :is="componenteform"
                                        :dados="dado"
                                        :index="dado.idComprovantePagamento"
                                        url="/prestacao-contas/gerenciar/atualizar"
                                        tipoform="edicao"
                                        :item="idplanilhaitem"
                                        :datainicio="datainicio"
                                        :datafim="datafim"
                                        :valoraprovado="valoraprovado"
                                        :valorcomprovado="valorComprovado"
                                        :valorantigo="dado.valor"
                                        :status="edicao"
                                    >
                                    </component>
                                </template>
                            </div>
                        </div>
                  </div>
                </li>
              </transition-group>
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
                data.status='novo';
                // vue.$data.dados.push(data);
                Vue.set(vue.$data.dados, data._index, data);
                vue.valorComprovado = parseFloat(vue.valorcomprovado) + parseFloat(data.valor);
            }
        })

        this.$root.$on('atualizado-comprovante-nacional', function(data) {
            vue.formVisivel = false;
            if(vue.tipo =='nacional'){
                data.status='atualizado';
                Vue.set(vue.$data.dados, data._index, data);
                vue.valorComprovado = (parseFloat(vue.valorcomprovado) - parseFloat(data.valorAntigo)) + parseFloat(data.valor);
            }
        })

        this.$root.$on('novo-comprovante-internacional', function(data) {
            if(vue.tipo =='internacional'){
                data.status='novo';
                vue.$data.dados.push(data);
                vue.valorComprovado = parseFloat(vue.valorcomprovado) + parseFloat(data.valor);
            }
        })

        this.$root.$on('atualizado-comprovante-internacional', function(data) {
            if(vue.tipo =='internacional'){
                data.status='atualizado';
                vue.formVisivel = false;
                Vue.set(vue.$data.dados, data._index, data);
            }
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
            console.log(data.data);
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
        badgeStatus: function(id) {
            if (id == 'novo') {
                return {
                    ' green accent-2': true,
                }
            }

            if (id == 'atualizado') {
                return {
                    'blue': true,
                }
            }
        },
        mostrarForm: function() {
            this.formVisivel = true;
        },
        excluir: function(id, idArquivo, index) {
            this.$root.$emit('excluir-comprovante-nacional', this.dados[index]);
            this.$delete(this.dados, index);

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
            formVisivel: false,
            valorComprovado: this.valorcomprovado
        }
    }
});
