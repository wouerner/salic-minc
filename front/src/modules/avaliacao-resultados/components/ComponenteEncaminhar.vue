<template>
    <div>
     <v-app>
      <v-content>
        <v-container>
         <v-card>
          <v-card-media
            src="https://cdn.vuetifyjs.com/images/cards/desert.jpg"
            height="200px"
          ></v-card-media>
          <v-card-title primary-title>
            <div>
              <h3 class="headline mb-0">Kangaroo Valley Safari</h3>
              <div>Located two hours south of Sydney in the <br>Southern Highlands of New South Wales, ...</div>
            </div>
          </v-card-title>
          <v-card-actions>
            <v-btn flat color="orange">Share</v-btn>
            <v-btn flat color="orange">Explore</v-btn>
          </v-card-actions>
        </v-card>
        </v-container>
      </v-content>
    </v-app>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Modal from '@/components/modal';

export default {
    name: 'ListBar',
    created() {
        this.obterDadosTabela();
    },
    components: {
        Modal,
    },
    computed: {
        ...mapGetters({
            dadosTabela: 'foo/dadosTabela',
            modalVisible: 'modal/default',
        }),
    },
    methods: {
        ...mapActions({
            obterDadosTabela: 'foo/obterDadosTabela',
            setRegistroAtivo: 'foo/setRegistroAtivo',
            removerRegistro: 'foo/removerRegistro',
            modalOpen: 'modal/modalOpen',
            modalClose: 'modal/modalClose',
        }),
        confirmationRemove(registro) {
            const currentConfirm = confirm;
            const trueResponse = currentConfirm('Deseja removerr esse registro?');

            if (trueResponse) {
                this.removerRegistro(registro);
            }
        },
    },
};
</script>

<style>
.atualizar-action {
    display:inline-block;
    margin-right:1px;
    width: 150px;
}

.remover-action {
    display:inline-block;
    width: 150px;
}
</style>
