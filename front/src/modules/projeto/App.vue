<template>
    <div id="app">
        <SidebarMenu :url-ajax="urlAjax"></SidebarMenu>
        <router-view/>
    </div>
</template>

<script>
    import SidebarMenu from '@/components/SidebarMenu';

    export default {
        name: 'App',
        components: {
            SidebarMenu,
        },
        data() {
            return {
                urlAjax: '/projeto/menu/obter-menu-ajax/idPronac/501eac548e7d4fa987034573abc6e179MjA2OTk2ZUA3NWVmUiEzNDUwb3RT'
            }
        }
    }
</script>
