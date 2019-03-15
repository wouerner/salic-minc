<template>
<v-container fluid>
<v-layout row wrap>
    <v-flex xs12>
        <v-card>
            <EditorTexto
                :style="''"
                :value="dadosReadequacao.dsJustificativa"
                required="required"
                @editor-texto-input="atualizarForm($event)"
            ></EditorTexto>
        </v-card>
    </v-flex>
</v-layout>
</v-container>
</template>

<script>
import EditorTexto from '../../avaliacaoResultados/components/components/EditorTexto';

export default {
    name: 'FormReadequacao',
    components: {
        EditorTexto,
    },
    props: {
	dadosReadequacao: { type: Object, default: () => {} },
    },
    data() {
        return {
            dialog: false,
            dadosTipoReadequacao: {
                data: "A expectativa de público que irá frequentar a biblioteca é de aproximadamente 2.000 pessoas. O acesso será totalmente gratuito."
            }
        };
    },
    computed: {
    },
    methods: {
        atualizarForm(texto) {
            this.$emit('justificativa-update', texto);
        },
    },
};
</script>
