<template>
    <div>
        <v-data-table
            :headers="head"
            :items="dadosReadequacao.items"
            :pagination.sync="pagination"
            hide-actions
        >
            <template
                slot="items"
                slot-scope="props">
                <td>{{ props.index+1 }}</td>
                <td class="text-xs-left">{{ props.item.dsTipoReadequacao }}</td>
                <td class="text-xs-center">{{ props.item.dtSolicitacao }}</td>
                <td class="text-xs-center">{{ props.item.idDocumento }}</td>
                <td
                    v-if="componentes.acoes"
                    class="text-xs-center"
                >
                    <v-layout
                        row
                        justify-center
                        align-end
                    >
                        <template
                            v-for="(componente, index) in componentes.acoes"
                            d-inline-block>
                            <component
                                :key="index"
                                :obj="props.item"
                                :is="componente"
                                :dados-readequacao="props.item"
                                :dados-projeto="dadosProjeto"
                                :bind-click="bindClick"
                                @on:excluir-readequacao="excluirReadequacao(props.item.idReadequacao)"
                                @on:atualizar-readequacao="atualizarReadequacao(props.item.idReadequacao)"
                            />
                        </template>
                    </v-layout>
                </td>
            </template>
            <template slot="no-data">
                <v-alert
                    :value="true"
                    color="error"
                    icon="warning">
                    Nenhum dado encontrado ¯\_(ツ)_/¯
                </v-alert>
            </template>
        </v-data-table>
    </div>
</template>

<script>

export default {
    name: 'TabelaReadequacoes',
    props: {
        dadosReadequacao: { type: Object, default: () => {} },
        componentes: { type: Object, default: () => {} },
        dadosProjeto: { type: Object, default: () => {} },
        itemEmEdicao: { type: Number, default: 0 },
    },
    data() {
        return {
            pagination: {
                rowsPerPage: 10,
            },
            head: [
                {
                    text: '#',
                    align: 'left',
                    sortable: false,
                    value: 'numero',
                },
                {
                    text: 'Tipo de Readequação',
                    value: 'dsTipoReadequacao',
                },
                {
                    text: 'Data da Solicitação',
                    align: 'center',
                    value: 'dtSolicitacao',
                },
                {
                    text: 'Arquivo',
                    align: 'center',
                    value: 'idDocumento',
                },
                {
                    text: 'Ações',
                    align: 'center',
                    value: '',
                },
            ],
            bindClick: 0,
        };
    },
    computed: {},
    watch: {
        dadosReadequacao: {
            handler() {
                if (this.itemEmEdicao > 0) {
                    console.log(this.itemEmEdicao);
                    // if (this.itemEmEdicao.hasOwnProperty('idReadequacao')) {
                    // console.log(this.itemEmEdicao);
                    // somente no caso de inserção. Update dá problema
                    // const indexItemInserido = this.dadosReadequacao.items.indexOf(this.itemEmEdicao');
                    // console.log(this.dadosReadequacao);
                    // console.log(indexItemInserido);
                    // const idReadequacaoInserido = this.dadosReadequacao.items[indexItemInserido].idReadequacao;
                    // if (indexItemInserido > -1) {
                    // this.bindClick = idReadequacaoInserido;
                    // }
                    // }
                }
            },
            deep: true,
        },
    },
    methods: {
        excluirReadequacao(idReadequacao) {
            this.$emit('excluir-readequacao', { idReadequacao });
        },
        atualizarReadequacao(idReadequacao) {
            this.$emit('atualizar-readequacao', { idReadequacao });
        },
    },
};
</script>
