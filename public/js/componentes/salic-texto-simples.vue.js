Vue.component('salic-texto-simples', {
    template: `
        <div v-if="texto && texto.length > 0" v-html="texto"></div>
        <div v-else>N�o informado(a)</div>
    `,
    props: ['texto']
});