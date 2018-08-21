<template>
    <div>
        <v-toolbar
          app
          color="green"
          dense
        >
            <v-menu
                :nudge-width="100"
                v-for="item in dadosMenu"
                :key="item"
                offset-y
            >
                <v-toolbar-items
                    slot="activator"
                >
                    <span v-html="item.label"></span>
                    <v-icon dark>arrow_drop_down</v-icon>
                </v-toolbar-items>
                <v-list
                    v-for="menu in item.menu"
                    :key="item.menu"
                >
                    <v-list-tile>
                        <v-list-tile-title >
                            <a
                                :href="('/' + menu.url.module + '/' + menu.url.controller + '/' + menu.url.action)"
                                v-html="menu.label"></a>
                        </v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-menu>
        </v-toolbar>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
    name: 'SlNav',
    components: {
    },
    props: ['registroAtivo'],
    data() {
        return {
            currentRegistro: {
                Codigo: '',
                DadoNr: '',
            },
            items: ['pedro', 'leo'],
        };
    },
    computed: {
        ...mapGetters({
            dadosMenu: 'avaliacaoResultados/dadosMenu',
            modalVisible: 'modal/default',
        }),
    },
    mounted() {
        this.dadosMenuAjax();
    },
    methods: {
        ...mapActions({
            atualizarRegistro: 'avaliacaoResultados/atualizarRegistro',
            dadosMenuAjax: 'avaliacaoResultados/dadosMenu',
 //           setRegistroAtivo: 'avaliacaoResultados/setRegistroAtivo',
  //          modalOpen: 'modal/modalOpen',
   //         modalClose: 'modal/modalClose',
        }),
        buildRegistro(event) {
            const DadoNr = event.target.value;
            this.currentRegistro.DadoNr = DadoNr;
            this.currentRegistro.Codigo = this.registro.Codigo;
        },
        checkChangesAndUpdate() {
            if (this.currentRegistro !== this.registro) {
                this.atualizarRegistro(this.currentRegistro);
            }
        },
        fecharModal() {
            // eslint-disable-next-line
            $3('#modalTemplate').modal('close');
            this.modalClose();
        },
        alert() {
            alert('teste');
        },
    },
};
</script>
