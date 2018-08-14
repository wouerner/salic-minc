<template>
    <div class="tabelas">
            <div class="row">
                <slTableEasy v-bind:dados="dado"></slTableEasy>
            </div>
    </div>
</template>
<script>
export default {
    name: 'slPropostaFontesDeRecursos',
    data: function () {
        return {
            dado: []
        }
    },
    props: ['idpreprojeto'],
    mounted: function () {
        if (typeof this.idpreprojeto != 'undefined') {
            this.fetch(this.idpreprojeto);
        }
    },
    watch: {
        idpreprojeto: function (value) {
            this.fetch(value);
        }
    },
    methods: {
        fetch: function (id) {
            if (id) {
                let vue = this;

                $3.ajax({
                    url: '/proposta/visualizar/obter-fonte-de-recurso/idPreProjeto/' + id
                }).done(function (response) {
                    vue.dado = response.data;
                });

            }
        }
    }
};
</script>