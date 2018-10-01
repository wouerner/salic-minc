<template>
    <div class="content" >
        <div class="row">
            <div class="col s12">
                <div class="row" style="text-align: center;">
                    <div v-for="fase of fases" :key="fase.id" style="display:inline-block">
                        <i v-if="fase.id > 95" class="tiny material-icons">forward</i>
                        <a
                            class="margin20 btn small btn-primary tooltipped"
                            :class="{ disabled : dadosProposta.idMovimentacao !== fase.id }"
                            :data-tooltip="fase.descricao"
                            style="cursor: default">
                            <i class="tiny material-icons left">{{fase.icon}}</i>
                            <span v-html="fase.label"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    const PROPOSTA_COM_PROPONENTE = 95;
    const PROPOSTA_PARA_ANALISE_INICIAL = 96;
    const PROPOSTA_ARQUIVADA = 128;
    const PROPOSTA_TRANSFORMADA_EM_PROJETO = 200;

    export default {
        props: {
            idPreProjeto: null,
        },
        data() {
            return {
                fases: [
                    {
                        id: PROPOSTA_COM_PROPONENTE,
                        label: 'Com o proponente',
                        descricao: 'A proposta está disponível para edição.',
                        icon: 'create',
                    },
                    {
                        id: PROPOSTA_PARA_ANALISE_INICIAL,
                        label: 'Em Avalia&ccedil;&atilde;o no MinC',
                        descricao: 'A proposta está em avaliação pelo Ministério da Cultura, acompanhe na aba histórico de avaliações.',
                        icon: 'how_to_reg',
                    },
                    {
                        id: PROPOSTA_ARQUIVADA,
                        label: 'Proposta arquivada',
                        descricao: 'Proposta arquivada, acompanhe na aba histórico de avaliações para saber mais.',
                        icon: 'archive',
                    },
                    {
                        id: PROPOSTA_TRANSFORMADA_EM_PROJETO,
                        label: 'Projeto Cultural',
                        descricao: 'A proposta já é um projeto cultural.',
                        icon: 'beenhere',
                    },
                ],
            }
        },
        computed: {
            ...mapGetters({
                dadosProposta: 'proposta/proposta',
            }),
        },
    };
</script>
