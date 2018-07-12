<template>
    <div id="planilha-congelada">
        <Carregando v-if="loading" :text="'Procurando planilha'"></Carregando>
        <SalicPlanilhaOrcamentariaSimples :arrayPlanilha="planilha"></SalicPlanilhaOrcamentariaSimples>
    </div>
</template>

<script>
    import Carregando from '@/components/Carregando';
    import SalicPlanilhaOrcamentariaSimples from '@/components/SalicPlanilhaOrcamentariaSimples';
    import {mapGetters} from 'vuex';

    export default {
        name: "PlanilhaCongelada",
        data: function () {
            return {
                planilha: [],
                loading: true,
            }
        },
        components: {
            Carregando,
            SalicPlanilhaOrcamentariaSimples
        },
        props: ['id'],
        mounted: function () {
//            if (typeof this.id != 'undefined') {
//                this.fetch(this.id);
//            }

        },
        watch: {
            projeto: function (projeto) {
                if (typeof projeto != 'undefined') {
                    this.fetch(projeto.idPreProjeto);
                }
            }
        },
        computed: {
            ...mapGetters({
                projeto: 'projeto/projeto',
            })
        },
        methods: {
            fetch: function (id) {

                if(id.length == 0 || typeof id == 'undefined') {
                    return
                }

                let self = this;
                $3.ajax({
                    url: '/proposta/visualizar/obter-planilha-proposta-congelada-ajax/',
                    data: {
                        idPreProjeto: id
                    }
                }).done(function (response) {
                    self.planilha = response.data;
                    console.log('teteste', response.data);

                    if (self.planilha && self.planilha.identificacao) {
                        self.identificacao = self.planilha.identificacao;
                    }
                    self.loading = false;

                });
            }
        }
    };
</script>