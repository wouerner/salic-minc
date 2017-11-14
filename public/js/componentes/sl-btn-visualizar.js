Vue.component('sl-btn-visualizar', {
    template: ` 
        <div>
            <button class="btn" v-on:click="modal()">
                {{pronac}}
            </button>
        </div>
    `,
    data: function() {
        return {
            dados:[]
        }
    },
    props: ['idpronac', 'pronac'],
    mounted: function() {
    },
    methods: {
        modal: function() {
            bus.$emit('id-selected', this.idpronac)
            $3('#abrirModal').modal();
            $3('#abrirModal').modal('open');
        }
    }
});

