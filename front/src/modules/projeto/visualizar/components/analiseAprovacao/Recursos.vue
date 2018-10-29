<template>
    <div id="conteudo">

    </div>
</template>
<script>

    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: 'Recursos',
        props: ['idPronac'],
        data() {
            return {
                dados: {
                    type: Object,
                    default() {
                        return {};
                    },
                },
            };
        },
        mounted() {
            if (typeof this.$route.params.idPronac !== 'undefined') {
                this.buscar_dados();
            }
        },
        methods: {
            buscar_dados() {
                const self = this;
                const idPronac = self.$route.params.idPronac,
                /* eslint-disable */
                $3.ajax({
                    url: '/analise/recursos-rest/index/idPronac/' + idPronac,
                }).done(function (response) {
                    self.dados = response.data;
                });
            },
        },
    };
</script>

