Vue.component('dados', {
    template:`
        <div>
              <ul class="collapsible" data-collapsible="accordion">
                <li v-for="dado in dados">
                  <div class="collapsible-header">{{dado.title}}</div>
                  <div class="collapsible-body">
                    <sl-table-visualizar v-bind:dados="dado"></sl-table-visualizar>
                  </div>
                </li>
              </ul>
        </div>
    `,
    data: function() {
        return {
            dados:[]
        }
    },
    created: function() {
        vue = this;
        bus.$on('id-selected', function (id) {
            vue.idpronac = id;
            vue.alerta();
        });
    },
    props: ['idpronac'],
    mounted: function() { },
    methods: {
        alerta: function() {
            vue = this;
            $3.ajax({
                url: '/prestacao-contas/visualizar-projeto/dados-projeto?idPronac=' + vue.idpronac
            })
            .done( function(data) {
                vue.dados = data; 
            });
        }
    }
});
