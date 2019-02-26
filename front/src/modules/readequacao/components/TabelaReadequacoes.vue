<template>
    <div>
        <v-data-table
            :headers="head"
            :items="dados.items"
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
                <td class="text-xs-center">
                <v-layout 
                    row 
                    justify-center
                    align-end
                >
                    <template
                        v-for="(component, index) in componentes.acoes"
                        d-inline-block>
                        <component
                            :key="index"
                            :obj="props.item"
                            :is="component"
                            :idReadequacao="props.item.idReadequacao"
                            :usuario="componentes.usuario"
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
        dados: { type: Object, default: () => {} },
        componentes: { type: Object, default: () => {} },
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

        };
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
