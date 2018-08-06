<template>
    <div>
        <a class="btn btn-primary" @click="modalOpen('update-bar');setActiveRecord(activeRecord);">
            Atualizar
        </a>
        <ModalTemplate v-if="modalVisible === 'update-bar'" @close="fecharModal()">
            <template slot="header">Atualizar Bar</template>
            <template slot="body">
                <form action="">
                    <label for="record">DadoNr</label>
                    <input type="text" name="DadoNr" :value="record.DadoNr" @input="buildRecord"/>
                </form>
            </template>
            <template slot="footer">
                <a class="btn btn-danger" @click="fecharModal();$event.preventDefault()">Fechar</a>
                <a class="btn btn-primary" @click="checkChangesAndUpdate();fecharModal();">Atualizar</a>
            </template>
        </ModalTemplate>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import ModalTemplate from '@/components/modal';

export default {
    name: 'UpdateBar',
    data() {
        return {
            currentRecord: {
                Codigo: '',
                DadoNr: '',
            },
        };
    },
    props: ['activeRecord'],
    components: {
        ModalTemplate,
    },
    methods: {
        ...mapActions({
            updateRecord: 'foo/updateRecord',
            setActiveRecord: 'foo/setActiveRecord',
            modalOpen: 'modal/modalOpen',
            modalClose: 'modal/modalClose',
        }),
        buildRecord(event) {
            const DadoNr = event.target.value;
            this.currentRecord.DadoNr = DadoNr;
            this.currentRecord.Codigo = this.record.Codigo;
        },
        checkChangesAndUpdate() {
            if (this.currentRecord !== this.record) {
                this.updateRecord(this.currentRecord);
            }
        },
        fecharModal() {
            // eslint-disable-next-line
            $3('#modalTemplate').modal('close');
            this.modalClose();
        },
    },
    computed: {
        ...mapGetters({
            record: 'foo/record',
            modalVisible: 'modal/default',
        }),
    },
};
</script>
