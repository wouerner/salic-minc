<template>
    <div>
        <a
            @click="abrirModal('valor-transferidos');"
        >
            {{formatValue(valor)}}
        </a>
        <ModalTemplate v-if="modalVisible === 'valor-transferidos'" @close="fecharModal();">
            <template slot="header">
                <div style="float: left; margin-bottom: 20px;">
                    Transferencia de recursos entre projetos culturais
                </div>
            </template>
            <template class="striped" slot="body">
                <table>
                    <thead>
                        <tr>
                            <th colspan="2">Projeto Recebedor</th>
                            <th colspan="4">Projeto Transferidor</th>
                        </tr>
                        <tr>
                            <th>Pronac</th>
                            <th>Nome do Projeto</th>
                            <th>Pronac</th>
                            <th>Nome do Projeto</th>
                            <th>Dt. Recebimento</th>
                            <th>Vl. Recebido</th>
                        </tr>
                    </thead>
                    <tbody v-for="(valor, index) in valoresTransferidos" :key="index">
                        <tr>
                            <td>{{valor.idPronacTransferidor}}</td>
                            <td>{{valor.NomeProjetoTranferidor}}</td>
                            <td>{{valor.idPronacRecebedor}}</td>
                            <td>{{valor.NomeProjetoRecedor}}</td>
                            <td>{{valor.dtRecebimento}}</td>
                            <td>{{ valor.vlRecebido | formatarParaReal }}</td>
                        </tr>
                    </tbody>
                </table>
            </template>
            <template slot="footer"></template>
        </ModalTemplate>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import ModalTemplate from '@/components/modal';
    import planilhas from '@/mixins/planilhas';

    export default {
        name: 'ValorTransferido',
        props: { valor: String },
        components: {
            ModalTemplate,
        },
        mixins: [planilhas],
        methods: {
            ...mapActions({
                modalOpen: 'modal/modalOpen',
                modalClose: 'modal/modalClose',
                buscarValoresTransferidos: 'projeto/buscarValoresTransferidos',
            }),
            abrirModal(modalName) {
                this.buscarValoresTransferidos();
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
                valoresTransferidos: 'projeto/valoresTransferidos',
            }),
        },
    };
</script>
