<template>
    <div id="conteudo">
        <div class="row">
            <CarregarTemplateAjax :urlAjax="links"></CarregarTemplateAjax>
        </div>
    </div>
</template>
<script>
    import CarregarTemplateAjax from '@/components/CarregarTemplateAjax';

    export default {
        data() {
            return {
                links: '/default/consultardadosprojeto/planilha-orcamentaria?idPronac=' + this.$route.params.idPronac
            }
        },
        components: {
            CarregarTemplateAjax
        }
    };
</script>