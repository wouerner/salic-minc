<template>
    <div v-if="texto && texto.length > 0" v-html="texto"></div>
    <div v-else> <CharsetEncode :texto="'N&atilde;o informado(a)'"></CharsetEncode></div>
</template>

<script>
    import CharsetEncode from '@/components/CharsetEncode';

    export default {
        name: 'SalicTextoSimples',
        props: ['texto'],
        components: {
            CharsetEncode
        }
    };
</script>
