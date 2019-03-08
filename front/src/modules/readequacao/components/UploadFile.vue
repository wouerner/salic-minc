<template>
<v-container fluid>
<v-layout row wrap>   
    <v-flex xs4 offset>
        <v-card
        elevation=10
        >
            <file-pond
                name="upload"
                ref="pond"
                label-idle="<span class='subheading'></span>"
                accepted-file-types="formatosAceitos"
                labelInvalidField="Tipo de arquivo inválido. Somente é permitido arquivo PDF"
                :files="arquivo"
                allowImagePreview="false"
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
        formatosAceitos: '',
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
    },
};
</script>
