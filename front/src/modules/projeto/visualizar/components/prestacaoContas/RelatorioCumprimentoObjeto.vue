<template>
    <div>
        <div v-if="loading">
            <Carregando :text="'Relatório de cumprimento do objeto'"/>
        </div>
        <div v-else>
            teste
        </div>
    </div>
</template>
<script>

import { mapActions, mapGetters } from 'vuex';
import Carregando from '@/components/CarregandoVuetify';
import { utils } from '@/mixins/utils';

export default {
    name: 'RelatorioCumprimentoObjeto',
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
            headers: [

            ],
        };
    },
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
            dados: 'prestacaoContas/relatorioCumprimentoObjeto',
        }),
    },
    watch: {
        dadosProjeto(value) {
            this.loading = false;
            this.buscarRelatorioCumprimentoObjeto(value.idPronac);
        },
        dados() {
            this.loading = false;
        },
    },
    mounted() {
        if (typeof this.dadosProjeto.idPronac !== 'undefined') {
            this.buscarRelatorioCumprimentoObjeto(this.dadosProjeto.idPronac);
        }
    },
    methods: {
        ...mapActions({
            buscarRelatorioCumprimentoObjeto: 'prestacaoContas/buscarRelatorioCumprimentoObjeto',
        }),
        indexItems() {
            const currentItems = this.dados;
            return currentItems.map((item, index) => ({
                id: index,
                ...item,
            }));
        },
    },
};
</script>
