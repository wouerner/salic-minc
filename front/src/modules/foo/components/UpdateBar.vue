<template>
    <div>
        <h1>Atualiza Foo</h1>
        <div class="form-group">
            <label for="record">DadoNr</label>
            <input type="text" name="DadoNr" :value="record.DadoNr" @input="buildRecord"/>
        </div>
        <router-link :to="{ name: 'ListBar' }">
            <a @click="checkChangesAndUpdate()">
                Atualizar
            </a>
        </router-link>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

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
    created() {
        this.currentRecord.Codigo = this.record.Codigo;
        this.currentRecord.DadoNr = this.record.DadoNr;
    },
    methods: {
        ...mapActions({
            updateRecord: 'foo/updateRecord',
        }),
        buildRecord(event) {
            const DadoNr = event.target.value;
            this.currentRecord.DadoNr = DadoNr;
        },
        checkChangesAndUpdate() {
            if (this.currentRecord !== this.record) {
                this.updateRecord(this.currentRecord);
            }
        },
    },
    computed: {
        ...mapGetters({
            record: 'foo/record',
        }),
    },
};
</script>
