<template>
    <div>
        <h1>Componente Bar</h1>
        <div>
            <h3>Exemplo Requisição Ajax</h3>
            <div v-for="(linha, index) in dadosTabela" :key="index">
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
import { mapActions, mapGetters } from 'vuex';

export default {
    name: 'Bar',
    data() {
        return {
            tabela: {},
            nome: 'Nome',
            sobrenome: 'Sobrenome',
        };
    },
    created() {
        this.obterDadosTabela();
    },
    computed: {
        ...mapGetters({
            dadosTabela: 'foo/dadosTabela',
        }),
        nomeCompleto() {
            return `${this.nome} ${this.sobrenome}`;
        },
    },
    methods: {
        ...mapActions({
            obterDadosTabela: 'foo/obterDadosTabela',
        }),
    },
};
</script>
