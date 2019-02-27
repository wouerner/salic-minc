<template>
<v-container fluid>
  <v-layout row wrap>
    <v-flex xs10 md5>
      <v-card>
	<v-card-title class="grey lighten-2">Versão original</v-card-title>
	<v-divider/>
	<v-card-text>
	  {{ campoEdicao }}
	</v-card-text>
      </v-card>
    </v-flex>
    <v-flex xs10 md5 offset-md1>
      <v-card>
	<v-card-title class="grey lighten-2">Versão readequada</v-card-title>
	<EditorTexto
          :style="''"
          :value="campoEdicao"
	  @editor-texto-input="salvar"
          ></EditorTexto>
      </v-card>
    </v-flex>
  </v-layout>
</v-container>
</template>
<script>
import EditorTexto from '../../avaliacaoResultados/components/components/EditorTexto';

export default {
    name: 'TemplateTextarea',
    components: {
	EditorTexto,
    },
    data() {
	return {
	    
	};
    },
    props: {
	campoEdicao: { String: "" },
	dadosReadequacao: { Object: () => {} },
    },
    computed: {
    },
    methods: {
	salvar(e) {
	    console.log(e);
	},
	validar(e) {
	    
	},
    },
};
</script>
