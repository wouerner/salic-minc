<template>
    <v-container grid-list-md>
        <v-layout row>
            <v-flex
                xs12
                md3
            >
                <v-select
                    v-model="itemEditado.idUnidade"
                    :value="item.idUnidade"
                    :items="getUnidadesPlanilha"
                    item-text="Descricao"
                    item-value="idUnidade"
                    label="Unidade"
                />
            </v-flex>
            <v-flex
                xs12
                md1
            >
                <v-text-field
                    v-model="itemEditado.QtdeDias"
                    :value="item.QtdeDias"
                    required
                    label="Qtd dias"
                />
            </v-flex>
            <v-flex
                xs12
                md1
            >
                <v-text-field
                    v-model="itemEditado.Quantidade"
                    :value="item.Quantidade"
                    required
                    label="Quantidade"
                />
            </v-flex>
            <v-flex
                xs12
                md2
            >
                <v-text-field
                    v-model="itemEditado.Ocorrencia"
                    :value="item.Ocorrencia"
                    required
                    label="Ocorrência"
                    @change="atualizarCampo($event, 'Ocorrencia')"
                />
            </v-flex>
            <v-flex
                xs12
                md2
            >
                <input-money
                    ref="itemOcorrencia"
                    :value="item.vlUnitario"
                    class="title"
                    @ev="atualizarCampo($event, 'vlUnitario')"
                />
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
            justify-end
        >
            <v-flex
                xs12
                md12>
                <s-editor-texto
                    v-model="itemEditado.dsJustificativa"
                    :placeholder="'Justificativa do item'"
                    :min-char="minChar.justificativa"
                    @text-change="atualizarCampo($event, 'dsJustificativa')"
                    @editor-texto-counter="atualizarContador($event)"
                />
            </v-flex>
        </v-layout>
        <v-layout
            text-xs-center
        >
            <v-btn
                color="green lighten-1"
                dark
                @click="salvarItem()"
            >Salvar item
                <v-icon
                    right
                    dark
                >done</v-icon>
            </v-btn>
            <v-btn
                color="red lighten-1"
                dark
                @click="cancelar()"
            >Cancelar
                <v-icon
                    right
                    dark
                >cancel</v-icon>
            </v-btn>
        </v-layout>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex';
import { utils } from '@/mixins/utils';
import InputMoney from '@/components/InputMoney';
import SEditorTexto from '@/components/SalicEditorTexto';
import validarFormulario from '../mixins/validarFormulario';

export default {
    name: 'EditarItemPlanilha',
    components: {
        InputMoney,
        SEditorTexto,
    },
    mixins: [
        utils,
        validarFormulario,
    ],
    props: {
        item: {
            type: [Array, Object],
            default: () => {},
        },
    },
    data() {
        return {
            itemEditado: {
                dsJustificativa: '',
                Ocorrencia: 0,
                QtdeDias: '',
                Quantidade: 0,
                TotalSolicitado: 0,
                ValorUnitario: '',
                idPlanilhaAprovacao: '',
                idPlanilhaItem: '',
                idReadequacao: '',
                idProduto: '',
                idUnidade: '',
            },
            campos: [
                'idUnidade',
                'QtdeDias',
                'Quantidade',
                'Ocorrencia',
                'dsJustificativa',
            ],
            minChar: {
                justificativa: 10,
            },
        };
    },
    computed: {
        ...mapGetters({
            getUnidadesPlanilha: 'readequacao/getUnidadesPlanilha',
        }),
    },
    created() {
        this.inicializarItemEditado();
    },
    methods: {
        inicializarItemEditado() {
            this.itemEditado = {
                idPlanilhaAprovacao: this.item.idPlanilhaAprovacao,
                idPlanilhaItem: this.item.idPlanilhaItem,
                idReadequacao: this.item.idReadequacao,
                dsJustificativa: this.item.dsJustificativa,
                Ocorrencia: this.item.Ocorrencia,
                Quantidade: this.item.Quantidade,
                QtdeDias: this.item.QtdeDias,
                TotalSolicitado: this.item.TotalSolicitado,
                ValorUnitario: this.item.ValorUnitario,
            };
        },
        atualizarCampo(valor, campo) {
            this.itemEditado[campo] = valor;
        },
        atualizarContador(valor, campo) {
            this.contador[campo] = valor;
            this.validar();
        },
        validar() {
            this.validacao = this.validarItemPlanihla(
                this.itemEditado,
                this.contador,
                this.minChar,
            );
        },
    },
};
</script>
