<template>
    <div id="conteudo">
        <div v-if="dados.certidoes">
            <IdentificacaoProjeto :pronac="dadosProjeto.Pronac"
                                  :nomeProjeto="dadosProjeto.NomeProjeto">
            </IdentificacaoProjeto>
            <div v-if="Object.keys(dados.certidoes).length > 0">
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
            <div v-else>
                <fieldset>
                    <legend>Certid&otilde;es Negativas</legend>
                    <div class="center">
                        <em>Dados n&atilde;o  informado.</em>
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
    name: 'CertidoesNegativas',
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
        if (typeof this.dadosProjeto.idPronac !== 'undefined') {
            this.buscar_dados();
        }
    },
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
        }),
    },
    methods: {
        buscar_dados() {
            const self = this;
            /* eslint-disable */
            $3.ajax({
                url: '/projeto/certidoes-negativas-rest/index/idPronac/' + self.dadosProjeto.idPronac,
            }).done(function (response) {
                self.dados = response.data;
            });
        },
    },
}
</script>

