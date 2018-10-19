<template>
    <div id="conteudo">
        <table v-if="dados">
            <thead>
            <tr class="destacar">
                <th class="center">PRONAC</th>
                <th class="center">NOME DO PROJETO</th>
                <th class="center">ATO ADMINISTRATIVO</th>
                <th class="center">DATA</th>
                <th class="center">VER</th>
            </tr>
            </thead>
            <tbody v-for="(dado, index) in dados" :key="index">
            <tr>
                <td class="center">
                    <router-link :to="{ name: 'dadosprojeto', params: { idPronac: dado.IdPRONAC }}" class='waves-effect waves-dark btn white black-text'>
                        <u>{{ dado.pronac }}</u>
                    </router-link>
                </td>
                <td class="center">{{ dado.nomeProjeto }}</td>
                <td class="center">{{ dado.dsAtoAdministrativo }}</td>
                <td class="center">{{ dado.dt_criacao }}</td>
                <td class="center">
                <a class="btn waves-effect waves-light tooltipped small white-text" :href="`/assinatura/index/visualizar-documento-assinado/idPronac/${dado.IdPRONAC}?idDocumentoAssinatura=${dado.idDocumentoAssinatura}`"
                   target="_blank"
                    data-position="top" data-delay="50" data-tooltip="Visualizar">
                    <i class="material-icons">search</i>
                </a>
                </td>
            </tr>
            </tbody>
        </table>
        <div v-else>
            <fieldset>
                <legend>Documentos assinados</legend>
                <div class="center">
                    <em>Sem documentos assinados para este projeto.</em>
                </div>
            </fieldset>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'DocumentosAssinados',
        props: ['idPronac'],
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
                const idPronac = self.$route.params.idPronac;
                /* eslint-disable */
                $3.ajax({
                    url: '/projeto/documentos-assinados-rest/index/idPronac/' + idPronac,
                }).done(function (response) {
                    self.dados = response.data;
                });
            },
        },
    }
</script>
