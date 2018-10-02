<template>
    <div id="conteudo">
        <div v-if="dados.informacoes">
            <table class="tabela">
                <thead>
                    <tr class="destacar">
                        <th class="center">PRONAC</th>
                        <th class="center">Nome do Projeto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="center">{{ dados.informacoes.Pronac }}</td>
                        <td class="center">{{ dados.informacoes.NomeProjeto }}</td>
                    </tr>
                </tbody>
            </table>
            <fieldset>
                <legend>Local de Realiza&ccedil;&atilde;o</legend>
                <table class="tabela">
                <thead>
                    <tr class="destacar">
                        <th class="center">Pa&iacute;s</th>
                        <th class="center">UF</th>
                        <th class="center">Cidade</th>
                    </tr>
                </thead>
                <tbody v-for="(dado, index) in dados.localRealizacoes" :key="index">
                    <tr>
                        <td class="center">{{ dado.Descricao }}</td>
                        <td class="center">{{ dado.UF }}</td>
                        <td class="center">{{ dado.Cidade }}</td>
                    </tr>
                </tbody>
            </table>
            </fieldset>
            <fieldset>
                <legend>Deslocamento</legend>
                <div v-if="dados.Deslocamento.length > 0">
                    <table class="tabela">
                        <thead>
                            <tr class="destacar">
                                <th class="center">Pa&iacute;s de Origem</th>
                                <th class="center">UF de Origem</th>
                                <th class="center">Cidade de Origem</th>
                                <th class="center">Pa&iacute;s de Destino</th>
                                <th class="center">UF de Destino</th>
                                <th class="center">Cidade de Destino</th>
                                <th class="center">Quantidade</th>
                            </tr>
                        </thead>
                        <tbody v-for="(dado, index) in dados.Deslocamento" :key="index">
                            <tr>
                                <td class="center">{{ dado.PaisOrigem }}</td>
                                <td class="center">{{ dado.UFOrigem }}</td>
                                <td class="center">{{ dado.MunicipioOrigem }}</td>
                                <td class="center">{{ dado.PaisDestino }}</td>
                                <td class="center">{{ dado.UFDestino }}</td>
                                <td class="center">{{ dado.MunicipioDestino }}</td>
                                <td class="center">{{ dado.Qtde }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else class="center" ><em>Dados N&atilde;o Informados.</em></div>
            </fieldset>
        </div>
    </div>
</template>
<script>
export default {
    name: 'LocalRealizacaoDeslocamento',
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
                url: '/projeto/local-realizacao-deslocamento-rest/index/idPronac/' + idPronac,
            }).done(function (response) {
                self.dados = response.data;
            });
        },
    },
}
</script>

