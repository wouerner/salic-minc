<template>
    <div id="planilha-proposta-original">
        <Carregando v-if="loading" :text="'Procurando planilha'"></Carregando>

        <div v-if="Object.keys(planilha).length > 0">

            <div class="right-align">
                <router-link :to="{ name: 'planilhaproposta', params: { idPronac: idPronac }}"
                    class="btn btn-primary">
                    <i class="material-icons left">visibility</i>Planilha Original
                </router-link>
            </div>

            <PlanilhaOrcamentaria :arrayPlanilha="planilha"></PlanilhaOrcamentaria>
        </div>
        <div v-if="semResposta" class="card-panel padding 20 center-align">{{ mensagem }}</div>
    </div>
</template>

<script>
    import Carregando from '@/components/Carregando';
    import PlanilhaOrcamentaria from '@/components/planilha/PlanilhaOrcamentaria';
    import {mapGetters} from 'vuex';

    export default {
        name: "PlanilhaPropostaAdequada",
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
                    url: '/proposta/visualizar/obter-planilha-proposta-adequada-ajax/',
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