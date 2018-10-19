<template>
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
            <Logo></Logo>
            <v-toolbar-title class="ma-0 hidden-sm-and-down">Salic</v-toolbar-title>
            <v-spacer></v-spacer>
            <MenuPrincipal :dadosMenu="dadosMenu"></MenuPrincipal>
            <Solicitacoes></Solicitacoes>
            <InformacoesDaConta></InformacoesDaConta>
        </v-toolbar>
    </div>
</template>

<script>
    import MenuPrincipal from './MenuPrincipal';
    import InformacoesDaConta from './InformacoesDaConta';
    import Solicitacoes from './Solicitacoes';
    import Logo from './Logo';

    export default {
        name: 'Cabecalho',
        components: { InformacoesDaConta, MenuPrincipal, Solicitacoes, Logo },
        props: {
            dadosMenu: {},
        },
        data() {
            return {
                dados: this.dadosMenu,
            };
        },
    };
</script>
