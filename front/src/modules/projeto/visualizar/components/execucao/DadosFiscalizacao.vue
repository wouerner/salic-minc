<template>
    <div>
        <v-card>
            <v-card-title>
                <h6>Dados Fiscalizacao</h6>
            </v-card-title>
        </v-card>
    </div>
</template>
<script>

    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: 'DadosFiscalizacao',
        data() {
            return {
            };
        },
        // filters: {
        //     formatarData(date) {
        //         if (date.length === 0) {
        //             return '-';
        //         }
        //         return moment(date).format('DD/MM/YYYY');
        //     },
        // },
        // components: {
        //     Carregando,
        // },
        // mounted() {
        //     if (typeof this.dadosProjeto.idPronac !== 'undefined') {
        //         this.buscarMarcasAnexadas(this.dadosProjeto.idPronac);
        //     }
        // },
        // watch: {
        //     loadingButton() {
        //         setTimeout(() => (this.loadingButton = -1), 2000);
        //     },
        //     dados() {
        //         this.loading = false;
        //     },
        // },
        // computed: {
        //     ...mapGetters({
        //         dadosProjeto: 'projeto/projeto',
        //         dados: 'projeto/marcasAnexadas',
        //     }),
        // },
        // methods: {
        //     ...mapActions({
        //         buscarMarcasAnexadas: 'projeto/buscarMarcasAnexadas',
        //     }),
        // },
    };
</script>

