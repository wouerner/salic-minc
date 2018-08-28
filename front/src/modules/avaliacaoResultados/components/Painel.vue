<template>
    <div>
        <v-data-table
                :headers="headers"
                :items="desserts"
                hide-actions
                class="elevation-1"
        >
            <template slot="items" slot-scope="props">
                <td>{{ props.item.numero }}</td>
                <td class="text-xs-right">{{ props.item.pronac }}</td>
                <td class="text-xs-right">{{ props.item.nome }}</td>
                <td class="text-xs-right">{{ props.item.situacao }}</td>
                <td class="text-xs-right">{{ props.item.area }}</td>
                <td class="text-xs-right">{{ props.item.estado }}</td>
                <td class="text-xs-right">{{ props.item.mecanismo }}</td>
                <td class="text-xs-right">{{ props.item.data }}</td>
                <td class="text-xs-right">{{ props.item.analisar }}</td>
                <td class="text-xs-right">{{ props.item.divisao }}</td>
                <td class="text-xs-right">{{ props.item.diligencia }}</td>
                <td class="text-xs-right">{{ props.item.historico }}</td>
                <td> adfadsfasdfads
                </td>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import ModalTemplate from '@/components/modal';

export default {
    name: 'Painel',
    data () {
        return {
            headers: [
                {
                    text: '#',
                    align: 'left',
                    sortable: false,
                    value: 'numero'
                },
                { text: 'PRONAC', value: 'pronac' },
                { text: 'Nome Do Projeto', value: 'nome' },
                { text: 'Situacao', value: 'situacao' },
                { text: 'Area/Segmento', value: 'area' },
                { text: 'Estado', value: 'estado' },
                { text: 'Mecanismo', value: 'mecanismo' },
                { text: 'Dt.recebimento', value: 'data' },
                { text: 'Analisar', value: 'analisar' },
                { text: 'Devolver para Chefe de Divisao', value: 'divisao' },
                { text: 'Diligencia', value: 'divisao' },
                { text: 'Historico', value: 'historico' },

            ],
            desserts: [
                {
                    numero: 1,
                    pronac: 'aaaa',
                    nome:'Crianca e vida - 15 anos',
                    situacao:'E17',
                    area:'Artes Integradas / Artes Integradas',
                    estado: 'SP',
                    mecanismo: 'Incentivo Fiscal',
                    data: '27/10/2017',
                    analisar: '####',
                    divisao: '###',
                    diligencia: '###',
                    historico: '###',

                },

            ]
        }
    },
    components: {
        ModalTemplate,
    },
    methods: {
        ...mapActions({
            criarRegistro: 'foo/criarRegistro',
            modalOpen: 'modal/modalOpen',
            modalClose: 'modal/modalClose',
        }),
        fecharModal() {
            // eslint-disable-next-line
            $3('#modalTemplate').modal('close');
            this.modalClose();
        },
    },
    computed: mapGetters({
        modalVisible: 'modal/default',
    }),
};
</script>
