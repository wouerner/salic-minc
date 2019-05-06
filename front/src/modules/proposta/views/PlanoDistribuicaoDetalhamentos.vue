<template>
    <div class="plano-distribuicao-detalhanentos">
        <ul
            class="collapsible"
            data-collapsible="expandable">
            <li
                v-for="( local, index ) in locais"
                :key="index">
                <div class="collapsible-header"><i class="material-icons">place</i>
                    {{ local.uf ? local.uf : 'Exterior' }}
                    {{ local.cidade ? ` -  ${local.cidade}` : '' }}
                </div>
                <div class="collapsible-body">
                    <detalhamento-listagem
                        :disabled="disabled"
                        :idplanodistribuicao="idPlanoDistribuicao"
                        :idpreprojeto="idPreProjeto"
                        :iduf="local.idUF"
                        :idmunicipioibge="local.idMunicipioIBGE"
                        :detalhamentos="obterDetalhamentosPorLocalizacao(local)"
                        :canal-aberto="canalAberto"
                        @eventoRemoverDetalhamento="removerDetalhamento"
                        @eventoEditarDetalhamento="editarDetalhamento"
                    />
                    <detalhamento-formulario
                        v-model="exibirFormulario"
                        :disabled="disabled"
                        :id-plano-distribuicao="idPlanoDistribuicao"
                        :id-pre-projeto="idPreProjeto"
                        :id-uf="local.idUF"
                        :id-municipio-ibge="local.idMunicipioIBGE"
                        :editar-detalhamento="detalhamento"
                        :id-normativo="idNormativo"
                        @eventoSalvarDetalhamento="salvarPlanoDetalhamento"
                    />
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import { utils } from '@/mixins/utils';

import axios from 'axios';
import { mapActions, mapGetters } from 'vuex';

import DetalhamentoFormulario from '../components/PlanoDistribuicaoDetalhamentos/DetalhamentoFormulario';
import DetalhamentoListagem from '../components/PlanoDistribuicaoDetalhamentos/DetalhamentoListagem';

export default {
    name: 'PlanoDistribuicaoDetalhamentos',
    components: {
        DetalhamentoFormulario,
        DetalhamentoListagem,
    },
    mixins: [utils],
    props: [
        'idPreProjeto',
        'idPlanoDistribuicao',
        'disabled',
        'canalAberto',
        'idNormativo',
    ],
    data() {
        return {
            // detalhamentos: [],
            detalhamento: {},
            exibirFormulario: false,
        };
    },
    computed: {
        ...mapGetters({
            locais: 'proposta/obterLocaisRealizacao',
            detalhamentos: 'proposta/obterPlanoDistribuicaoDetalhamentos',
        }),
    },
    watch: {
        locais() {
            this.$nextTick(() => {
                this.iniciarCollapsible();
            });
        },
    },
    mounted() {
        this.obterDetalhamentos();
        this.buscarLocaisRealizacao(this.idPreProjeto);
        this.iniciarObservadorAjaxJquery();
    },
    methods: {
        ...mapActions({
            buscarLocaisRealizacao: 'proposta/buscarLocaisRealizacao',
            buscarDetalhamentos: 'proposta/buscarPlanoDistribuicaoDetalhamentos',
            salvarDetalhamento: 'proposta/salvarPlanoDistribuicaoDetalhamento',
            excluirDetalhamento: 'proposta/excluirPlanoDistribuicaoDetalhamento',
        }),
        removerDetalhamento(detalhamento) {
            // eslint-disable-next-line
            if (confirm('Tem certeza que deseja deletar o item?')) {
                this.excluirDetalhamento(
                    {
                        idPreProjeto: this.idPreProjeto,
                        idDetalhaPlanoDistribuicao: detalhamento.idDetalhaPlanoDistribuicao,
                        idPlanoDistribuicao: detalhamento.idPlanoDistribuicao,
                    },
                ).then((response) => {
                    if (response.success === 'true') {
                        this.mensagemSucesso(response.msg);
                    }
                }).catch((e) => {
                    this.mensagemErro(e.responseJSON.msg);
                });
            }
        },
        editarDetalhamento(detalhamento) {
            this.exibirFormulario = true;
            this.detalhamento = Object.assign({}, detalhamento);
        },
        obterDetalhamentosPorLocalizacao(local) {
            return this.detalhamentos.filter(item => parseInt(item.idUF, 10) === parseInt(local.idUF, 10)
                && parseInt(item.idMunicipio, 10) === parseInt(local.idMunicipioIBGE, 10));
        },
        obterDetalhamentos() {
            const params = {
                idPlanoDistribuicao: this.idPlanoDistribuicao,
                idPreProjeto: this.idPreProjeto,
            };

            this.buscarDetalhamentos(params)
                .catch(() => {
                    this.mensagemErro('Erro ao buscar detalhamento');
                });
        },
        iniciarCollapsible() {
            const self = this;
            // eslint-disable-next-line
            $3(".collapsible").each(function () {
                // eslint-disable-next-line
                $3(this).collapsible({
                    accordion: true,
                    onOpen(el) {
                        el.find('.material-icons:first').html('remove');
                    },
                    onClose(el) {
                        el.find('.material-icons:first').html('place');
                        self.exibirFormulario = false;
                    },
                });
            });
        },
        iniciarObservadorAjaxJquery() {

            axios.interceptors.request.use((config) => {
                $3('#container-loading').fadeIn();
                return config;
            }, (error) => {
                $3('#container-loading').fadeOut();
                return Promise.reject(error);
            });

            // axios.interceptors.response.use((response) => {
            //     // trigger 'loading=false' event here
            //     return response;
            // }, (error) => {
            //     // trigger 'loading=false' event here
            //     return Promise.reject(error);
            // });

            // eslint-disable-next-line
            // $3(document).ajaxStart(function () {
            //     // eslint-disable-next-line
            //     $3('#container-loading').fadeIn();
            // });
            // // eslint-disable-next-line
            // $3(document).ajaxComplete(function () {
            //     // eslint-disable-next-line
            //     $3('#container-loading').fadeOut();
            // });
        },
        salvarPlanoDetalhamento(detalhamento) {
            this.salvarDetalhamento(
                {
                    idPreProjeto: this.idPreProjeto,
                    ...detalhamento,
                },
            ).then((response) => {
                if (response.success === 'true') {
                    this.mensagemSucesso(response.msg);
                }
            }).catch((e) => {
                console.log('mensagem erro', e);
                this.mensagemErro(e.responseJSON.msg);
            });
        },
    },
};
</script>
