<template>
    <div id="conteudo">
        <div id="proponente">
            <fieldset>
                <Identificacao></Identificacao>
            </fieldset>
            <fieldset>
                <Endereco></Endereco>
            </fieldset>
            <fieldset>
                <Telefone></Telefone>
            </fieldset>
            <fieldset>
                <Email></Email>
            </fieldset>
            <fieldset>
                <Natureza></Natureza>
            </fieldset>
            <fieldset>
                <Dirigente></Dirigente>
            </fieldset>
            <fieldset>
                <Procurador></Procurador>
            </fieldset>
        </div>
    </div>
</template>

<script>
    import Identificacao from "./Identificacao";
    import Endereco from "./Endereco";
    import Telefone from "./Telefone";
    import Email from "./Email";
    import Natureza from "./Natureza";
    import Dirigente from "./Dirigente";
    import Procurador from "./Procurador";
    import { mapGetters, mapActions } from "vuex";
    
    export default {
        components: {
            Identificacao,
            Endereco,
            Telefone,
            Email,
            Natureza,
            Dirigente,
            Procurador
        },
        created() {
            if (typeof this.$route.params.idPronac !== 'undefined' &&
                Object.keys(this.dadosProponente).length === 0) {
                this.buscaProponente(this.$route.params.idPronac);
            }
        },
        methods: {
            ...mapActions({
                buscaProponente: 'projeto/buscaProponente',
            }),
        },
        computed: {
            ...mapGetters({
                dadosProponente: 'projeto/proponente',
            }),
        }
    };
</script>