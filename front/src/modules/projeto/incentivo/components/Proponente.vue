<template>
    <div id="conteudo">
        <div class="row">
            <Proponente :cpf="dadosProjeto.CgcCPf"></Proponente>
        </div>
    </div>
</template>
<script>
    import Proponente from '@/modules/agente/Proponente';
    import { mapGetters } from 'vuex';

    export default {
        data() {
            return {
                links: `/default/consultardadosprojeto/planilha-orcamentaria?idPronac=${this.$route.params.idPronac}`,
            };
        },
        components: {
            Proponente,
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
            }),
        },
    };
</script>
