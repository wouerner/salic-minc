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
                        :canalaberto="canalaberto"
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

import Vue from 'vue';
import { mapActions, mapGetters } from 'vuex';

import DetalhamentoFormulario from '../components/PlanoDistribuicaoDetalhamentos/DetalhamentoFormulario';
import DetalhamentoListagem from '../components/PlanoDistribuicaoDetalhamentos/DetalhamentoListagem';

const detalhamentoEventBus = new Vue();

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
        'idmunicipioibge',
        'iduf',
        'disabled',
        'canalaberto',
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
        // this.iniciarCollapsible();
    },
    methods: {
        ...mapActions({
            buscarLocaisRealizacao: 'proposta/buscarLocaisRealizacao',
            buscarDetalhamentos: 'proposta/buscarPlanoDistribuicaoDetalhamentos',
            salvarDetalhamento: 'proposta/salvarPlanoDistribuicaoDetalhamento',
            excluirDetalhamento: 'proposta/excluirPlanoDistribuicaoDetalhamento',
        }),
        removerDetalhamento(detalhamento) {
            if (confirm('Tem certeza que deseja deletar o item?')) {
                this.excluirDetalhamento(
                    {
                        idDetalhaPlanoDistribuicao: detalhamento.idDetalhaPlanoDistribuicao,
                        idPlanoDistribuicao: this.idPlanoDistribuicao,
                    },
                ).then((response) => {
                    if (response.success === 'true') {
                        this.mensagemSucesso(response.msg);
                    }
                }).catch((e) => {
                    this.mensagemErro(e.responseJSON.msg);
                });
            //     axios.post(
            //         `/proposta/plano-distribuicao/detalhar-excluir/idPreProjeto/${vue.idPreProjeto}`,
            //         {
            //             idDetalhaPlanoDistribuicao: detalhamento.idDetalhaPlanoDistribuicao,
            //             idPlanoDistribuicao: vue.idPlanoDistribuicao,
            //         },
            //     ).then((response) => {
            //         if (response.data.success === 'true') {
            //             vue.delete(vue.detalhamentos, index);
            //             vue.mensagemSucesso(response.msg);
            //         }
            //     }).catch((response) => {
            //         vue.mensagemErro(response.responseJSON.msg);
            //     });
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
