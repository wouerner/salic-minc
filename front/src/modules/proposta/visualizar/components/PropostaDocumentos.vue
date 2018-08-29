<template>
    <div class="documentos-anexados">
        <div class="card">
            <div class="card-content">
                <h5>Documentos da Proposta</h5>
                <table v-if="documentos.proposta && documentos.proposta.length > 0" class="bordered responsive-table">
                    <thead>
                    <tr>
                        <th>Documento</th>
                        <th>Data envio</th>
                        <th>Arquivo</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="documento in documentos.proposta">
                        <td>{{ documento.Descricao }}</td>
                        <td>{{ formatar_data(documento.Data) }}</td>
                        <td>
                            <a :href="get_url(documento.idDocumentosPreProjetos, documento.tpDoc)" title="Abrir arquivo">{{documento.NoArquivo}}</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div v-else>Nenhum documento da proposta</div>
            </div>
        </div>

        <div class="card">
            <div class="card-content">
                <h5>Documentos do Proponente</h5>
                <table v-if="documentos.proponente && documentos.proponente.length > 0" class="bordered responsive-table">
                    <thead>
                    <tr>
                        <th>Documento</th>
                        <th>Data envio</th>
                        <th>Arquivo</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="documento in documentos.proponente">
                        <td>{{ documento.Descricao }}</td>
                        <td>{{ formatar_data(documento.Data) }}</td>
                        <td>
                            <a :href="get_url(documento.idDocumentosAgentes, documento.tpDoc)" title="Abrir arquivo">{{ documento.NoArquivo }}</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div v-else>Nenhum documento do proponente</div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment';
import { mapActions, mapGetters } from 'vuex';

export default {
    name: 'PropostaDocumentos',
    props: ['proposta'],
    mounted() {
        if (typeof this.proposta !== 'undefined') {
            this.buscaDocumentos(this.proposta);
        }
    },
    watch: {
        proposta(value) {
            this.buscaDocumentos(value);
        },
    },
    computed: {
        ...mapGetters({
            documentos: 'proposta/documentos',
        }),
    },
    methods: {
        ...mapActions({
            buscaDocumentos: 'proposta/buscaDocumentos',
        }),
        formatar_data(date) {
            date = moment(date).format('DD/MM/YYYY');

            return date;
        },
        get_url(id, tipo) {
            return `/admissibilidade/admissibilidade/abrir-documentos-anexados-admissibilidade/?id=${id}&tipo=${tipo}`;
        },
    },
};
</script>
