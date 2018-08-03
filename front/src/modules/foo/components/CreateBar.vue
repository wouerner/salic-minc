<template>
    <div>
        <a class="btn btn-primay" @click="modalOpen('create-bar')">
            Criar
        </a>
        <ModalTemplate v-if="modalVisible === 'create-bar'" @close="fecharModal()">
            <template slot="header">Criar Bar</template>
            <template slot="body">
                <form action="">
                    <p>
                        <label for="DadoNr">DadoNr</label>
                        <input type="text" name="DadoNr" id="DadoNr" v-model="DadoNr">
                    </p>
                    <a @click="criarRegistro({ DadoNr });fecharModal();">Salvar</a>
                </form>
            </template>
        </ModalTemplate>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import ModalTemplate from '@/components/modal';

export default {
    name: 'CreateBar',
    data() {
        return {
            DadoNr: null,
        };
    },
    components: {
        ModalTemplate,
    },
    methods: {
        ...mapActions({
            criarRegistro: 'foo/criarRegistro',
            modalOpen: 'modal/modalOpen',
            modalClose: 'modal/modalClose',
        }),
        fecharModal() {
            // eslint-disable-next-line
            $3('#modalTemplate').modal('close');
            this.modalClose();
        },
    },
    computed: mapGetters({
        modalVisible: 'modal/default',
    }),
};
</script>
