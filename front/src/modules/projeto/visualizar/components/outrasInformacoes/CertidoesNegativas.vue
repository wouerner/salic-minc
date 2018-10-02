<template>
    <div id="conteudo">
        <div v-if="dados.informacoes">
            <IdentificacaoProjeto :pronac="dados.informacoes.Pronac"
                                  :nomeProjeto="dados.informacoes.NomeProjeto">
            </IdentificacaoProjeto>
            <table class="tabela">
                <thead>
                    <tr class="destacar">
                        <th class="center">CERTID&otilde;es</th>
                        <th class="center">DATA DE EMISS&Atilde;O</th>
                        <th class="center">DATA DE VALIDADE</th>
                        <th class="center">PRONAC</th>
                        <th class="center">SITUA&Ccedil;&Atilde;O</th>
                    </tr>
                </thead>
                <tbody v-for="(dado, index) in dados.certidoes" :key="index">
                    <tr>
                        <td class="center">{{ dado.dsCertidao }}</td>
                        <td class="center">{{ dado.DtEmissao }}</td>
                        <td class="center">{{ dado.DtValidade }}</td>
                        <td class="center">{{ dado.Pronac }}</td>
                        <td class="center" v-if="dado.Situacao" >
                            {{ dado.Situacao }}
                        </td>
                        <td class="center" v-else>
                            Vencida
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import IdentificacaoProjeto from './IdentificacaoProjeto';
export default {
    name: 'CertidoesNegativas',
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
                url: '/projeto/certidoes-negativas-rest/index/idPronac/' + idPronac,
            }).done(function (response) {
                self.dados = response.data;
            });
        },
    },
}
</script>

