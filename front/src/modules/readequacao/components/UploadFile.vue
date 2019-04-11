<template>
    <div v-if="loading">
        <carregando/>
    </div>
    <v-card
        v-else
        elevation="4"
      >
      <file-pond
            ref="pond"
            :server="server"
            :files="arquivo"
            :accepted-file-types="formatosAceitos"
            name="upload"
            label-idle="<span class='subheading'>CARREGAR ARQUIVO</span>"
            label-file-type-not-allowed="Tipo de arquivo inválido."
            file-validate-type-label-expected-types="Somente {allTypes} serão aceitos."
            label-button-remove-item="Excluir"
            label-button-process-item="Upload"
            allow-image-preview="false"
            @removefile="arquivoAnexado()"
            @processfile="arquivoAnexado()"
        />
    </v-card>
</template>

<script>
import _ from 'lodash';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import vueFilePond from 'vue-filepond';
import 'filepond/dist/filepond.min.css';
import { mapActions, mapGetters } from 'vuex';
import Carregando from '@/components/CarregandoVuetify';

const FilePond = vueFilePond(FilePondPluginFileValidateType);

export default {
    name: 'UploadFile',
    components: {
        Carregando,
        FilePond,
    },
    props: {
        formatosAceitos: {
            type: String,
            default: 'application/pdf',
        },
        arquivoInicial: {
            type: [
                Blob,
                Object,
            ],
            default() {},
        },
        idDocumento: {
            type: [
                Number,
                String,
            ],
            default: 0,
        },
    },
    data() {
        return {
            arquivo: [],
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort) => {
                    const request = new XMLHttpRequest();
                    request.open('POST', '/');
                    request.abort();
                    progress(true, 0, 1024);
                    load(file);
                    return {
                        abort: () => {
                            // Let FilePond know the request has been cancelled
                            abort();
                        },
                    };
                },
                load: null,
                revert: null,
                fetch: null,
            },
            loading: true,
        };
    },
    computed: {
        ...mapGetters({
            getDocumentoReadequacao: 'readequacao/getDocumentoReadequacao',
        }),
    },
    watch: {
        arquivoInicial() {
            if (!_.isNull(this.arquivoInicial)) {
                if (this.$refs.pond.getFiles().length < 1) {
                    //console.log(typeof this.arquivoInicial);
                    this.loading = false;
                    this.arquivo = [this.arquivoInicial];
                }
            }
        },
    },
    created() {
        if (!this.idDocumento
            || this.idDocumento === 0) {
            this.loading = false;
        }
    },
    methods: {
        ...mapActions({
            obterDocumento: 'readequacao/obterDocumento',
        }),
        arquivoAnexado() {
            if (this.$refs.pond.getFiles()[0]) {
                const payload = this.$refs.pond.getFiles()[0].file;
                this.$emit('arquivo-anexado', payload);
            } else {
                this.$emit('arquivo-removido', undefined);
            }
        },
    },
};
</script>
