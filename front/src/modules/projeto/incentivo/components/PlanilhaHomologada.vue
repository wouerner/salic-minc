<template>
    <div id="conteudo">
        <div class="row">
            <CarregarTemplateAjax :urlAjax="url"></CarregarTemplateAjax>
        </div>
    </div>
</template>
<script>
    import CarregarTemplateAjax from '@/components/CarregarTemplateAjax';

    export default {
        data() {
            return {
                url: '/default/consultardadosprojeto/planilha-orcamentaria-aprovada?idPronac=' + this.$route.params.idPronac
            }
        },
        components: {
            CarregarTemplateAjax
        }
    };
</script>