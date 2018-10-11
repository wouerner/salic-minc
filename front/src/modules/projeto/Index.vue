<template>
    <div id="projeto">
        <router-view></router-view>

        <router-link :to="{ name: 'dadosprojeto', params: { idPronac: idPronac }}">
            Teste
        </router-link>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                idPronac: 121212,
            };
        },
    };
</script>
