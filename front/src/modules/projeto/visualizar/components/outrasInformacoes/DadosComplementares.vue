<template>
    <div id="conteudo">
        <div v-if="dados.informacoes">
            <IdentificacaoProjeto :pronac="dados.informacoes.Pronac"
                                  :nomeProjeto="dados.informacoes.NomeProjeto">
            </IdentificacaoProjeto>
            <TabelaDadosComplementares  dadoComplementar="Objetivos"
                                        dsDadoComplementar="blabla"></TabelaDadosComplementares>
        </div>
    </div>
</template>
<script>
import IdentificacaoProjeto from './IdentificacaoProjeto';
import TabelaDadosComplementares from './TabelaDadosComplementares'
export default {
    name: 'DadosComplementares',
    props: ['idPronac'],
    components: {
        IdentificacaoProjeto,
        TabelaDadosComplementares,
    },
    data() {
        return {
            dados: {
                    type: Object,
                    default() {
                        return {};
                    },
                },
        };
    },
    mounted() {
        if (typeof this.$route.params.idPronac !== 'undefined') {
            this.buscar_dados();
        }
    },
    methods: {
        buscar_dados() {
            const self = this;
            const idPronac = self.$route.params.idPronac
            /* eslint-disable */
            $3.ajax({
                url: '/projeto/certidoes-negativas-rest/index/idPronac/' + idPronac,
            }).done(function (response) {
                self.dados = response.data;
            });
        },
    },
}
</script>

