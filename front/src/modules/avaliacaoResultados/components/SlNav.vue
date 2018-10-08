<template>
    <div>
        <div v-if="dados">
        <v-toolbar
          app
          color="green darken-4 "
          dense
          dark
        >
            <v-toolbar-title>
                <img src="/public/img/logo_salic.png" alt="logo" height="30px">
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-menu
                :nudge-width="100"
                v-for="(item, index) in dadosMenu"
                :key="item.id"
                offset-y
            >
                <v-toolbar-title
                    slot="activator"
                >
                    <v-btn flat>
                        <span v-html="item.label"></span>
                        <v-icon right dark>arrow_drop_down</v-icon>
                    </v-btn>
                </v-toolbar-title>
                <v-list
                    v-for="(menu, index) in item.menu"
                    :key="index"
                >
                    <v-list-tile>
                        <v-list-tile-title >
                            <a
                                :href="('/' + menu.url.module + '/' + menu.url.controller + '/' + menu.url.action)"
                                v-html="menu.label">
                            </a>
                        </v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-menu>
            <v-spacer></v-spacer>
            <!--<v-menu-->
                <!--:nudge-width="100"-->
                <!--offset-y-->
            <!--&gt;-->
                <!--<v-toolbar-title-->
                    <!--slot="activator"-->
                    <!--style="width: 250px"-->
                <!--&gt;-->
                    <!--<span>OPA</span>-->
                    <!--<v-icon dark>arrow_drop_down</v-icon>-->
                <!--</v-toolbar-title>-->
                <!--<v-list v-for="perfil in perfisDisponiveis">-->
                    <!--<v-list-tile>-->
                        <!--{{perfil.gru_nome}}-->
                    <!--</v-list-tile>-->
                <!--</v-list>-->
            <!--</v-menu>-->
            <v-spacer></v-spacer>
            <v-layout row wrap align-center>
                <v-flex xs6>
                    <v-select
                        :items="perfisDisponiveis"
                        menu-props="auto"
                        hide-details
                        label="Select"
                        single-line
                    ></v-select>
                </v-flex>
            </v-layout>
            <v-spacer></v-spacer>
            <v-menu
                :nudge-width="100"
                offset-y
            >
                <v-toolbar-title
                    slot="activator"
                >
                    <span>Olá, Romulo</span>
                    <v-icon dark>arrow_drop_down</v-icon>
                </v-toolbar-title>
                <v-list>
                    <v-list-tile>
                        <v-list-tile-title >
                            Teste
                        </v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-menu>
        </v-toolbar>
    </div>
    <div v-else>
        Carregando...
    </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
    name: 'SlNav',
    components: {
    },
    props: [],
    data() {
        return {
            dados: this.dadosMenuAjax(),
            e1: 'Florida',
            e2: 'Texas',
            e3: null,
            e4: null,
            items: [
                { text: 'State 1' },
                { text: 'State 2' },
                { text: 'State 3' },
                { text: 'State 4' },
                { text: 'State 5' },
                { text: 'State 6' },
                { text: 'State 7' }
            ],
            states: [
                'Alabama', 'Alaska', 'American Samoa', 'Arizona',
                'Arkansas', 'California', 'Colorado', 'Connecticut',
                'Delaware', 'District of Columbia', 'Federated States of Micronesia',
                'Florida', 'Georgia', 'Guam', 'Hawaii', 'Idaho',
                'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky',
                'Louisiana', 'Maine', 'Marshall Islands', 'Maryland',
                'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi',
                'Missouri', 'Montana', 'Nebraska', 'Nevada',
                'New Hampshire', 'New Jersey', 'New Mexico', 'New York',
                'North Carolina', 'North Dakota', 'Northern Mariana Islands', 'Ohio',
                'Oklahoma', 'Oregon', 'Palau', 'Pennsylvania', 'Puerto Rico',
                'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee',
                'Texas', 'Utah', 'Vermont', 'Virgin Island', 'Virginia',
                'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
            ],
        };
    },
    computed: {
        ...mapGetters({
            dadosMenu: 'avaliacaoResultados/dadosMenu',
            perfisDisponiveis: 'avaliacaoResultados/perfisDisponiveis',
        }),
    },
    created() {
        this.buscarPerfisDisponiveis();
    },
    methods: {
        ...mapActions({
            dadosMenuAjax: 'avaliacaoResultados/dadosMenu',
            buscarPerfisDisponiveis: 'avaliacaoResultados/buscarPerfisDisponiveis',
        }),
    },
};
</script>
