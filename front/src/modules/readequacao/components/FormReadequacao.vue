<template>
<v-layout row wrap>
    <v-flex xs10 offset-xs1>
        <h6 class="subheading font-weight-medium">Plano de Distribuição</h6>
        <v-card>
            <EditorTexto
                :style="''"
                :value="dadosTipoReadequacao.data"
                required="required"
            />
        </v-card>
    </v-flex>
</v-layout>    
</template>

<script>
import EditorTexto from '../../avaliacaoResultados/components/components/EditorTexto';

export default {
    name: 'ExcluirButton',
    components: {
        EditorTexto,
    },
    props: {
        idReadequacao: { type: String, default: '' },
        usuario: { type: String, default: '' },
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