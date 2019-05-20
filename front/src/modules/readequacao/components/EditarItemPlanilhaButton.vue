<template>
    <v-layout>
        <v-btn
            color="info"
            @click="dialog = true"
        >
            <v-tooltip bottom>
                <v-icon slot="activator">edit</v-icon>
                <span>Editar item</span>
            </v-tooltip>
        </v-btn>
        <v-dialog
            v-model="dialog"
            hide-overlay
            transition="dialog-bottom-transition"
            @keydown.esc="dialog = false"
        >
            <v-card>
                edição
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
export default {
    name: 'EditarItemPlanilhaButton',
    props: {
        item: {
            type: [Array, Object],
            default: () => {},
        },
    },
    data() {
        return {
            dialog: false,
        };
    },
};
</script>
