<template>
<v-layout row wrap>   
    <v-flex xs10 offset-xs1>
        <h6 class="subheading font-weight-medium">Justificativa da Readequação</h6>
        <v-card>
            <EditorTexto
                :style="''"
                :value="dadosReadequacao.dsJustificativa"
                required="required"
            ></EditorTexto>
        </v-card>
    </v-flex>
</v-layout>    
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
    },
};
</script>
