<template>
    <!-- <div id="conteudo">
        <div v-if="loading">
            <Carregando :text="'Carregando Certidoes Negativas'"></Carregando>
        </div>
        <div v-else-if="dados">
            <IdentificacaoProjeto :pronac="dadosProjeto.Pronac"
                                  :nomeProjeto="dadosProjeto.NomeProjeto">
            </IdentificacaoProjeto>
            <div v-if="Object.keys(dados.certidoes).length > 0">
                <table class="tabela">
                    <thead>
                    <tr class="destacar">
                        <th class="center">CERTID&otilde;es</th>
                        <th class="center">DATA DE EMISS&Atilde;O</th>
                        <th class="center">DATA DE VALIDADE</th>
                        <th class="center">PRONAC</th>
                        <th class="center">SITUA&Ccedil;&Atilde;O</th>
                    </tr>
                    </thead>
                    <tbody v-for="(dado, index) in dados.certidoes" :key="index">
                    <tr>
                        <td class="center">{{ dado.dsCertidao }}</td>
                        <td class="center">{{ dado.DtEmissao }}</td>
                        <td class="center">{{ dado.DtValidade }}</td>
                        <td class="center">{{ dado.Pronac }}</td>
                        <td class="center" v-if="dado.Situacao">
                            {{ dado.Situacao }}
                        </td>
                        <td class="center" v-else>
                            Vencida
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div v-else>
                <fieldset>
                    <legend>Certid&otilde;es Negativas</legend>
                    <div class="center">
                        <em>Dados n&atilde;o  informado.</em>
                    </div>
                </fieldset>
            </div>
        </div>
    </div> -->
    <div>
        <div v-if="loading">
            <Carregando :text="'Carregando Certidoes Negativas'"></Carregando>
        </div>
        <div v-else-if="dados.certidoes">
            <IdentificacaoProjeto :pronac="dadosProjeto.Pronac"
                                  :nomeProjeto="dadosProjeto.NomeProjeto">
            </IdentificacaoProjeto>
           <v-data-table
                    :headers="headers"
                    :items="dados.certidoes"
                    class="elevation-1 container-fluid"
                    rows-per-page-text="Itens por Página"
           >
                <template slot="items" slot-scope="props">
                    <td>{{ props.item.dsCertidao }}</td>
                    <td>{{ props.item.DtEmissao }}</td>
                    <td>{{ props.item.DtValidade }}</td>
                    <td>{{ props.item.Pronac }}</td>
                    <td v-if="props.item.Situacao">
                        {{ props.item.Situacao }}
                    </td>
                    <td v-else>
                        Vencida
                    </td>
                </template>
                <template slot="pageText" slot-scope="props">
                    Itens {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                </template>
            </v-data-table>
        </div>
    </div>
</template>
<script>

    import { mapActions, mapGetters } from 'vuex';
    import Carregando from '@/components/Carregando';
    import IdentificacaoProjeto from './IdentificacaoProjeto';

    export default {
        name: 'CertidoesNegativas',
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
                        text: 'CERTIDÕES',
                        align: 'left',
                        value: 'dsCertidao',
                    },
                    {
                        text: 'DATA DE EMISSÃO',
                        value: 'DtEmissao',
                    },
                    {
                        text: 'DATA DE VALIDADE',
                        value: 'DtValidade',
                    },
                    {
                        text: 'PRONAC',
                        value: 'Pronac',
                    },
                    {
                        text: 'SITUAÇÃO',
                        value: 'Situacao',
                    },
                ],
            };
        },
        components: {
            IdentificacaoProjeto,
            Carregando,
        },
        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                this.buscarCertidoesNegativas(this.dadosProjeto.idPronac);
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
                dados: 'projeto/certidoesNegativas',
            }),
        },
        methods: {
            ...mapActions({
                buscarCertidoesNegativas: 'projeto/buscarCertidoesNegativas',
            }),
        },
    };
</script>

