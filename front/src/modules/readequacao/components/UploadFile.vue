<template>
    <v-container fluid>
        <v-layout
            row
            wrap
        >
            <v-flex xs3>
                <v-card elevation="4">
                    <file-pond
                        ref="pond"
                        :accepted-file-types="formatosAceitos"
                        :files="arquivo"
                        name="upload"
                        label-idle="<span class='subheading'>CARREGAR ARQUIVO</span>"
                        label-file-type-not-allowed="Tipo de arquivo inválido."
                        file-validate-type-label-expected-types="Somente {allTypes} serão aceitos."
                        label-button-remove-item="Excluir"
                        label-button-process-item="Upload"
                        allow-image-preview="false"
                        @removefile="arquivoAnexado"
                        @addfile="arquivoAnexado"
                    />
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import vueFilePond from 'vue-filepond';
import 'filepond/dist/filepond.min.css';

const FilePond = vueFilePond(FilePondPluginFileValidateType);

export default {
    name: 'UploadFile',
    components: {
        FilePond,
    },
    props: {
        formatosAceitos: { type: String, default: 'application/pdf' },
    },
    data() {
        return {
            arquivo: [],
        };
    },
    computed: {},
    methods: {
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
