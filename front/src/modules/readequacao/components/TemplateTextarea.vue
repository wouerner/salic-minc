<template>
<v-layout row>
  <v-flex xs5 offset-xs1>
    <v-card>
      Original
      <EditorTexto
        :style="''"
        :value="campoEdicao"
	disabled
        ></EditorTexto>
    </v-card>
  </v-flex>
  <v-flex xs5>
    <v-card>
      Readequação
      <EditorTexto
        :style="''"
        :value="campoEdicao"
        ></EditorTexto>
    </v-card>    
  </v-flex>
</v-layout>
</template>
<script>
import EditorTexto from '../../avaliacaoResultados/components/components/EditorTexto';

export default {
    name: 'TemplateTextarea',
    components: {
	EditorTexto,
    },
    props: {
	campoEdicao: { String: "" },
	dadosReadequacao: { Object: () => {} },
    },
    computed: {
    },
    methods: {
    },
};
</script>
