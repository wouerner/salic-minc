<template>
    <v-layout row wrap> 
        <v-flex xs1 offset-xs11>
            <v-btn
                color="green darken-1"
                @click="dialog = true"
                dark
            >CRIAR
                <v-icon right dark>add</v-icon>
            </v-btn>  
        </v-flex>
        
        <v-flex xs4 offset-xs4>
            <v-dialog 
                v-model="dialog"
                transition="dialog-bottom-transition"
                width="450"
            >
                <v-card v-if="getTiposDisponiveis" class="pa-3">
                    <v-card-title class="headline green darken-4 white--text">Nova Readequação</v-card-title>
                    <v-card-text>
                        <v-select
                            v-model="idTipoReadequacao"
                            :items="getTiposDisponiveis"
                            item-text=descricao
                            item-value=idTipoReadequacao
                            label="Escolha o tipo de readequação"
                            solo
                        >
                        </v-select>
                    </v-card-text>
                    <v-card-actions>

                        <v-btn
                            color="red darken-1"
                            flat="flat"
                            @click="dialog = false"
                          >
                          Cancelar
                        </v-btn>
                      
                        <v-spacer/>
                        <v-btn
                            :disabled="this.idTipoReadequacao == ''"
                            color="green darken-1"
                            @click="criarReadequacao"
                            dark
                        >CRIAR
                        </v-btn> 
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-flex>
    </v-layout>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
    name: "CriarReadequacao",
    props: {
        idPronac: ''
    },
    data() {
        return {
            dialog: false,
            idTipoReadequacao: '',
        };
    },
    computed: {
        ...mapGetters({
            getTiposDisponiveis: "readequacao/getTiposDisponiveis",
        })
    },
    methods: {
        ...mapActions({
            obterTiposDisponiveis: "readequacao/obterTiposDisponiveis",
            inserirReadequacao: "readequacao/inserirReadequacao",
        }),
        criarReadequacao() {
            const idPronac = this.idPronac;
            const idTipoReadequacao = this.idTipoReadequacao;
            this.inserirReadequacao({ idPronac, idTipoReadequacao });
            this.dialog = false;
            this.$emit('criar-readequacao', { idTipoReadequacao });
        },
    },
    watch: {
        idPronac() {
            const idPronac = this.idPronac;
            this.obterTiposDisponiveis({ idPronac });
        }
    }
}
</script>
