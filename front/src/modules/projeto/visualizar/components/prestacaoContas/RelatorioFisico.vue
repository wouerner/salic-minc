<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Relatorio Fisico'"/>
        </div>
        <div v-else/>
    </div>
</template>
<script>

import { mapActions, mapGetters } from 'vuex';
import Carregando from '@/components/CarregandoVuetify';
import { utils } from '@/mixins/utils';

export default {
    name: 'RelatorioFisico',
    components: {
        Carregando,
    },
    mixins: [utils],
    data() {
        return {
            pagination: {
                sortBy: '',
                descending: true,
            },
            loading: true,
        };
    },
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
            dados: 'prestacaoContas/relatorioFisico',
        }),
    },
    watch: {
        dadosProjeto(value) {
            this.loading = false;
            this.buscarRelatorioFisico(value.idPronac);
        },
        dados() {
            this.loading = false;
        },
    },
    mounted() {
        if (typeof this.dadosProjeto.idPronac !== 'undefined') {
            this.buscarRelatorioFisico(this.dadosProjeto.idPronac);
        }
    },
    methods: {
        ...mapActions({
            buscarRelatorioFisico: 'prestacaoContas/buscarRelatorioFisico',
        }),
    },
};
</script>
