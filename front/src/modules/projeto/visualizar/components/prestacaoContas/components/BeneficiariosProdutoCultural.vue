<template>
    <div>
        <v-card>
            <v-card-title>
                <h6>BENEFICIÁRIOS DE PRODUTO CULTURAL</h6>
            </v-card-title>
        <v-data-table
                :pagination.sync="pagination"
                :headers="headers"
                :items="dados.planosCadastrados"
                class="elevation-1 container-fluid"
        >
            <template
                    slot="items"
                    slot-scope="props">
                <td class="text-xs-left">{{ props.item.Produto }}</td>
                <td class="text-xs-left">{{ props.item.CNPJCPF }}</td>
                <td class="text-xs-left">{{ props.item.CNPJCPF | cnpjFilter }}</td>
                <td class="text-xs-left">{{ props.item.Beneficiario }}</td>
                <td class="text-xs-right">{{ props.item.qtRecebida }}</td>
                <td class="text-xs-left">
                    <v-btn
                            :loading="parseInt(props.item.id) === loadingButton"
                            style="text-decoration: none"
                            round
                            small
                            @click="loadingButton = parseInt(props.item.id)"
                    >
                        {{ props.item.nmArquivo }}
                    </v-btn>
                </td>
            </template>
            <template
                    slot="pageText"
                    slot-scope="props">
                Items {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
            </template>
        </v-data-table>
        </v-card>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
import { utils } from '@/mixins/utils';
import cnpjFilter from '@/filters/cnpj';

export default {
    name: 'BeneficiariosProdutoCultural',
    filters: {
        cnpjFilter,
    },
    mixins: [utils],
    data() {
        return {
            pagination: {
                sortBy: '',
                descending: true,
            },
            headers: [
                {
                    text: 'Produto',
                    align: 'left',
                    value: 'Produto',
                },
                {
                    text: 'Tipo Beneficiário',
                    align: 'left',
                    value: 'qtFisicaAprovada',
                },
                {
                    text: 'CNPJ/CPF',
                    align: 'left',
                    value: 'CNPJCPF',
                },
                {
                    text: 'Nome',
                    align: 'left',
                    value: 'Beneficiario',
                },
                {
                    text: 'Quantidade',
                    align: 'right',
                    value: 'qtRecebida',
                },
                {
                    text: 'Arquivo',
                    align: 'left',
                    value: 'nmArquivo',
                },
            ],
        };
    },
    computed: {
        ...mapGetters({
            dados: 'prestacaoContas/relatorioCumprimentoObjeto',
        }),
    },
};
</script>
