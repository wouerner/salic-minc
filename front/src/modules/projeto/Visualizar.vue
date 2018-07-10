<template>
    <div>
        <div class="container-fluid">
            <TituloPagina :titulo="'Dados do projeto'"></TituloPagina>
            <div id="conteudo" class="row">
                <div class="col s2">
                    testetete
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import TituloPagina from '@/components/TituloPagina';

    export default {
        name: "Visualizar",
        components: {
            TituloPagina
        }
    }
</script>

<style scoped>

</style>