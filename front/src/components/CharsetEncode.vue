<template>
    <div v-if="texto && texto.length > 0" v-html="textFormated"></div>
    <div v-else v-html="textNotInformed"></div>
</template>

<script>
    export default {
        name: 'CharsetEncode',
        props: ['texto'],
        computed: {
            textFormated: function() {
                return decodeURI(this.texto, 'iso-8859-1');
            },
            textNotInformed: function() {
                return decodeURI('N&atilde;o informado(a)', 'iso-8859-1');
            },
        },
    };
</script>
