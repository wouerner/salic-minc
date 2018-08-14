<template>
    <div>
        <a
            @click="abrirModal('valor-transferidos');"
        >
            TODO
        </a>
        <ModalTemplate v-if="modalVisible === 'valor-transferidos'" @close="fecharModal()">
            <template slot="header"></template>
            <template slot="body"></template>
            <template slot="footer"></template>
        </ModalTemplate>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import ModalTemplate from '@/components/modal';

    export default {
        name: 'ValorTransferido',
        props: ['registroAtivo'],
        components: {
            ModalTemplate,
        },
        methods: {
            ...mapActions({
                modalOpen: 'modal/modalOpen',
                modalClose: 'modal/modalClose',
            }),
            abrirModal(modalName) {
                // eslint-disable-next-line
                $3('#modalTemplate').modal('open');
                this.modalOpen(modalName);
            },
            fecharModal() {
                // eslint-disable-next-line
                $3('#modalTemplate').modal('close');
                this.modalClose();
            },
        },
        computed: {
            ...mapGetters({
                modalVisible: 'modal/default',
            }),
        },
    };
</script>
