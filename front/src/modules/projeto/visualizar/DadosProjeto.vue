<template>
    <div id="dados-projeto">
       <component :is="componenteProjeto" :idPronac="dadosProjeto.idPronac"/>
    </div>
</template>
<script>
    import { mapActions, mapGetters } from 'vuex';
    import DadosProjetoIncentivo from '../incentivo/components/DadosProjeto';
    import DadosProjetoConvenio from '../convenio/components/DadosProjeto';

    const MECANISMO_MECENATO = '1';

    export default {
        name: 'Index',
        data() {
            return {
                componenteProjeto: '',
                idPronac: '',
            };
        },
        components: {
            DadosProjetoIncentivo,
            DadosProjetoConvenio
        },
        created() {
            if (this.dadosProjeto.idMecanismo === MECANISMO_MECENATO) {
                this.componenteProjeto = 'DadosProjetoIncentivo';
            } else if (this.dadosProjeto.idMecanismo > MECANISMO_MECENATO) {
                this.componenteProjeto = 'DadosProjetoConvenio';
            }
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
            }),
            projeto() {
                if (Object.keys(this.dadosProjeto).length > 0) {
                    this.carregando = false;
                    this.permissao = this.dadosProjeto.permissao;
                }

                return this.dadosProjeto;
            },
        },
    };
</script>
