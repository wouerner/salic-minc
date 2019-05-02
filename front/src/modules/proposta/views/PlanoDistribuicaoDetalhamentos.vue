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
                        :idplanodistribuicao="idplanodistribuicao"
                        :idpreprojeto="idpreprojeto"
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
                        :id-plano-distribuicao="idplanodistribuicao"
                        :id-pre-projeto="idpreprojeto"
                        :id-uf="local.idUF"
                        :id-municipio-ibge="local.idMunicipioIBGE"
                        :editar-detalhamento="detalhamento"
                        :id-normativo="idNormativo"
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
        'idpreprojeto',
        'idplanodistribuicao',
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
        this.buscarLocaisRealizacao(this.idpreprojeto);
        // this.iniciarCollapsible();
    },
    methods: {
        ...mapActions({
            buscarLocaisRealizacao: 'proposta/buscarLocaisRealizacao',
            buscarDetalhamentos: 'proposta/buscarPlanoDistribuicaoDetalhamentos',
        }),
        removerDetalhamento(detalhamento, index) {
            // const vue = this;
            // if (confirm('Tem certeza que deseja deletar o item?')) {
            //     axios.post(
            //         `/proposta/plano-distribuicao/detalhar-excluir/idPreProjeto/${vue.idpreprojeto}`,
            //         {
            //             idDetalhaPlanoDistribuicao: detalhamento.idDetalhaPlanoDistribuicao,
            //             idPlanoDistribuicao: vue.idplanodistribuicao,
            //         },
            //     ).then((response) => {
            //         if (response.data.success === 'true') {
            //             vue.delete(vue.detalhamentos, index);
            //             vue.mensagemSucesso(response.msg);
            //         }
            //     }).catch((response) => {
            //         vue.mensagemErro(response.responseJSON.msg);
            //     });
            // }
        },
        editarDetalhamento(detalhamento, index) {
            this.exibirFormulario = true;
            this.detalhamento = Object.assign({}, detalhamento);
        },
        obterDetalhamentosPorLocalizacao(local) {
            return this.detalhamentos.filter(item => parseInt(item.idUF, 10) === parseInt(local.idUF, 10)
                && parseInt(item.idMunicipio, 10) === parseInt(local.idMunicipioIBGE, 10));
        },
        obterDetalhamentos() {
            const params = {
                idPlanoDistribuicao: this.idplanodistribuicao,
                idPreProjeto: this.idpreprojeto,
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
    },
};
</script>
