<template>
    <div>
        <h1>Atualiza Foo</h1>
        <div>
            {{this.registro}}
        </div>
    </div>
</template>

<script>
export default {
    name: 'UpdateBar',
    data() {
        return {
            registro: null,
        };
    },
    created() {
        this.registro = this.$route.params.registro;
    },
};
</script>
