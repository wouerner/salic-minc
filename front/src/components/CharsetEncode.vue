<template>
    <div v-if="texto && texto.length > 0" v-html="messageFormated"></div>
    <div v-else>N&atilde;o informado(a)</div>
</template>

<script>
    export default {
        name: 'CharsetEncode',
        props: ['texto'],
        computed: {
            messageFormated: function() {
                return decodeURI(this.texto, 'iso-8859-1');
            },
        },
    };
</script>
