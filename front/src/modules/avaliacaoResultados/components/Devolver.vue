<template>
    <v-dialog
        v-model="dialog"
        width="650"
    >
        <v-tooltip slot="activator" bottom>
            <v-btn 
                slot="activator"
                color="green lighten-2"
                text="white"
                flat
                icon
                light
                @click.native="setDevolverProjeto({ idPronac: idPronac, atual: atual, proximo: proximo })"
            >
                <v-icon class="material-icons">replay</v-icon>
            </v-btn>
            <span>Devolver Projeto</span>
        </v-tooltip>
        <v-card>
            <v-card-text>
                Você devolverá o projeto para o técnico.
            </v-card-text>
            <v-card-actions>
                <v-btn
                    color="success"
                    flat
                    block
                    @click="dialog = false"
                >
                    Ok
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import { mapActions } from 'vuex';
    import Modal from '@/components/modal';

    export default {
        name: 'Devolver',
        data() {
            return {
                dialog: false,
            };
        },
        props: {
            idPronac: String,
            atual: String,
            proximo: String,
        },
        components: {
            Modal,
        },
        methods: {
            ...mapActions({
                setDevolverProjeto: 'avaliacaoResultados/devolverProjeto',
            }),
        },
    };
</script>
