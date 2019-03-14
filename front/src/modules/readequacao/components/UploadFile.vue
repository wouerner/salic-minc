<template>
  <v-container fluid>
    <v-layout row wrap>
      <v-flex xs3>
        <v-card elevation="4">
          <file-pond
            name="upload"
            ref="pond"
            label-idle="<span class='subheading'>CARREGAR ARQUIVO</span>"
            labelFileTypeNotAllowed="Tipo de arquivo inválido."
            fileValidateTypeLabelExpectedTypes="Somente {allTypes} serão aceitos."
            labelButtonRemoveItem="Excluir"
            :accepted-file-types="formatosAceitos"
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

const FilePond = vueFilePond(FilePondPluginFileValidateType);

export default {
  name: "UploadFile",
  components: {
    FilePond
  },
  props: {
    formatosAceitos: { type: String, default: "application/pdf" }
  },
  data() {
    return {
      arquivo: []
    };
  },
  computed: {},
  methods: {
    arquivoAnexado() {
      if (this.$refs.pond.getFiles()[0]) {
        let payload = this.$refs.pond.getFiles()[0].file;
        this.$emit("arquivo-anexado", payload);
      } else {
        this.$emit("arquivo-anexado", undefined);
      }
    }
  }
};
</script>
