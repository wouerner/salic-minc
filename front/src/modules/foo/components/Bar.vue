<template>
    <div>
        <h1>Componente Bar</h1>
        <div>
            <h3>Exemplo Requisição Ajax</h3>
            <div v-for="linha in tabela">
                <div>{{ linha }}</div>
            </div>
        </div>
        <div class="card">
            <h3>Exemplo Computed</h3>
            <input v-model="nome" type="text"/>
            <input v-model="sobrenome" type="text"/>
            <h1 v-html="nomeCompleto"></h1>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Bar',
        data: function () {
            return {
                tabela: {},
                nome: 'Nome',
                sobrenome: 'Sobrenome'
            }
        },
        created: function () {
            this.obterDadosTabela();
        },
        computed: {
            nomeCompleto : function () {
                return this.nome + ' ' + this.sobrenome
            }
        },
        methods: {
            obterDadosTabela: function () {
                let self = this;
                $3.ajax({
                    url: '/foo/foo-rest',
                    data: {
                        // id: self.$router.params.id
                        // id: 2
                    },
                })
                .done((response) => {
                    self.tabela = response.data;
                    console.log(response);
                });

            }
        }
    };
</script>