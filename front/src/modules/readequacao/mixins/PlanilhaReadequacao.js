import planilhas from '@/mixins/planilhas';

export default {
    mixins: [planilhas],
    methods: {
        isLinhaAlterada(row) {
            /*
            const proponente = [
                row.Unidade,
                row.VlSolicitado,
                row.ocorrenciaprop,
                row.quantidadeprop,
                row.diasprop,
                row.valorUnitarioprop,
                row.stCustoPraticado,
            ];
            const parecerista = [
                row.idUnidade,
                row.VlSugeridoParecerista,
                row.ocorrenciaparc,
                row.quantidadeparc,
                row.diasparc,
                row.valorUnitarioparc,
                row.stCustoPraticadoParc,
            ];
            return JSON.stringify(proponente) !== JSON.stringify(parecerista);
             */
            return row;
        },
        isItemDisponivelEdicao(item) {
            if (item.vlComprovado < item.vlAprovado) {
                return true;
            }
            return false;
        },
        isDisponivelParaEdicao(row) {
            return row;
        },
        obterClasseItem(row = '') {
            let classe = {};
            switch (true) {
            case row.selecionado:
                classe = { 'purple lighten-5': true };
                break;
            case this.isLinhaAlterada(row):
                classe = { 'indigo lighten-4': true };
                break;
            case row.isDisponivelParaEdicao === false:
                classe = { 'grey lighten-3 grey--text text--darken-3': true };
                break;
            default:
                classe = {};
                break;
            }
            return classe;
        },
        obterValorAprovadoTotal(table) {
            let soma = 0;
            Object.entries(table).forEach(([, cell]) => {
                if (cell.vlAprovado !== undefined) {
                    soma += parseFloat(cell.vlAprovado);
                }
            });
            return soma;
        },
        obterValorComprovadoTotal(table) {
            let soma = 0;
            Object.entries(table).forEach(([, cell]) => {
                if (cell.vlComprovado !== undefined) {
                    soma += (cell.vlComprovado);
                }
            });
            return soma;
        },
    },
};
