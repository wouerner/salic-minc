<template>
    <div class="incentivo">
        <Carregando v-if="carregando" :text="'Validando acesso ao projeto'"></Carregando>
        <div v-if="Object.keys(projeto).length > 0 && projeto.permissao">
            <SidebarMenu :url-ajax="urlAjax"></SidebarMenu>
            <div class="container-fluid">
                <TituloPagina :titulo="$route.meta.title"></TituloPagina>
                <router-view></router-view>
            </div>
            <MenuSuspenso/>
        </div>
        <div v-if="permissao == false">
            <SalicMensagemErro :texto="'Sem permiss&atilde;o de acesso para este projeto'" />
        </div>
    </div>
</template>
<script>
import SidebarMenu from "@/components/SidebarMenu";
import Carregando from "@/components/Carregando";
import TituloPagina from "@/components/TituloPagina";
import SalicMensagemErro from "@/components/SalicMensagemErro";
import MenuSuspenso from "../components/MenuSuspenso";
import { mapActions, mapGetters } from "vuex";
import { utils } from "@/mixins/utils";

const URL_MENU = "/projeto/menu/obter-menu-ajax/idPronac/";

export default {
  name: "Index",
  components: {
    SidebarMenu,
    TituloPagina,
    MenuSuspenso,
    Carregando,
    SalicMensagemErro
  },
  mixins: [utils],
  data() {
    return {
      urlAjax: URL_MENU + this.$route.params.idPronac,
      carregando: true,
      permissao: true
    };
  },
  watch: {
    $route(to, from) {
      /**
       * se o alterar apenas o parametro na url, o vue n�o recarrega o componente.
       * aqui est� recarregando os dados do novo projeto se o idPronac for diferente
       * */
      if (
        typeof to.params.idPronac !== 'undefined' &&
        to.params.idPronac !== from.params.idPronac
      ) {
        this.buscaProjeto(to.params.idPronac);
        this.urlAjax = URL_MENU + to.params.idPronac;
      }
    }
  },
  created() {
    if (
      typeof this.$route.params.idPronac !== 'undefined' &&
      Object.keys(this.dadosProjeto).length === 0
    ) {
      this.buscaProjeto(this.$route.params.idPronac);
    }
  },
  methods: {
    ...mapActions({
      buscaProjeto: 'projeto/buscaProjeto',
    }),
  },
  computed: {
    ...mapGetters({
      dadosProjeto: 'projeto/projeto',
    }),
    projeto() {
      if (Object.keys(this.dadosProjeto).length > 0) {
        this.carregando = false;
        this.permissao = this.dadosProjeto.permissao;
      }

      return this.dadosProjeto;
    },
  },
};
</script>
