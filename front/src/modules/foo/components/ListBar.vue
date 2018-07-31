<template>
    <div>
        <h1>Componente Bar</h1>
        <table>
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>DadoNr</th>
                </tr>        
            </thead>
            <tbody>
                <div v-for="(linha, index) in dadosTabela" :key="index">
                    <tr>
                        <td>{{ linha.Codigo }}</td>
                        <td>{{ linha.DadoNr }}</td>
                    </tr>
                </div>
            </tbody>
        </table>

        <router-link :to="{ name: 'CreateBar', params: {} }">Criar</router-link>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
    name: 'ListBar',
    created() {
        this.obterDadosTabela();
    },
    computed: {
        ...mapGetters({
            dadosTabela: 'foo/dadosTabela',
        }),
    },
    methods: {
        ...mapActions({
            obterDadosTabela: 'foo/obterDadosTabela',
        }),
    },
};
</script>
