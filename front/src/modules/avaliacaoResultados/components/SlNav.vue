<template>
    <div>
        <MenuSuperior :dadosMenu="dadosMenu"></MenuSuperior>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import MenuSuperior from '@/components/menu-superior';

    export default {
        name: 'SlNav',
        components: {
            MenuSuperior,
        },
        // data() {
        //     return {
        //         dados: this.dadosMenuAjax(),
        //     };
        // },
        computed: {
            ...mapGetters({
                dadosMenu: 'avaliacaoResultados/dadosMenu',
            }),
        },
        created() {
            this.dadosMenuAjax();
        },
        methods: {
            ...mapActions({
                dadosMenuAjax: 'avaliacaoResultados/dadosMenu',
                // buscarPerfisDisponiveis: 'avaliacaoResultados/buscarPerfisDisponiveis',
                // alterarPerfil: 'avaliacaoResultados/alterarPerfil',
            }),
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
