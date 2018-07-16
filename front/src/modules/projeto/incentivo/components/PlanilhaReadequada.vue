<template>
    <div id="planilha-homologada">
        <Carregando v-if="loading" :text="'Procurando planilha'"></Carregando>
        <PlanilhaOrcamentaria v-if="Object.keys(planilha).length > 0"
                              :componenteTabelaItens="'ListaDeItensReadequados'"
                              :arrayPlanilha="planilha"></PlanilhaOrcamentaria>
        <div v-if="semResposta" class="card-panel padding 20 center-align">{{ mensagem }}</div>
    </div>
</template>

<script>
    import Carregando from '@/components/Carregando';
    import PlanilhaOrcamentaria from '@/components/planilha/PlanilhaOrcamentaria';
    import {mapGetters} from 'vuex';

    export default {
        name: "PlanilhaPropostaReadequada",
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
            PlanilhaOrcamentaria
        },
        mounted: function() {
            if (typeof this.dadosProjeto != 'undefined') {
                this.fetch(this.dadosProjeto.idPronac);
            }
        },
        watch: {
            dadosProjeto: function (value) {
                if (typeof value != 'undefined') {
                    this.fetch(value.idPronac);
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
                    url: '/projeto/orcamento/obter-planilha-readequada-ajax/',
                    data: {
                        idPronac: id
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