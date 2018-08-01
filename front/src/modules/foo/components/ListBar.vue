<template>
    <div>
        <h1>Componente Bar</h1>
        <table>
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>DadoNr</th>
                    <th>Acoes</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(linha, index) in dadosTabela" :key="index">
                    <td>{{ linha.Codigo }}</td>
                    <td>{{ linha.DadoNr }}</td>
                    <td>
                        <router-link class="btn btn-primary" :to="{ name: 'UpdateBar', params: { data: { registro: linha } } }">Atualizar</router-link>
                    </td>
                </tr>
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
            atualizarRegistro: 'foo/atualizarRegistro',
        }),
    },
};
</script>
