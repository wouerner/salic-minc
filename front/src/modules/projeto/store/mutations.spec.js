import { mutations } from './mutations';

describe('Projeto Mutations', () => {
    let state;
    let defaultState;
    let projeto;
    let planilhaHomologada;

    beforeEach(() => {
        defaultState = {
            projeto: {
                IdPRONAC: '',
                Item: '',
                NomeProjeto: '',
            },
            planilhaHomologada: {
                tpPlanilha: '',
                IdPronac: '',
                PRONAC: '',
            },
        };

        state = Object.assign({}, defaultState);

        projeto = {
            IdPRONAC: '132451',
            Item: 'Hospedagem sem Alimentação',
            NomeProjeto: 'Criança Para Vida - 15 anos',
        };

        planilhaHomologada = {
            tpPlanilha: 'CO',
            IdPronac: '189786',
            PRONAC: '150151',
        }
    });

    test('SET_PROJETO', () => {
        mutations.SET_PROJETO(state, projeto);
        expect(state.projeto).toEqual(projeto);
    });

    test('SET_PLANILHA_HOMOLOGADA', () => {
        mutations.SET_PLANILHA_HOMOLOGADA(state, planilhaHomologada);
        expect(state.planilhaHomologada).toEqual(planilhaHomologada);
    });
});
