<template>
    <div id="projeto">
        Aqui o index de projeto

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
