Vue.component('sl-planilha-button', {
    props: [
        'typeButton',
    ],
    template: `
        <a class="btn red" title="Comprovar item" v-bind:href="typeButton">
            <i class="material-icons small">gavel</i>
        </a>
    `
});
