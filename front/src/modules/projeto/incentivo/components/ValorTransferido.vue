<template>
    <div>
        <a
            @click="abrirModal('valor-transferidos');"
        >
            {{formatValue(valor)}}
        </a>
        <ModalTemplate v-if="modalVisible === 'valor-transferidos'" @close="fecharModal();event.preventDefault()">
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
                            <th colspan="2">Projeto Transferidor</th>
                        </tr>
                        <tr>
                            <th>Pronac</th>
                            <th>Nome do Projeto</th>
                            <th>Pronac</th>
                            <th>Nome do Projeto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>data1</td>
                            <td>data2</td>
                            <td>data3</td>
                            <td>data4</td>
                        </tr>
                        <tr>
                            <td>data1</td>
                            <td>data2</td>
                            <td>data3</td>
                            <td>data4</td>
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

    export default {
        name: 'ValorTransferido',
        props: { valor: String },
        components: {
            ModalTemplate,
        },
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
            formatValue(value) {
                if (value === undefined) {
                    return '0,00';
                }

                if (value.indexOf('.') === -1) {
                    return this.formatValueWithoutCents(value);
                }

                return this.formatValueWithCents(value);
            },
            formatValueWithoutCents(value) {
                const valueWithCents = value.concat(',00');
                const result = valueWithCents.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                return result;
            },
            formatValueWithCents(value) {
                const valueParsedToFloat = parseFloat(value).toFixed(2);
                const valueParsedToString = valueParsedToFloat.toString();
                const valueChangedPointByComma = valueParsedToString.replace('.', ',');
                const result = valueChangedPointByComma.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                return result;
            },
        },
        computed: {
            ...mapGetters({
                modalVisible: 'modal/default',
            }),
        },
    };
</script>
