<template>
    <!--<div id="conteudo">-->
    <!--<div v-if="loading">-->
    <!--<Carregando :text="'Carregando Providencia Tomada'"></Carregando>-->
    <!--</div>-->
    <!--<div v-else-if="dados">-->
    <!--<div v-if="dados.providenciaTomada">-->
    <!--<table class="tabela">-->
    <!--<thead>-->
    <!--<tr class="destacar">-->
    <!--<th class="center">DT. SITUA&Ccedil;&Atilde;O</th>-->
    <!--<th class="center">SITUA&Ccedil;&Atilde;O</th>-->
    <!--<th class="center">PROVID&Ecirc;NCIA TOMADA</th>-->
    <!--<th class="center">CPF</th>-->
    <!--<th class="center">NOME</th>-->
    <!--</tr>-->
    <!--</thead>-->
    <!--<tbody v-for="(dado, index) in dados.providenciaTomada" :key="index">-->
    <!--<tr>-->
    <!--<td class="center">{{ dado.DtSituacao }}</td>-->
    <!--<td class="center">{{ dado.Situacao }}</td>-->
    <!--<td class="center">{{ dado.ProvidenciaTomada }}</td>-->
    <!--<td class="center">{{ dado.cnpjcpf }}</td>-->
    <!--<td class="center">{{ dado.usuario }}</td>-->
    <!--</tr>-->
    <!--</tbody>-->
    <!--</table>-->
    <!--</div>-->
    <!--<div v-else>-->
    <!--<fieldset>-->
    <!--<legend>Provid&ecirc;ncia Tomada</legend>-->
    <!--<div class="center">-->
    <!--<em>Dados n&atilde;o informado.</em>-->
    <!--</div>-->
    <!--</fieldset>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>-->
    <div>
       <v-data-table
                :headers="headers"
                :items="dados.providenciaTomada"
                class="elevation-1"
        >
            <template slot="items" slot-scope="props">
                <td>{{ props.item.DtSituacao }}</td>
                <td>{{ props.item.Situacao }}</td>
                <td style="width: 400px">{{ props.item.ProvidenciaTomada }}</td>
                <td>{{ props.item.cnpjcpf }}</td>
                <td>{{ props.item.usuario }}</td>
                <!--<td class="text-xs-right">{{ props.item.iron }}</td>-->
            </template>
            <template slot="pageText" slot-scope="props">
                Lignes {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
            </template>
        </v-data-table>
    </div>

</template>
<script>
    import { mapActions, mapGetters } from 'vuex';
    import Carregando from '@/components/Carregando';
    import IdentificacaoProjeto from './IdentificacaoProjeto';

    // export default {
    //     name: 'ProvidenciaTomada',
    //     components: {
    //         Carregando,
    //         IdentificacaoProjeto,
    //     },
    //     data() {
    //         return {
    //             loading: true,
    //         };
    //     },
    //     mounted() {
    //         if (typeof this.dadosProjeto.idPronac !== 'undefined') {
    //             this.buscarProvidenciaTomada(this.dadosProjeto.idPronac);
    //         }
    //     },
    //     watch: {
    //         dados() {
    //             this.loading = false;
    //         }
    //     },
    //     computed: {
    //         ...mapGetters({
    //             dadosProjeto: 'projeto/projeto',
    //             dados: 'projeto/providenciaTomada',
    //         }),
    //     },
    //     methods: {
    //         ...mapActions({
    //             buscarProvidenciaTomada: 'projeto/buscarProvidenciaTomada',
    //         }),
    //     },
    // };
    export default {
        components: {
            Carregando,
            IdentificacaoProjeto,
        },
        data() {
            return {
                search: '',
                pagination: {
                    sortBy: 'fat',
                },
                selected: [],
                loading: true,
                headers: [
                    {
                        text: 'DT. SITUAÇÃO',
                        align: 'left',
                        sortable: false,
                        value: 'DtSituacao',
                    },
                    {
                        text: 'SITUAÇÃO',
                        value: 'Situacao',
                    },
                    {
                        text: 'PROVIDÊNCIA TOMADA',
                        value: 'ProvidenciaTomada',
                    },
                    {
                        text: 'CPF',
                        value: 'cnpjcpf',
                    },
                    {
                        text: 'NOME',
                        value: 'usuario',
                    },
                ],
            };
        },

        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                this.buscarProvidenciaTomada(this.dadosProjeto.idPronac);
            }
        },
        watch: {
            dados() {
                this.loading = false;
            },
        },

        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dados: 'projeto/providenciaTomada',
            }),
        },
        methods: {
            toggleOrder() {
                this.pagination.descending = !this.pagination.descending;
            },
            nextSort() {
                let index = this.headers.findIndex(h => h.value === this.pagination.sortBy);
                index = (index + 1) % this.headers.length;
                index = index === 0 ? index + 1 : index;
                this.pagination.sortBy = this.headers[index].value;
            },
            ...mapActions({
                buscarProvidenciaTomada: 'projeto/buscarProvidenciaTomada',
            }),
        },
    }
</script>

