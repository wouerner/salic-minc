<template>
    <div>
        <RecursiveItem :planilha="planilha">
            <template slot-scope="slotProps">
                <PlanilhaItensPadrao :table="slotProps.itens"></PlanilhaItensPadrao>
            </template>
        </RecursiveItem>
    </div>
</template>

<script>
    import PlanilhaItensPadrao from '@/components/Planilha/PlanilhaItensPadrao';
    import planilhas from '@/mixins/planilhas';

    const RecursiveItem = {
        name: 'RecursiveItem',
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
                return h('ul', {class: 'collapsible no-margin', attrs: {'data-collapsible': 'expandable'}},
                    Object.keys(this.planilha).map(function (key) {
                        if (self.isObject(self.planilha[key])) {
                            return h('li', [
                                h('div', {class: self.obterClasseHeader(self.planilha[key].tipo)}, [
                                    h('i', {class: 'material-icons'}, [self.obterIconeHeader(self.planilha[key].tipo)]),
                                    h('div', key),
                                    h('span', {class: 'badge'}, ['R$ ' + self.formatarParaReal(self.planilha[key].total)])
                                ]),
                                h('div', {class: 'collapsible-body no-padding'}, [
                                    h(RecursiveItem, {
                                        props: {planilha: self.planilha[key]},
                                        scopedSlots: {default: self.$scopedSlots.default}
                                    })
                                ])
                            ])
                        }
                    })
                );
            } else if (self.$scopedSlots.default !== 'undefined') {
                return h('div', self.$scopedSlots.default({itens: self.planilha.itens}));
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
        }
    };

    export default {
        name: 'CollapsiblePlanilha',
        components: {
            PlanilhaItensPadrao,
            RecursiveItem
        },
        props: {
            planilha: {},
        },
    }
</script>

<style>
    .collapsible .collapsible,
    .collapsible-body .collapsible-body {
        border: none;
        box-shadow: none;
    }

    .collapsible .collapsible .collapsible-header {
        padding-left: 30px;
    }

    .collapsible .collapsible .collapsible .collapsible-header {
        padding-left: 50px;
    }

    .collapsible .collapsible .collapsible .collapsible .collapsible-header {
        padding-left: 70px;
    }

    .collapsible .collapsible .collapsible .collapsible .collapsible-body {
        margin: 20px;
    }
</style>
