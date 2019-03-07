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
                <td class="text-xs-center">{{ props.item.dsJustificativa }}</td>
                <td class="text-xs-center" v-if="componentes.acoes">
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
                            :dadosReadequacao="props.item"
                            :dadosProjeto="dadosProjeto"
                            :bindClick="bindClick"
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
import { mapActions, mapGetters } from 'vuex';

export default {
    name: 'TabelaReadequacoes',
    props: {
        dadosReadequacao: { type: Object, default: () => {} },
        componentes: { type: Object, default: () => {} },
	    dadosProjeto: { type: Object, default: () => {} },
        editarItem: { },
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
                    text: 'Justificativa',
                    align: 'center',
                    value: 'dsJustificativa',
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
    watch: {
        dadosReadequacao: {
            handler(value) {
                if (typeof this.editarItem !== 'undefined') {
                    if (this.editarItem.hasOwnProperty('idReadequacao')) {
                        const indexItemInserido = this.dadosReadequacao.items.indexOf(this.editarItem);
                        const idReadequacaoInserido = this.dadosReadequacao.items[indexItemInserido].idReadequacao;
                        
                        if (indexItemInserido > -1) {
                            this.bindClick = idReadequacaoInserido;
                        }
                    }
                }
            },
            deep: true,
        },
    },
    computed: {
        ...mapGetters({
        }),
    },
    methods: {
        ...mapActions({
        }),
    },
};
</script>
