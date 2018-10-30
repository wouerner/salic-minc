<template>
    <div id="conteudo">
        <div v-if="loading">
            <Carregando :text="'Carregando Aprova&ccedil;&atilde;o'"></Carregando>
        </div>
        <div v-else-if="dados.Aprovacao">
            <IdentificacaoProjeto
                :pronac="dadosProjeto.Pronac"
                :nomeProjeto="dadosProjeto.NomeProjeto">
            </IdentificacaoProjeto>
            <div v-for="(dado, index) in dados.Aprovacao" :key="index">
                <table class="tabela">
                    <tbody>
                        <tr>
                            <td align="left">
                                <input type="button"
                                    class="btn_adicionar"
                                    id="objetivos"
                                    @click="setAbaAtiva(index)">
                                <b v-html="dado.TipoAprovacao"></b>
                            </td>
                        </tr>
                        <tr v-if="abaAtiva === index && ativo && Object.keys(dado).length > 0" align="left" style="padding: 5px">
                            <table class="tabela">
                                <tbody>
                                    <tr>
                                        <th align="center">Portaria / Datas</th>
                                        <th align="center">Per&iacute;odo de Capta&ccedil;&atilde;o</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>{{dado.TipoAprovacao}}</td>
                                                        <td>{{dado.DtAprovacao}}</td>
                                                        <td>{{dado.PortariaAprovacao}}</td>
                                                        <td>{{dado.DtPortariaAprovacao}}</td>
                                                        <td>{{dado.DtPublicacaoAprovacao}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>{{dado.DtInicioCaptacao}}</td>
                                                        <td>{{dado.DtFimCaptacao}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table v-if="dado.ResumoAprovacao" class="tabela">
                                <tbody>
                                    <tr>
                                        <th align="center">S&iacute;ntese Aprova&ccedil;&atilde;o</th>
                                    </tr>
                                    <tr>
                                        <td style="padding-left: 20px" v-html="dado.ResumoAprovacao"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table v-if="dado.AprovadoReal > 0" class="tabela">
                                <tbody>
                                    <tr>
                                        <th align="center">{{dado.Mecanismo}}</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Vl. Aprova&ccedil;&atilde;o</b> <br>
                                            <b>R$ {{dado.AprovadoReal | filtroFormatarParaReal}}</b>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>

    import { mapActions, mapGetters } from 'vuex';
    import Carregando from '@/components/Carregando';
    import IdentificacaoProjeto from '@/components/Projeto/IdentificacaoProjeto'
    import planilhas from '@/mixins/planilhas'
    export default {
        name: 'Aprovacao',
        props: ['idPronac'],
        data() {
            return {
                dados: {
                    type: Object,
                    default() {
                        return {};
                    },
                },
                loading: true,
                abaAtiva: -1,
                ativo: false,
            };
        },
        components: {
            Carregando,
            IdentificacaoProjeto,
        },
        mixins: [planilhas],
        mounted() {
            if (typeof this.$route.params.idPronac !== 'undefined') {
                this.buscar_dados();
            }
        },
        watch: {
            dados() {
                this.loading = false;
            }
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
            }),
        },
        methods: {
            setAbaAtiva(index) {
                if (this.abaAtiva === index) {
                    this.ativo = !this.ativo;
                } else {
                    this.abaAtiva = index;
                    this.ativo = true;
                    // this.buscarDiligenciaProposta(value);
                }
            },
            buscar_dados() {
                const self = this;
                /* eslint-disable */
                $3.ajax({
                    url: '/analise/aprovacao-rest/index/idPronac/' + self.dadosProjeto.idPronac,
                }).done(function (response) {
                    self.dados = response.data.items;
                });
            },
        },
    };
</script>

