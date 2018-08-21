<template>
    <div class="proposta">
            <div v-if="Object.keys(dadosHistorico).length > 2">
                <slPropostaAlteracoes :idpreprojeto="idpreprojeto" :dadosAtuais="dadosAtuais"
                                      :dadosHistorico="dadosHistorico"></slPropostaAlteracoes>
            </div>
            <div v-else-if="Object.keys(dadosAtuais).length > 2">
                <div class="card padding20">
                    <div class="nao-existe-versao-proposta">
                        <h4><i class="material-icons small left">report</i>Não existe versionamento de alterações para o projeto informado...</h4>
                        <p style="margin-left: 44px">O proponente não fez alterações no projeto no prazo estabelecido.</p>
                    </div>
                </div>
                <slProposta :idpreprojeto="idpreprojeto" :proposta="dadosAtuais"></slProposta>
            </div>
            <div v-else>
                <div class="card padding20">
                    <div class="center-align padding20">
                        <h5>Carregando ...</h5>
                    </div>
                </div>
            </div>
    </div>
</template>
<script>
import slPropostaAlteracoes from './components/slPropostaAlteracoes';
import slProposta from './slProposta';

export default {
    name: 'slPropostaDiff',
    data: function () {
        return {
            dadosAtuais: {
                type: Object,
                default: function () {
                    return {}
                }
            },
            dadosHistorico: {
                type: Object,
                default: function () {
                    return {}
                }
            }
        };
    },
    props: ['idpreprojeto', 'tipo'],
    components: {
        slPropostaAlteracoes,
        slProposta,
    },
    mounted: function () {
        if (typeof this.idpreprojeto !== 'undefined') {
            this.buscar_dados();
        }
    },
    methods: {
        buscar_dados: function () {
            const self = this;
            /* eslint-disable */
            $3.ajax({
                url: '/proposta/visualizar/obter-proposta-cultural-versionamento/idPreProjeto/' + self.idpreprojeto +
                '/tipo/' + self.tipo
            }).done(function (response) {
                self.dadosAtuais = response.data.atual;
                self.dadosHistorico = response.data.historico;
            });
        }
    }
};
</script>