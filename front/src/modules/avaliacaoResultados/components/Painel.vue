<template>
    <v-container fluid>
        <v-data-table
                :headers="cabecalho"
                :items="dados"
                hide-actions
                class="elevation-1"
        >
            <template slot="items" slot-scope="props">
                <td>{{ props.index+1 }}</td>
                <td class="text-xs-right">{{ props.item.pronac }}
                    <v-flex xs12 sm4 text-xs-center>
                        <div>
                            <v-btn>131313131</v-btn>
                        </div>
                    </v-flex>
                </td>
                <td class="text-xs-right">{{ props.item.nome }}</td>
                <td class="text-xs-right">{{ props.item.situacao }}</td>
                <td class="text-xs-right">{{ props.item.area }}</td>
                <td class="text-xs-right">{{ props.item.estado }}</td>
                <td class="text-xs-right">{{ props.item.mecanismo }}</td>
                <td class="text-xs-right">{{ props.item.data }}</td>
                <td class="text-xs-right">{{ props.item.analisar }}
                    <v-btn flat icon color="green">
                        <v-icon class="material-icons">compare_arrows</v-icon>
                    </v-btn>
                </td>
                <td class="text-xs-right">
                    <v-btn flat icon color="indigo">
                        <v-icon>warning</v-icon>
                    </v-btn>
                </td>
                <td class="text-xs-right">
                    <Historico></Historico>
                </td>
            </template>
        </v-data-table>
    </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import ModalTemplate from '@/components/modal';
import Historico from './Historico';

export default {
    name: 'Painel',
    data () {
        return {
            cabecalho: [
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
                { text: 'Diligencia', value: 'diligencia' },
                { text: 'Historico', value: 'historico' },

            ],
            dados: [
                {
                    nome:'Crianca e vida - 15 anos',
                    situacao:'E17',
                    area:'Artes Integradas / Artes Integradas',
                    estado: 'SP',
                    mecanismo: 'Incentivo Fiscal',
                    data: '27/10/2017',
                },
                {
                    nome:'Crianca e vida - 15 anos',
                    situacao:'E17',
                    area:'Artes Integradas / Artes Integradas',
                    estado: 'SP',
                    mecanismo: 'Incentivo Fiscal',
                    data: '27/10/2017',
                },

            ]
        }
    },
    components: {
        ModalTemplate,
        Historico,
    },
    methods: {
        ...mapActions({
            criarRegistro: 'foo/criarRegistro',
            modalOpen: 'modal/modalOpen',
            modalClose: 'modal/modalClose',
        }),
    },
    computed: mapGetters({
        modalVisible: 'modal/default',
    }),
};
</script>
