<template>
    <div v-if="planilhaCompleta" class="planilha-orcamentaria card">
        <CollapsiblePlanilha :planilha="planilhaCompleta">
            <template slot="itensPlanilha" slot-scope="slotProps">
                <PlanilhaItensPadrao :table="slotProps.itens"></PlanilhaItensPadrao>
            </template>
        </CollapsiblePlanilha>
        <div class="card-action right-align">
            <span><b>Valor total do projeto:</b> R$ {{planilhaCompleta.total | filtroFormatarParaReal}}</span>
        </div>
    </div>
    <div v-else>Nenhuma planilha encontrada</div>
</template>

<script>
    import CollapsiblePlanilha from '@/components/Planilha/CollapsiblePlanilha';
    import PlanilhaItensAutorizados from '@/components/Planilha/PlanilhaItensAutorizados';
    import PlanilhaItensPadrao from '@/components/Planilha/PlanilhaItensPadrao';
    import planilhas from '@/mixins/planilhas';

    export default {
        /* eslint-disable */
        name: 'Planilha',
        props: {
            arrayPlanilha: {},
        },
        mixins: [planilhas],
        components: {
            CollapsiblePlanilha,
            PlanilhaItensAutorizados,
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
                            this.$set( novaPlanilha[fonte][produto][etapa], 'total', totalEtapa);
                            this.$set( novaPlanilha[fonte][produto][etapa], 'tipo', 'etapa');
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
