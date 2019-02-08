<template>
    <div>
        <v-card>
            <v-card-title>
                <h6>LOCAL DE REALIZAÇÃO</h6>
            </v-card-title>
            <v-data-table
                :pagination.sync="pagination"
                :headers="headers"
                :items="dados.locaisRealizacao"
                class="elevation-1 container-fluid"
            >
                <template
                    slot="items"
                    slot-scope="props">
                    <td class="text-xs-left">{{ props.item.Pais }}</td>
                    <td class="text-xs-left">{{ props.item.UF }}</td>
                    <td class="text-xs-left">{{ props.item.Municipio }}</td>
                    <td class="text-xs-left">{{ props.item.siAbrangencia | tipoAbrangencia }}</td>
                    <td class="text-xs-right">{{ props.item.dtInicioRealizacao | formatarData }}</td>
                    <td class="text-xs-right">{{ props.item.dtFimRealizacao | formatarData }}</td>
                    <td class="text-xs-left">{{ props.item.dsJustificativa }}</td>
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

export default {
    name: 'LocaisRealizacao',
    filters: {
        tipoAbrangencia(siAbrangencia) {
            let tipoAbrangencia = '';
            switch (siAbrangencia) {
            case '0':
                tipoAbrangencia = 'Sem Informação';
                break;
            case '1':
                tipoAbrangencia = 'Não Realizado';
                break;
            case '2':
                tipoAbrangencia = 'Realizado';
                break;
            case '3':
                tipoAbrangencia = 'Realizado com outras fontes';
                break;
            default:
                tipoAbrangencia = '';
            }
            return tipoAbrangencia;
        },
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
                    text: 'País',
                    align: 'left',
                    value: 'Pais',
                },
                {
                    text: 'UF',
                    align: 'left',
                    value: 'UF',
                },
                {
                    text: 'Município',
                    align: 'left',
                    value: 'Municipio',
                },
                {
                    text: 'Realizado',
                    align: 'left',
                    value: 'siAbrangencia',
                },
                {
                    text: 'Dt. Início Realização',
                    align: 'left',
                    value: 'dtInicioRealizacao',
                },
                {
                    text: 'Dt. Fim Realização',
                    align: 'left',
                    value: 'dtFimRealizacao',
                },
                {
                    text: 'Justificativa',
                    align: 'left',
                    value: 'dsJustificativa',
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
