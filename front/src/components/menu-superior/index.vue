<template>
    <div>
        <div v-if="dados">
            <v-toolbar
                app
                dense
                dark
                color="primary"
                :clipped-left="$vuetify.breakpoint.mdAndUp"
                fixed
                height="50px"
            >
                <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
                <v-btn icon large href="/principal">
                    <v-avatar size="38px">
                        <img
                            src="/public/img/logomarca.png"
                            alt="Ir para o in&iacute;cio"
                        >
                    </v-avatar>
                </v-btn>
                <v-toolbar-title class="ma-0">
                    <span class="hidden-sm-and-down">Salic</span>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <!--<v-btn icon>-->
                    <!--<v-icon>apps</v-icon>-->
                <!--</v-btn>-->
                <v-btn icon>
                    <v-icon>message</v-icon>
                </v-btn>
                <v-btn icon>
                    <v-icon>notifications</v-icon>
                </v-btn>
                <v-btn icon large>
                    <v-avatar size="32px" tile>
                       <h1>R</h1>
                    </v-avatar>
                </v-btn>
                <!--<v-menu-->
                    <!--:nudge-width="100"-->
                    <!--v-for="(item, index) in dadosMenu"-->
                    <!--:key="item.id"-->
                    <!--offset-y-->
                <!--&gt;-->
                    <!--<v-toolbar-title slot="activator">-->
                        <!--<v-btn flat>-->
                            <!--<span v-html="item.label"></span>-->
                            <!--<v-icon right dark>arrow_drop_down</v-icon>-->
                        <!--</v-btn>-->
                    <!--</v-toolbar-title>-->
                    <!--<v-list v-for="(menu, index) in item.menu" :key="index">-->
                        <!--<v-list-tile>-->
                            <!--<v-list-tile-title>-->
                                <!--<a-->
                                    <!--:href="('/' + menu.url.module + '/' + menu.url.controller + '/' + menu.url.action)"-->
                                    <!--v-html="menu.label">-->
                                <!--</a>-->
                            <!--</v-list-tile-title>-->
                        <!--</v-list-tile>-->
                    <!--</v-list>-->
                <!--</v-menu>-->
                <!--<v-spacer></v-spacer>-->

                <!--<v-menu :nudge-width="100" offset-y>-->
                    <!--<v-toolbar-title-->
                        <!--v-if="perfisDisponiveis && perfisDisponiveis[grupoSelecionadoIndex].orgao_sigla_autorizada"-->
                        <!--slot="activator"-->
                    <!--&gt;-->
                        <!--<span>{{perfisDisponiveis[grupoSelecionadoIndex].orgao_sigla_autorizada}} - {{perfisDisponiveis[grupoSelecionadoIndex].nome_grupo}}</span>-->
                        <!--<v-icon dark>arrow_drop_down</v-icon>-->
                    <!--</v-toolbar-title>-->
                    <!--<v-toolbar-title-->
                        <!--v-else-->
                        <!--slot="activator"-->
                    <!--&gt;-->
                        <!--<span>{{perfisDisponiveis[grupoSelecionadoIndex].nome_grupo}}</span>-->
                        <!--<v-icon dark>arrow_drop_down</v-icon>-->
                    <!--</v-toolbar-title>-->
                    <!--<v-list class="scrollable">-->
                        <!--<v-list-tile v-for="(perfil, index) in perfisDisponiveis" :key="index">-->
                            <!--<div v-if="perfil.orgao_sigla_autorizada" @click="trocarPerfil(perfil)" style="cursor:pointer;">-->
                                <!--{{perfil.orgao_sigla_autorizada}} - {{perfil.nome_grupo}}-->
                            <!--</div>-->
                            <!--<div v-else @click="trocarPerfil(perfil)" style="cursor:pointer;">-->
                                <!--{{perfil.nome_grupo}}-->
                            <!--</div>-->
                        <!--</v-list-tile>-->
                    <!--</v-list>-->
                <!--</v-menu>-->
                <!--<v-spacer></v-spacer>-->
                <!--<v-menu-->
                    <!--:nudge-width="100"-->
                    <!--offset-y-->
                <!--&gt;-->
                    <!--<v-toolbar-title-->
                        <!--slot="activator"-->
                    <!--&gt;-->
                        <!--<span>Olá, Romulo</span>-->
                        <!--<v-icon dark>arrow_drop_down</v-icon>-->
                    <!--</v-toolbar-title>-->
                    <!--<v-list>-->
                        <!--<v-list-tile>-->
                            <!--<v-list-tile-title>-->
                                <!--Teste-->
                            <!--</v-list-tile-title>-->
                        <!--</v-list-tile>-->
                    <!--</v-list>-->
                <!--</v-menu>-->
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
        props: {
            dadosMenu: {},
        },
        data() {
            return {
                dados: this.dadosMenu,
            };
        },
        computed: {
            ...mapGetters({
                perfisDisponiveis: 'menuSuperior/perfisDisponiveis',
                usuarioAtivo: 'menuSuperior/usuarioAtivo',
                grupoAtivo: 'menuSuperior/grupoAtivo',
                grupoSelecionadoIndex: 'menuSuperior/grupoSelecionadoIndex',
            }),
        },
        created() {
            this.buscarPerfisDisponiveis();
        },
        methods: {
            ...mapActions({
                buscarPerfisDisponiveis: 'menuSuperior/buscarPerfisDisponiveis',
                alterarPerfil: 'menuSuperior/alterarPerfil',
            }),
            trocarPerfil(perfil) {
                this.alterarPerfil(perfil);
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
