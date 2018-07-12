<template>
    <div id="app" style="overflow: hidden">
        <SidebarMenu :url-ajax="urlAjax"></SidebarMenu>
        <div class="container-fluid">
            <TituloPagina :titulo="$route.meta.title"></TituloPagina>
            <keep-alive>
                <router-view></router-view>
            </keep-alive>
        </div>
    </div>
</template>

<script>
    import SidebarMenu from '@/components/SidebarMenu';
    import TituloPagina from '@/components/TituloPagina';
    import {mapActions, mapGetters} from 'vuex';

    export default {
        name: 'Index',
        components: {
            SidebarMenu,
            TituloPagina
        },
        data() {
            return {
                urlAjax: '/projeto/menu/obter-menu-ajax/idPronac/' + this.$route.params.idPronac
            }
        },
        created: function () {
            if (typeof this.$route.params.idPronac != 'undefined'
                && Object.keys(this.projeto).length == 0) {
                this.buscaProjeto(this.$route.params.idPronac);
            }
        },
        methods: {
            ...mapActions({
                buscaProjeto: 'projeto/buscaProjeto',
            }),
        },
        computed: {
            ...mapGetters({
                projeto: 'projeto/projeto',
            }),
        }
    }
</script>
