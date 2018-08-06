<template>
    <div>
        <h1>Componente Bar</h1>
        <CreateBar/>
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
                        <!-- <router-link :to="{ name: 'UpdateBar', params: { id: record.Codigo } }">
                            <a class="btn btn-primary" @click="setActiveRecord(record)">
                                Atualizar
                            </a>
                        </router-link> -->
                        <UpdateBar :activeRecord="record"/>
                        <a class="btn btn-danger" @click="removeConfirm(record)">
                            Remover
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Modal from '@/components/modal';
import CreateBar from './CreateBar';
import UpdateBar from './UpdateBar';

export default {
    name: 'ListBar',
    created() {
        this.obterDadosTabela();
    },
    components: {
        Modal,
        CreateBar,
        UpdateBar,
    },
    computed: {
        ...mapGetters({
            dadosTabela: 'foo/dadosTabela',
            modalVisible: 'modal/default',
        }),
    },
    methods: {
        ...mapActions({
            obterDadosTabela: 'foo/obterDadosTabela',
            setActiveRecord: 'foo/setActiveRecord',
            removeRecord: 'foo/removeRecord',
            modalOpen: 'modal/modalOpen',
            modalClose: 'modal/modalClose',
        }),
        removeConfirm(record) {
            const currentConfirm = confirm;
            const trueResponse = currentConfirm('Deseja remover esse registro?');

            if (trueResponse) {
                this.removeRecord(record);
            }
        },
    },
};
</script>
