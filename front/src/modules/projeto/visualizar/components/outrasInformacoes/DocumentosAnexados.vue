<template>
    <div id="conteudo" v-if="dados.documentos">
        <IdentificacaoProjeto
            :pronac="dadosProjeto.Pronac"
            :nomeProjeto="dadosProjeto.NomeProjeto">
        </IdentificacaoProjeto>
        <table v-if="Object.keys(dados.documentos).length > 0">
            <thead>
            <tr class="destacar">
                <th class="center">N&ordm;</th>
                <th class="center">CLASSIFICA&ccedil;&atilde;O</th>
                <th class="center">DATA</th>
                <th class="center">TIPO DE DOCUMENTO</th>
                <th class="center">DOCUMENTO</th>
            </tr>
            </thead>
            <tbody v-for="(dado, index) in dados.documentos" :key="index">
            <tr>
                <td class="center">{{ index + 1 }}</td>
                <td class="center">{{ dado.Anexado }}</td>
                <td class="center">{{ dado.Data }}</td>
                <td class="center">{{ dado.Descricao }}</td>
                <td class="center">
                    <a class="" :href="`/consultardadosprojeto/abrir-documentos-anexados?id=${dado.idArquivo}&tipo=${dado.AgenteDoc}&idPronac=${dadosProjeto.idPronac}`"
                       target="_blank"
                        data-position="top" data-delay="50" data-tooltip="Visualizar">
                        {{ dado.NoArquivo }}
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
        <div v-else>
            <fieldset>
                <legend>Certid&otilde;es Negativas</legend>
                <div class="center">
                    <em>Dados n&atilde;o  informado.</em>
                </div>
            </fieldset>
        </div>
    </div>
</template>
<script>
    import { mapGetters } from 'vuex';
    import IdentificacaoProjeto from './IdentificacaoProjeto';

    export default {
        name: 'DocumentosAnexados',
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
                informacoes: {},
            };
        },
        mounted() {
            if (typeof this.dadosProjeto.idPronac !== 'undefined') {
                this.buscar_dados();
            }
        },
        watch: {
            dados(value) {
                this.informacoes = value.informacoes;
            },
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
                    url: '/projeto/documentos-anexados-rest/index/idPronac/' + self.dadosProjeto.idPronac,
                }).done(function (response) {
                    self.dados = response.data;
                });
            },
        },
    }
</script>
