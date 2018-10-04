<template>
    <div id="conteudo">
        <div v-if="dados.informacoes">
            <IdentificacaoProjeto :pronac="dados.informacoes.Pronac"
                                  :nomeProjeto="dados.informacoes.NomeProjeto">
            </IdentificacaoProjeto>
            <div v-if="dados.Encaminhamentos.length > 0">
                <table class="tabela">
                    <thead>
                        <tr class="destacar">
                            <th class="center">PRODUTO</th>
                            <th class="center">UNIDADE</th>
                            <th class="center">OBSERVA&Ccedil;&Atilde;O</th>
                            <th class="center">DT. ENVIO</th>
                            <th class="center">DT. RETORNO</th>
                            <th class="center">QT. DIAS</th>
                        </tr>
                    </thead>
                        <tbody v-for="(dado, index) in dados.Encaminhamentos" :key="index">
                            <tr>
                                <td class="center">{{ dado.Produto }}</td>
                                <td class="center">{{ dado.Unidade }}</td>
                                <td class="center" v-html="dado.Observacao">{{ dado.Observacao }}</td>
                                <td class="center">{{ dado.DtEnvio }}</td>
                                <td class="center">{{ dado.DtRetorno }}</td>
                                <td class="center">{{ dado.qtDias }}</td>
                            </tr>
                        </tbody>
                </table>
            </div>
            <div v-else><h3>Sem Encaminhamentos.</h3></div>
        </div>
    </div>
</template>
<script>
import IdentificacaoProjeto from './IdentificacaoProjeto';
export default {
    name: 'HistoricoEncaminhamento',
    props: ['idPronac'],
    components: {
        IdentificacaoProjeto,
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
                url: '/projeto/historico-encaminhamento-rest/index/idPronac/' + idPronac,
            }).done(function (response) {
                self.dados = response.data;
            });
        },
    },
}
</script>

