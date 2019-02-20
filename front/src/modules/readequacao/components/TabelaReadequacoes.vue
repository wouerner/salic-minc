<template>
    <div>
        <v-data-table
            :headers="head"
            :items="dados.items"
            :pagination.sync="pagination"
            :search="search"
            hide-actions
        >
          
            <template
                slot="items"
                slot-scope="props">
                <td>{{ props.index+1 }}</td>
                <td class="text-xs-right">
                    <div>
                        <v-btn
                            :href="'/projeto/#/'+ props.item.idPronac"
                            flat>{{ props.item.idPronac }}
                        </v-btn>
                    </div>
                </td>
                <td class="text-xs-left">{{ props.item.idTipoReadequacao }}</td>
                <td class="text-xs-center">{{ props.item.dtSolicitacao }}</td>
                <td class="text-xs-center">{{ props.item.idDocumento }}</td>
                <td class="text-xs-center">{{ props.item.dsJustificativa }}</td>
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
                    text: 'idPronac',
                    value: 'idPronac',
                },
                {
                    text: 'Tipo de Readequação',
                    value: 'idTipoReadequacao',
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
