<template>
    <div class="page-title">
        <div class="row">
            <div class="col s12 m9 l10">
                <h1 v-html="titulo"></h1>
            </div>
            <div class="col s12 m3 l2 right-align">
                <a @click="voltar()"
                   title="P&aacute;gina Anterior"
                   class="btn small grey lighten-3 grey-text z-depth-0 chat-toggle"
                ><i class="material-icons">arrow_back</i>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  name: "TituloPagina",
  props: ["titulo"],
  methods: {
    voltar() {
      window.history.length > 1 ? this.$router.go(-1) : this.$router.push("/");
    },
  },
};
</script>