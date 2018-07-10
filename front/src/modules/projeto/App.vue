<template>
    <div id="app">
        <SidebarMenu :url-ajax="urlAjax"></SidebarMenu>
        <div class="container-fluid">
            <TituloPagina :titulo="'Dados do projeto'"></TituloPagina> {{projeto222}}
            <router-view/>
        </div>
    </div>
</template>

<script>
    import SidebarMenu from '@/components/SidebarMenu';
    import TituloPagina from '@/components/TituloPagina';
    import { mapGetters } from 'vuex';

    export default {
        name: 'App',
        components: {
            SidebarMenu,
            TituloPagina
        },
        data() {
            return {
                urlAjax: '/projeto/menu/obter-menu-ajax/idPronac/' + this.$route.query.idPronac
            }
        },
        created: function () {
          console.log('tste', this.$route.query.idPronac)
        },
        computed: {
            ...mapGetters({
                projeto222: 'projeto/projeto',
            }),
        }
    }
</script>
