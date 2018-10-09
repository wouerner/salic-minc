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
                            <v-list-tile-title>
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
                            <v-list-tile-title>
                                Teste
                            </v-list-tile-title>
                        </v-list-tile>
                    </v-list>
                </v-menu>
            </v-toolbar>
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
                            <v-list-tile-title>
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
                <!--<v-layout row wrap align-center>-->
                    <!--<v-flex xs6>-->
                        <!--<v-select-->
                            <!--:items="perfisDisponiveis"-->
                            <!--menu-props="auto"-->
                            <!--hide-details-->
                            <!--height="40px"-->
                            <!--full-width-->
                            <!--:value="perfisDisponiveis[0]"-->
                            <!--single-line-->
                        <!--&gt;</v-select>-->
                    <!--</v-flex>-->
                <!--</v-layout>-->
                <v-menu
                    :nudge-width="100"
                    offset-y
                >
                    <v-toolbar-title
                        slot="activator"
                    >
                        <span>{{perfisDisponiveis[0]}}</span>
                        <v-icon dark>arrow_drop_down</v-icon>
                    </v-toolbar-title>
                    <v-list class="scrollable">
                        <v-list-tile v-for="(perfil, index) in perfisDisponiveis" :key="index">
                            <div @click="trocarPerfil(perfil)" style="cursor:pointer;">{{perfil}}</div>
                        </v-list-tile>
                    </v-list>
                </v-menu>
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
                            <v-list-tile-title>
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
        components: {},
        props: [],
        data() {
            return {
                dados: this.dadosMenuAjax(),
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
            trocarPerfil(perfil) {
                console.log('chegando');
                console.log(perfil);
            },
        },
    };
</script>

<style>
    .scrollable {
        width: 500px;
        height: 750px;
        overflow: scroll;
    }
</style>
