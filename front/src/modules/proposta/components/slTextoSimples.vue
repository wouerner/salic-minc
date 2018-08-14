<template>
    <div>
        <div v-if="texto && texto.length > 0" v-html="texto"></div>
        <div v-else>Não informado(a)</div>
    </div>
</template>
<script>
export default {
    name: 'slTextoSimples',
    props: ['texto']
}
</script>