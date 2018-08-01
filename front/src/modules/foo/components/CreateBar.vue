<template>
    <div>
        <h1>Cria Foo</h1>
        <form action="">
            <p>
                <label for="DadoNr">DadoNr</label>
                <input type="text" name="DadoNr" id="DadoNr" v-model="DadoNr">
            </p>
            <a @click="criarRegistro({ DadoNr })">Salvar</a>
        </form>
    </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
    name: 'CreateBar',
    data() {
        return {
            DadoNr: null,
        };
    },
    methods: {
        ...mapActions({
            criarRegistro: 'foo/criarRegistro',
        }),        
    },
};
</script>
