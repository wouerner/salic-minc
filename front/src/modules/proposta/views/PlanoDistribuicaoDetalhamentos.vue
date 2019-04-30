<template>
    <div class="plano-distribuicao-detalhanentos">
        <detalhamento-listagem
            :disabled="disabled"
            :idplanodistribuicao="idplanodistribuicao"
            :idpreprojeto="idpreprojeto"
            :iduf="iduf"
            :idmunicipioibge="idmunicipioibge"
            :detalhamentos="detalhamentos"
            :canalaberto="canalaberto"
            @eventoRemoverDetalhamento="removerDetalhamento"
            @eventoEditarDetalhamento="editarDetalhamento"
        />
        <detalhamento-formulario
            v-model="exibirFormulario"
            :disabled="disabled"
            :idplanodistribuicao="idplanodistribuicao"
            :idpreprojeto="idpreprojeto"
            :iduf="iduf"
            :idmunicipioibge="idmunicipioibge"
            :editar-detalhamento="detalhamento"
            :id-normativo="idNormativo"
            @eventoSalvarDetalhamento="salvarDetalhamento"
        />
    </div>
</template>

<script>
import { utils } from '@/mixins/utils';
import axios from 'axios';

import Vue from 'vue';

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
            detalhamentos: [],
            detalhamento: {},
            exibirFormulario: false,
        };
    },
    mounted() {
        this.obterDetalhamentos();
    },
    methods: {
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
            // this.exibirFormulario = true;
            // this.detalhamento = Object.assign({}, detalhamento);
        },
        salvarDetalhamento(detalhamento) {
            // const vue = this;
            // $3.ajax({
            //     type: 'POST',
            //     url: `/proposta/plano-distribuicao/detalhar-salvar/idPreProjeto/${this.idpreprojeto}`,
            //     data: detalhamento,
            // }).done((response) => {
            //     if (response.success == 'true') {
            //         const index = vue.$data.detalhamentos.findIndex(item => item.idDetalhaPlanoDistribuicao == response.data.idDetalhaPlanoDistribuicao);
            //
            //         if (index >= 0) {
            //             Object.assign(vue.$data.detalhamentos[index], detalhamento);
            //         } else {
            //             vue.$data.detalhamentos.push(response.data);
            //         }
            //         vue.mensagemSucesso(response.msg);
            //         detalhamentoEventBus.$emit('callBackSalvarDetalhamento', true);
            //     }
            // }).fail((response) => {
            //     vue.mensagemErro(response.responseJSON.msg);
            // });
        },
        obterDetalhamentos() {
            const vue = this;
            const url = `/proposta/plano-distribuicao/obter-detalhamentos/idPreProjeto/${this.idpreprojeto}`;
            const params = `?idPlanoDistribuicao=${this.idplanodistribuicao}&idMunicipio=${this.idmunicipioibge}&idUF=${this.iduf}`;

            axios.get(url + params).then((response) => {
                this.detalhamentos = response.data.data;
            }).catch(() => {
                vue.mensagemErro('Erro ao buscar detalhamento');
            });
        },
    },
};
</script>

<style scoped>

</style>
