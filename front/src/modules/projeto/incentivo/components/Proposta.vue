<template>
    <slProposta :idpreprojeto="dadosProjeto.idProjeto"></slProposta>
</template>
<script>
    import slProposta from '@/modules/proposta/visualizar/components/slProposta';
    import { mapGetters } from 'vuex';

    export default {
        components: {
            slProposta,
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
            }),
        }
    }
</script>