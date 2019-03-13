<template>
  <v-container fluid>
    <v-layout row wrap>
      <v-flex xs10 md5>
        <v-card height="336px">
          <v-card-title class="grey lighten-2">Versão original</v-card-title>
          <v-divider/>
          <v-card-text>{{ campo.valor }}</v-card-text>
        </v-card>
      </v-flex>
      <v-flex xs10 md6 offset-md1>
        <v-card height="336px">
          <v-card-title class="green lighten-2">Versão readequada</v-card-title>
          <EditorTexto :style="''" @editor-texto-input="salvarInput($event)"></EditorTexto>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
import EditorTexto from "../../avaliacaoResultados/components/components/EditorTexto";

export default {
  name: "TemplateTextarea",
  components: {
    EditorTexto
  },
  data() {
    return {};
  },
  props: {
    campo: { Object: () => {} },
    dadosReadequacao: { Object: () => {} }
  },
  computed: {},
  methods: {
    salvarInput(e) {
      this.$emit('dados-update', e);
    }
  }
};
</script>
