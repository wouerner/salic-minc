<template>
    <div id="conteudo">
        <div v-if="dados.Encaminhamentos">
            <IdentificacaoProjeto
                    :pronac="dadosProjeto.Pronac"
                    :nomeProjeto="dadosProjeto.NomeProjeto">
            </IdentificacaoProjeto>
            <table class="tabela" v-if="dados.Encaminhamentos.length > 0">
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
            <div v-else>
                <fieldset>
                    <legend>Hist&oacute;rico Encaminhamento</legend>
                    <div class="center">
                        <em>Dados n&atilde;o informado.</em>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapActions, mapGetters } from 'vuex';
    import IdentificacaoProjeto from './IdentificacaoProjeto';

    export default {
        name: 'HistoricoEncaminhamento',
        components: {
            IdentificacaoProjeto,
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
                dados: 'projeto/historicoEncaminhamento',
            }),
        },
        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                this.buscarHistoricoEncaminhamento(this.dadosProjeto.idPronac);
            }
        },
        methods: {
            ...mapActions({
                buscarHistoricoEncaminhamento: 'projeto/buscarHistoricoEncaminhamento',
            }),
        },
    };
</script>

