<template>
    <div>
        <Carregando v-if="loading"></Carregando>
        <div id="template-ajax"></div>
    </div>
</template>

<script>
import Carregando from "@/components/Carregando";

export default {
  name: "CarregarTemplateAjax",
  components: {
    Carregando
  },
  data() {
    return {
      active: true,
      loading: true
    };
  },
  props: {
    urlAjax: ""
  },
  mounted() {
    if (typeof this.urlAjax != "undefined" && this.urlAjax != "") {
      this.obterTemplate();
    }
  },
  methods: {
    obterTemplate() {
      let self = this;
      if (self.urlAjax == "") {
        return;
      }

      let elmRetorno = $3("#template-ajax");
      $3.ajax({
        url: self.urlAjax,
        success(data) {
          elmRetorno.html(data);
          self.loading = false;
        },
        type: 'post',
      });
    },
  },
};
</script>
