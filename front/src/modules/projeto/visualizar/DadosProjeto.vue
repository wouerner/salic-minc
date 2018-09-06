<template>
    <div id="dados-projeto">
       <component :is="componenteProjeto" :idPronac="dadosProjeto.idPronac"/>
    </div>
</template>
<script>
    import { mapGetters } from 'vuex';
    import DadosProjetoIncentivo from './incentivo/components/DadosProjeto';
    import DadosProjetoConvenio from './convenio/components/DadosProjeto';

    const MECANISMO_MECENATO = '1';

    export default {
        data() {
            return {
                componenteProjeto: '',
            };
        },
        components: {
            DadosProjetoIncentivo,
            DadosProjetoConvenio,
        },
        created() {
            this.selecionarTipoComponente();
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
            }),
        },
        methods: {
            selecionarTipoComponente() {
                if (this.dadosProjeto.idMecanismo === MECANISMO_MECENATO) {
                    this.componenteProjeto = 'DadosProjetoIncentivo';
                } else {
                    this.componenteProjeto = 'DadosProjetoConvenio';
                }
            }
        }
    };
</script>
