<template>
<v-container fluid>
<v-layout row wrap>   
    <v-flex xs3>
        <v-card
        elevation=10
        >
            <file-pond
                name="upload"
                ref="pond"
                label-idle="<span class='subheading'>CARREGAR ARQUIVO</span>"
                accepted-file-types="application/pdf"
                labelInvalidField="Tipo de arquivo inválido. Somente é permitido arquivo PDF"
                :files="arquivo"
                allowImagePreview="false"
                @removefile="arquivoAnexado"
                @addfile="arquivoAnexado"
            />
        </v-card>    
    </v-flex>
</v-layout>    
</v-container>
</template>

<script>
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
);

export default {
    name: 'UploadFile',
    components: {
        FilePond
    },
    props: {
        formatosAceitos: "'application/pdf'",
        label: 'CARREGAR ARQUIVO'
    },
    data() {
        return {
            arquivo: []
        };
    },
    computed: {
    },
    methods: {
        arquivoAnexado() {
            let payload = this.$refs.pond.getFiles()[0];
            this.$emit('arquivo-anexado', payload);
        }
    },
};
</script>
