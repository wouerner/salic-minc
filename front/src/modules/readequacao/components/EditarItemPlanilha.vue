<template>
    <v-container grid-list-md>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs12
                md2
            >
                <v-select
                    v-model="itemEditado.idUnidade"
                    :value="itemEditado.idUnidade"
                    :items="getUnidadesPlanilha"
                    item-text="Descricao"
                    item-value="idUnidade"
                    label="Unidade"
                />
            </v-flex>
            <v-flex
                xs12
                md2
            >
                <v-text-field
                    v-model="itemEditado.QtdeDias"
                    :value="item.QtdeDias"
                    :rules="[rules.required]"
                    label="Qtd dias"
                />
            </v-flex>
            <v-flex
                xs12
                md2
            >
                <v-text-field
                    v-model="itemEditado.Quantidade"
                    :value="item.Quantidade"
                    :rules="[rules.required]"
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
                    :rules="[rules.required]"
                    required
                    label="Ocorrência"
                    @change="atualizarCampo($event, 'Ocorrencia')"
                />
            </v-flex>
            <v-flex
                xs12
                md12
            >
                <label class="grey--text text--darken-1 caption">Valor unitário</label>
                <div class="d-inline-block subheading">
                    R$
                    <input-money
                        ref="ValorUnitario"
                        :value="item.vlUnitario"
                        :rules="[rules.required, rules.nonZero]"
                        class="subheading"
                        @ev="atualizarCampo($event, 'ValorUnitario')"
                    />
                </div>
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
                <v-textarea
                    v-model="itemEditado.dsJustificativa"
                    :placeholder="'Justificativa do item'"
                    :min-char="minChar.justificativa"
                    label="Justificativa"
                    class="regular"
                    @change="atualizarCampo($event, 'dsJustificativa')"
                />
            </v-flex>
        </v-layout>
        <v-layout
            column
        >
            <v-flex
                xs12
                text-xs-left
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
                    @click="cancelarEdicao()"
                >Cancelar
                    <v-icon
                        right
                        dark
                    >cancel</v-icon>
                </v-btn>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import { utils } from '@/mixins/utils';
import InputMoney from '@/components/InputMoney';

export default {
    name: 'EditarItemPlanilha',
    components: {
        InputMoney,
    },
    mixins: [
        utils,
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
                QtdeDias: 0,
                Quantidade: 0,
                ValorUnitario: '',
                idFonte: 0,
                idPlanilhaAprovacao: 0,
                idPlanilhaItem: 0,
                idReadequacao: 0,
                idPronac: 0,
                idProduto: 0,
                idUnidade: 0,
                idTipoReadequacao: 0,
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
            rules: {
                required: v => !!v || 'Campo obrigatório.',
                nonZero: v => (v && v >= 0) || 'Campo não pode ser zerado ou negativo.',
                justificativa: [
                    v => !!v || 'Preencha a justificativa.',
                    v => (v && v.length >= this.minChar.justificativa) || `Justificativa ter no mínimo ${this.minChar.justificativa} caracteres.`,
                ],
            },
        };
    },
    computed: {
        ...mapGetters({
            getUnidadesPlanilha: 'readequacao/getUnidadesPlanilha',
            getReadequacao: 'readequacao/getReadequacao',
        }),
    },
    created() {
        this.inicializarItemEditado();
    },
    methods: {
        ...mapActions({
            atualizarItemPlanilha: 'readequacao/atualizarItemPlanilha',
        }),
        inicializarItemEditado() {
            this.itemEditado = {
                idPlanilhaAprovacao: this.item.idPlanilhaAprovacao,
                idPlanilhaItem: this.item.idPlanilhaItem,
                idReadequacao: this.getReadequacao.idReadequacao,
                idPronac: this.getReadequacao.idPronac,
                dsJustificativa: this.item.dsJustificativa,
                idUnidade: this.item.idUnidade,
                idFonte: this.item.idFonte,
                Ocorrencia: this.item.Ocorrencia,
                Quantidade: this.item.Quantidade,
                QtdeDias: this.item.QtdeDias,
                ValorUnitario: this.item.ValorUnitario,
                idTipoReadequacao: this.getReadequacao.idTipoReadequacao,
            };
        },
        salvarItem() {
            this.atualizarItemPlanilha(this.itemEditado)
                .then((response) => {
                    this.$emit('fechar-item');
                });
        },
        cancelarEdicao() {
            this.$emit('fechar-item');
        },
        atualizarCampo(valor, campo) {
            this.itemEditado[campo] = valor;
        },
    },
};
</script>
