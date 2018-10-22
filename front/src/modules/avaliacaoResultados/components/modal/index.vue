<template>
    <div>
        <a @click="modalOpen('detalhe-item-custo');" aria-hidden="true" class="v-icon material-icons theme--light">visibility</a>

        <ModalTemplate v-if="modalVisible === 'detalhe-item-custo'" @close="fecharModal()">
            <template slot="header">Item</template>
            <template slot="body">
                A
            </template>
            <template slot="footer">
            </template>
        </ModalTemplate>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import ModalTemplate from '@/components/vuetify-modal';

    export default {
        name: 'index',
        // data() {
        //     return {
        //         DadoNr: '',
        //     };
        // },
        components: {
            ModalTemplate,
        },
        methods: {
            ...mapActions({
                // criarRegistro: 'foo/criarRegistro',
                modalOpen: 'modal/modalOpen',
                modalClose: 'modal/modalClose',
            }),
            fecharModal() {
                // eslint-disable-next-line
                $3('#modalTemplate').modal('close');
                this.modalClose();
            },
            // inputClear() {
            //     this.DadoNr = '';
            // },
        },
        computed: mapGetters({
            modalVisible: 'modal/default',
        }),
    };
</script>
