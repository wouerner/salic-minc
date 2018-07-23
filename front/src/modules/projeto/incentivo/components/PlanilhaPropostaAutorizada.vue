<template>
    <div id="planilha-congelada">
        <Carregando v-if="loading" :text="'Procurando planilha'"></Carregando>
        <Planilha v-if="Object.keys(planilha).length > 0"
                              :componenteTabelaItens="'PlanilhaItensAutorizados'"
                              :arrayPlanilha="planilha"></Planilha>
        <div v-if="semResposta" class="card-panel padding 20 center-align">{{ mensagem }}</div>
    </div>
</template>

<script>
    import Carregando from '@/components/Carregando';
    import Planilha from '@/components/Planilha/Planilha';
    import {mapGetters} from 'vuex';

    export default {
        name: "PlanilhaPropostaAutorizada",
        data: function () {
            return {
                planilha: [],
                loading: true,
                semResposta: false,
                mensagem: ''
            }
        },
        components: {
            Carregando,
            Planilha
        },
        mounted: function() {
            if (typeof this.dadosProjeto != 'undefined') {
                this.fetch(this.dadosProjeto.idPreProjeto);
            }
        },
        watch: {
            dadosProjeto: function (value) {
                if (typeof value != 'undefined') {
                    this.fetch(value.idPreProjeto);
                }
            }
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
            })
        },
        methods: {
            fetch: function (id) {

                if (typeof id == 'undefined') {
                    return
                }

                let self = this;
                $3.ajax({
                    url: '/proposta/visualizar/obter-planilha-proposta-original-ajax/',
                    data: {
                        idPreProjeto: id
                    }
                }).done(function (response) {
                    self.planilha = response.data;
                }).fail(function (response) {
                    self.semResposta = true;
                    self.mensagem = response.responseJSON.msg;
                }).always(function () {
                    self.loading = false;
                });
            }
        }
    };
</script>