<template>
    <div id="conteudo">
        <div class="row">
            <Proponente :cpf="projeto.CgcCPf"></Proponente>
        </div>
    </div>
</template>
<script>
    import Proponente from '@/modules/agente/Proponente';
    import {mapGetters} from 'vuex';

    export default {
        data() {
            return {
                links: '/default/consultardadosprojeto/planilha-orcamentaria?idPronac=' + this.$route.params.idPronac
            }
        },
        created() {
            console.log(this.$route);
        },
        components: {
            Proponente
        },
        computed: {
            ...mapGetters({
                projeto: 'projeto/projeto',
            }),
        }
    };
</script>

<style scoped>
    #conteudo {
        background-color: red;
    }

</style>
