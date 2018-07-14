<template>
    <div class="incentivo">
        <SidebarMenu :url-ajax="urlAjax"></SidebarMenu>
        <div class="container-fluid">
            <TituloPagina :titulo="$route.meta.title"></TituloPagina>
            <router-view></router-view>
        </div>
        <MenuSuspenso/>
    </div>
</template>

<script>
    import SidebarMenu from '@/components/SidebarMenu';
    import TituloPagina from '@/components/TituloPagina';
    import MenuSuspenso from '../components/MenuSuspenso';
    import {mapActions, mapGetters} from 'vuex';
    import {utils} from '@/mixins/utils';

    const URL_MENU = '/projeto/menu/obter-menu-ajax/idPronac/';

    export default {
        name: 'Index',
        components: {
            SidebarMenu,
            TituloPagina,
            MenuSuspenso
        },
        mixins: [utils],
        data() {
            return {
                urlAjax: URL_MENU + this.$route.params.idPronac,
            }
        },
        watch: {
            '$route' (to, from) {
                /**
                 * se o alterar apenas o parametro na url, o vue não recarrega o componente.
                 * aqui eu estou recarregando os dados do novo projeto se o idPronac for diferente
                 * */
                if (typeof to.params.idPronac != 'undefined'
                        && to.params.idPronac != from.params.idPronac) {
                    this.buscaProjeto(to.params.idPronac);
                    this.urlAjax = URL_MENU + to.params.idPronac;
                }
            }
        },
        created: function () {
            if (typeof this.$route.params.idPronac != 'undefined'
                    && Object.keys(this.dadosProjeto).length == 0) {
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
                dadosProjeto: 'projeto/projeto',
            }),
        }
    }
</script>
