<template>
    <div>
        <v-card-title>
            <v-spacer/>
            <v-text-field
                v-model="search"
                append-icon="search"
                label="Pesquisar"
                single-line
                hide-details
            />
        </v-card-title>
        <v-data-table
            :headers="headers()"
            :items="dados"
            :pagination.sync="pagination"
            :search="search"
            hide-actions
        >
            <template
                slot="items"
                slot-scope="props">
                <td>{{ props.index+1 }}</td>
                <td class="text-xs-right">
                    <v-flex
                        xs12
                        sm4
                        text-xs-center>
                        <div>
                            <v-btn
                                :href="'/projeto/#/'+ props.item.idPronac"
                                flat>{{ props.item.idPronac }}</v-btn>
                        </div>
                    </v-flex>
                </td>
                <td class="text-xs-left">{{ props.item.idTipoReadequacao }}</td>
                <td class="text-xs-center">{{ props.item.dtSolicitacao }}</td>
                <td class="text-xs-center">{{ props.item.idDocumento }}</td>
                <td
                    class="text-xs-center">{{ props.item.dsJustificativa }}</td>
                <td class="text-xs-center">
                    <!-- <template
                        v-for="(c, index) in componentes.acoes"
                        d-inline-block>
                        <component
                            :key="index"
                            :obj="props.item"
                            :is="c"
                            :link-direto-assinatura="true"
                            :documento="props.item.idDocumentoAssinatura"
                            :id-pronac="props.item.IdPRONAC.toString()"
                            :pronac="props.item.PRONAC"
                            :nome-projeto="props.item.NomeProjeto"
                            :usuario="componentes.usuario"
                            :tecnico="{
                                idAgente: props.item.idAgente,
                                nome: props.item.usu_nome
                            }"
                        />
                    </template> -->
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
        <div class="text-xs-center">
            <div class="text-xs-center pt-2">
                <v-pagination
                    v-model="pagination.page"
                    :length="pages"
                    :total-visible="4"
                    color="primary "
                />
            </div>
        </div>
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
            selected: [],
            search: '',
        };
    },
    computed: {
        ...mapGetters({
            getReadequacoes: 'readequacao/getReadequacoes',
        }),
        pages() {
            if (this.pagination.rowsPerPage == null
                || this.pagination.totalItems == null
            ) return 0;
            return Math.ceil(this.pagination.totalItems / this.pagination.rowsPerPage);
        },
    },
    created() {
            this.obterListaDeReadequacoes(14100);
    },
    methods: {
        ...mapActions({
            obterListaDeReadequacoes: 'readequacao/obterListaDeReadequacoes',
        }),
        headers() {
            let dados = [];

            dados = [
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
            ];

            return dados;
        },
    },
};
</script>
