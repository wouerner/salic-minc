<template>
    <v-container fluid>
       <TabelaProjetos
               :analisar="true"
       ></TabelaProjetos>
    </v-container>
</template>

<script>
import TabelaProjetos from './TabelaProjetos';

export default {
    name: 'Painel',
    created() {
        this.obterDadosTabelaTecnico();
    },
    data() {
        return {
        };
    },
    components: {
        TabelaProjetos,
    },
};
</script>
