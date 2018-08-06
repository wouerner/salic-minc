<template>
    <div>
        <ul
            v-if="isObject(planilha) && typeof planilha.itens === 'undefined'"
            class="collapsible no-margin"
            data-collapsible="expandable">
            <li
                v-for="(item, key, index) of planilha"
                v-if="isObject(item) && typeof item.total !== 'undefined' "
                :key="index">
                <div class="collapsible-header active" :class="obterClasseHeader(item.tipo)">
                    <i class="material-icons" v-html="obterIconeHeader(item.tipo)"></i>{{key}}<span class="badge">R$ {{item.total | formatarParaReal}}</span>
                </div>
                <div class="collapsible-body no-padding">
                    <CollapsiblePlanilha :planilha="item"></CollapsiblePlanilha>
                </div>
            </li>
        </ul>
        <div class="scroll-x">
            <slot name="itensPlanilha" v-bind:itens="planilha"></slot>
        </div>
    </div>
</template>

<script>
    import PlanilhaItensPadrao from '@/components/Planilha/PlanilhaItensPadrao';
    import planilhas from '@/mixins/planilhas';

    export default {
        name: 'CollapsiblePlanilha',
        mixins: [planilhas],
        components: {
            PlanilhaItensPadrao,
        },
        props: {
            planilha: {},
        },
        beforeCreate: function () {
            this.$options.components.CollapsiblePlanilha = require('./CollapsiblePlanilha.vue').default
        },
        mounted() {
            this.iniciarCollapsible();
        },
        methods: {
            iniciarCollapsible() {
                $3(".collapsible").each(function () {
                    $3(this).collapsible();
                });
            },
            obterClasseHeader(tipo) {
                return {
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
    }
</script>

<style scoped>
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
