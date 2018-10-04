<template>
    <div id="conteudo">
        <IdentificacaoProjeto
            :pronac="informacoes.Pronac"
            :nomeProjeto="informacoes.NomeProjeto">
        </IdentificacaoProjeto>
        <table>
            <thead>
            <tr class="destacar">
                <th class="center">N°</th>
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
                <a class="" :href="`/consultardadosprojeto/abrir-documentos-anexados?id=${dado.idArquivo}&tipo=${dado.AgenteDoc}&idPronac=${dados.informacoes.idPronac}`"
                   target="_blank"
                    data-position="top" data-delay="50" data-tooltip="Visualizar">
                    {{ dado.NoArquivo }}
                </a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
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
            if (typeof this.$route.params.idPronac !== 'undefined') {
                this.buscar_dados();
            }
        },
        watch: {
            dados(value) {
                this.informacoes = value.informacoes;
            },
        },
        methods: {
            buscar_dados() {
                const self = this;
                const idPronac = self.$route.params.idPronac;
                /* eslint-disable */
                $3.ajax({
                    url: '/projeto/documentos-anexados-rest/index/idPronac/' + idPronac,
                }).done(function (response) {
                    self.dados = response.data;
                    // self.informacoes = response.data.informacoes;
                });
            },
        },
    }
</script>
