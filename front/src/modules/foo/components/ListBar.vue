<template>
    <div>
        <h1>Componente Bar</h1>
        <Modal></Modal>
        <table>
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>DadoNr</th>
                    <th>Acoes</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(record, index) in dadosTabela" :key="index">
                    <td>{{ record.Codigo }}</td>
                    <td>{{ record.DadoNr }}</td>
                    <td>
                        <router-link :to="{ name: 'UpdateBar', params: { id: record.Codigo } }">
                            <a class="btn btn-primary" @click="setActiveRecord(record)">
                                Atualizar
                            </a>
                        </router-link>
                        <a class="btn btn-danger" @click="removeConfirm(record)">
                            Remover
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>

        <router-link :to="{ name: 'CreateBar' }">Criar</router-link>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Modal from '@/components/modal';

export default {
    name: 'ListBar',
    created() {
        this.obterDadosTabela();
    },
    components: {
        Modal,
    },
    computed: {
        ...mapGetters({
            dadosTabela: 'foo/dadosTabela',
        }),
    },
    methods: {
        ...mapActions({
            obterDadosTabela: 'foo/obterDadosTabela',
            setActiveRecord: 'foo/setActiveRecord',
            removeRecord: 'foo/removeRecord',
        }),
        removeConfirm(record) {
            const response = confirm('Deseja remover esse registro?');

            if (response) {
                this.removeRecord(record);
            }
        },
    },
};
</script>
