<template>
    <div id="conteudo" class="row">
        <div class="col s2">
            Pronac {{$route.query.idPronac}}
            {{projeto222}}
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';

    export default {
        created() {
            this.buscaProjeto(this.$route.query.idPronac);
        },
        methods: {
            ...mapActions({
                buscaProjeto: 'projeto/buscaProjeto',
            }),
        },
        computed: {
            ...mapGetters({
                projeto222: 'projeto/projeto',
            }),
        },
    };
</script>