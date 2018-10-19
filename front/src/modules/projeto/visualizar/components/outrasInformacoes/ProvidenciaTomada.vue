<template>
    <div id="conteudo">
        <div v-if="dados.providenciaTomada">
            <table class="tabela">
                <thead>
                <tr class="destacar">
                    <th class="center">DT. SITUA&Ccedil;&Atilde;O</th>
                    <th class="center">SITUA&Ccedil;&Atilde;O</th>
                    <th class="center">PROVID&Ecirc;NCIA TOMADA</th>
                    <th class="center">CPF</th>
                    <th class="center">NOME</th>
                </tr>
                </thead>
                <tbody v-for="(dado, index) in dados.providenciaTomada" :key="index">
                <tr>
                    <td class="center">{{ dado.DtSituacao }}</td>
                    <td class="center">{{ dado.Situacao }}</td>
                    <td class="center">{{ dado.ProvidenciaTomada }}</td>
                    <td class="center">{{ dado.cnpjcpf }}</td>
                    <td class="center">{{ dado.usuario }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div v-else>
            <fieldset>
                <legend>Provid&ecirc;ncia Tomada</legend>
                <div class="center">
                    <em>Dados n&atilde;o informado.</em>
                </div>
            </fieldset>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex';
    import IdentificacaoProjeto from './IdentificacaoProjeto';

    export default {
        name: 'ProvidenciaTomada',
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
                    url: '/projeto/providencia-tomada-rest/index/idPronac/' + self.dadosProjeto.idPronac,
                }).done(function (response) {
                    self.dados = response.data;
                });
            },
        },
    }
</script>

