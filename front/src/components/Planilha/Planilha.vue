<template>
    <div v-if="planilhaCompleta" class="planilha-orcamentaria card">
        <CollapsibleRecursivo :planilha="planilhaCompleta">
            <template slot-scope="slotProps">
                <slot v-bind:itens="slotProps.itens">
                    <PlanilhaItensPadrao :table="slotProps.itens"></PlanilhaItensPadrao>
                </slot>
            </template>
        </CollapsibleRecursivo>

        <div class="card-action right-align">
            <span><b>Valor total do projeto:</b> R$ {{planilhaCompleta.total | filtroFormatarParaReal}}</span>
        </div>
    </div>
    <div v-else>Nenhuma planilha encontrada</div>
</template>

<script>
    import PlanilhaItensPadrao from '@/components/Planilha/PlanilhaItensPadrao';
    import planilhas from '@/mixins/planilhas';

    const CollapsibleRecursivo = {
        name: 'CollapsibleRecursivo',
        props: {
            planilha: {},
        },
        mixins: [planilhas],
        mounted() {
            this.iniciarCollapsible();
        },
        render(h) {
            let self = this;
            if (this.isObject(this.planilha) && typeof this.planilha.itens === 'undefined') {
                return h('ul',
                    { class: 'collapsible no-margin', attrs: { 'data-collapsible': 'expandable' } },
                    Object.keys(this.planilha).map(key => {
                        if (self.isObject(self.planilha[key])) {
                            return h('li', [
                                h('div',
                                    { class: self.obterClasseHeader(self.planilha[key].tipo) },
                                    [
                                        h('i', { class: 'material-icons' }, [self.obterIconeHeader(self.planilha[key].tipo)]),
                                        h('div', key),
                                        h('span', { class: 'badge' }, [`R$ ${self.formatarParaReal(self.planilha[key].total)}`]),
                                    ]
                                ),
                                h('div',
                                    { class: 'collapsible-body no-padding' },
                                    [
                                        h(CollapsibleRecursivo, {
                                            props: { planilha: self.planilha[key] },
                                            scopedSlots: { default: self.$scopedSlots.default }
                                        }),
                                    ],
                                ),
                            ]);
                        }
                    }),
                );
            } else if (self.$scopedSlots.default !== 'undefined') {
                return h('div', self.$scopedSlots.default({ itens: self.planilha.itens }));
            }
        },
        methods: {
            iniciarCollapsible() {
                $3(".collapsible").each(function () {
                    $3(this).collapsible();
                });
            },
            obterClasseHeader(tipo) {
                return {
                    'collapsible-header active': true,
                    'red-text fonte': tipo === 'fonte',
                    'green-text produto': tipo === 'produto',
                    'orange-text etapa': tipo === 'etapa',
                    'blue-text local': tipo === 'local',
                };
            },
            obterIconeHeader(tipo) {
                let icone = '';
                switch (tipo) {
                    case 'fonte':
                        icone = 'beenhere';
                        break;
                    case 'produto':
                        icone = 'perm_media';
                        break;
                    case 'etapa':
                        icone = 'label';
                    break;
                    case 'local':
                        icone = 'place';
                        break;
                }
                return icone;
            },
        },
    };

    export default {
        /* eslint-disable */
        name: 'Planilha',
        props: {
            arrayPlanilha: {},
        },
        mixins: [planilhas],
        components: {
            CollapsibleRecursivo,
            PlanilhaItensPadrao,
        },
        computed: {
            planilhaCompleta() {

                if (!this.arrayPlanilha) {
                    return 0;
                }

                let novaPlanilha = {},
                    totalProjeto = 0,
                    totalFonte = 0,
                    totalProduto = 0,
                    totalEtapa = 0,
                    totalLocal = 0;

                novaPlanilha = JSON.parse(JSON.stringify(this.arrayPlanilha));

                Object.entries(this.arrayPlanilha).forEach(([fonte, produtos]) => {
                    totalFonte = 0;
                    Object.entries(produtos).forEach(([produto, etapas]) => {
                        totalProduto = 0;
                        Object.entries(etapas).forEach(([etapa, locais]) => {
                            totalEtapa = 0;
                            Object.entries(locais).forEach(([local, itens]) => {
                                totalLocal = 0;
                                novaPlanilha[fonte][produto][etapa][local] = {};
                                this.$set(
                                    novaPlanilha[fonte][produto][etapa][local],
                                    'itens',
                                    itens
                                );

                                Object.entries(itens).forEach(([column, cell]) => {
                                    if (cell.tpAcao && cell.tpAcao === 'E') {
                                        return;
                                    }

                                    // planilha homologada e readequada o valor total � a soma do vlAprovado
                                    if (cell.vlAprovado || cell.vlAprovado >= 0) {
                                        totalLocal += cell.vlAprovado;
                                    } else {
                                        totalLocal += cell.vlSolicitado;
                                    }
                                });

                                this.$set(novaPlanilha[fonte][produto][etapa][local], 'total', totalLocal);
                                this.$set(novaPlanilha[fonte][produto][etapa][local], 'tipo', 'local');
                                totalEtapa += totalLocal;
                            });
                            this.$set(novaPlanilha[fonte][produto][etapa], 'total', totalEtapa);
                            this.$set(novaPlanilha[fonte][produto][etapa], 'tipo', 'etapa');
                            totalProduto += totalEtapa;
                        });
                        this.$set(novaPlanilha[fonte][produto], 'total', totalProduto);
                        this.$set(novaPlanilha[fonte][produto], 'tipo', 'produto');
                        totalFonte += totalProduto;
                    });
                    this.$set(novaPlanilha[fonte], 'total', totalFonte);
                    this.$set(novaPlanilha[fonte], 'tipo', 'fonte');
                    totalProjeto += totalFonte;
                });
                this.$set(novaPlanilha, 'total', totalProjeto);

                return novaPlanilha;
            }
        },
    };
</script>


<style>
    .planilha-orcamentaria .collapsible .collapsible,
    .planilha-orcamentaria .collapsible-body .collapsible-body {
        border: none;
        box-shadow: none;
    }

    .planilha-orcamentaria .collapsible .collapsible .collapsible-header {
        padding-left: 30px;
    }

    .planilha-orcamentaria .collapsible .collapsible .collapsible .collapsible-header {
        padding-left: 50px;
    }

    .planilha-orcamentaria .collapsible .collapsible .collapsible .collapsible .collapsible-header {
        padding-left: 70px;
    }

    .planilha-orcamentaria .collapsible .collapsible .collapsible .collapsible .collapsible-body {
        margin: 20px;
    }
</style>
