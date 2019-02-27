<template>
<v-container fluid>
  <v-layout row wrap>
    <v-flex xs10 md5>
      <v-card height="130px">
	<v-card-title class="grey lighten-2">Versão original</v-card-title>
	<v-divider/>
	<v-card-text>
	  {{ campo.valor }}
	</v-card-text>
      </v-card>
    </v-flex>
    <v-flex xs10 md5 offset-md1>
      <v-card height="130px">
	<v-card-title class="green lighten-2">Versão readequada</v-card-title>
        <v-card-actions>
	  <v-date-picker
            v-model="date"
            ></v-date-picker>
        </v-card-actions>
      </v-card>
    </v-flex>
  </v-layout>
</v-container>
</template>
<script>
export default {
    name: 'TemplateDate',
    props: {
	campo: { Object: () => {} },
    },
    data() {
        return {
            date: ''
        }
    },
    created() {
        this.date = this.formatDate(this.campo.valor);
    },
    methods: {
        formatDate(val) {
            let formatedDate = new Date(val);//.toISOString().valor.substr(0, 10);
            console.log(formatedDate);
            return formatedDate;
        }
    }
}
</script>
