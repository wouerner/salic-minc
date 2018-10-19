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
                <!--<v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>-->
                <v-btn icon large href="/principal">
                    <v-avatar size="38px">
                        <img
                            src="/public/img/logomarca.png"
                            alt="Ir para o in&iacute;cio"
                        >
                    </v-avatar>
                </v-btn>
                <v-toolbar-title class="ma-0 hidden-sm-and-down">Salic</v-toolbar-title>
                <v-spacer></v-spacer>

                <MenuPrincipal :dadosMenu="dadosMenu"></MenuPrincipal>

                <v-btn icon>
                <v-icon>message</v-icon>
                </v-btn>
                <InformacoesDaConta></InformacoesDaConta>
            </v-toolbar>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import MenuPrincipal from './MenuPrincipal';
    import InformacoesDaConta from './InformacoesDaConta';

    export default {
        name: 'SlNav',
        components: { InformacoesDaConta, MenuPrincipal },
        props: {
            dadosMenu: {},
        },
        data() {
            return {
                dados: this.dadosMenu,
                loadingUsuario: true,
            };
        },
        computed: {
            ...mapGetters({
                perfisDisponiveis: 'menuSuperior/perfisDisponiveis',
                usuarioAtivo: 'menuSuperior/usuarioAtivo',
                grupoAtivo: 'menuSuperior/grupoAtivo',
                grupoSelecionadoIndex: 'menuSuperior/grupoSelecionadoIndex',
            }),
            nomeUsuarioCompleto() {
                if (this.usuarioAtivo[0]) {
                    this.loadingUsuario = false;
                    return this.usuarioAtivo[0].usu_nome;
                }
                return '';
            },
            primeiraLetraNomeUsuario() {
                return this.nomeUsuarioCompleto.substr(0, 1);
            },
            nomeUsuario() {
                return this.nomeUsuarioCompleto.split(' ')[0];
            },
            cpfUsuario() {
                if (this.usuarioAtivo[0]) {
                    return this.usuarioAtivo[0].usu_identificacao;
                }
                return '';
            },
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
