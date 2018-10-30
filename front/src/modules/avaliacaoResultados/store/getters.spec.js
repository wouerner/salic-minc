import * as getters from './getters';

describe('Teste getters - Avaliação de Resultados', () => {
    let state;

    beforeEach(() => {
        state = {
            dadosTabelaTecnico: [],
            projetosParaDistribuir: [],
            getProjetosAssinatura: [],
            getProjetosAssinar: [],
            getProjetosEmAssinatura: [],
            getProjetosHistorico: [],
            getProjetosLaudoFinal: [],
            getProjetosLaudoAssinar: [],
            getProjetosLaudoEmAssinatura: [],
            getProjetosLaudoFinalizados: [],
        };
    });

    test('obterDadosTabelaTecnico', () => {
        const result = getters.dadosTabelaTecnico(state);
        expect(result).toEqual(state.dadosTabelaTecnico);
    });

    test('getProjetosParaDistribuir', () => {
        const result = getters.getProjetosParaDistribuir(state);
        expect(result).toEqual(state.projetosParaDistribuir);
    });

    test('getProjetosAssinatura', () => {
        const result = getters.getProjetosAssinatura(state);
        expect(result).toEqual(state.getProjetosAssinatura);
    });
    
    test('getProjetosAssinar', () => {
        const result = getters.getProjetosAssinar(state);
        expect(result).toEqual(state.getProjetosAssinar);
    });

    test('getProjetosEmAssinatura', () => {
        const result = getters.getProjetosEmAssinatura(state);
        expect(result).toEqual(state.getProjetosEmAssinatura);
    });

    test('getProjetosHistorico', () => {
        const result = getters.getProjetosHistorico(state);
        expect(result).toEqual(state.getProjetosHistorico);
    });

    test('getProjetosLaudoFinal', () => {
        const result = getters.getProjetosLaudoFinal(state);
        expect(result).toEqual(state.getProjetosLaudoFinal);
    });

    test('getProjetosLaudoAssinar', () => {
        const result = getters.getProjetosLaudoAssinar(state);
        expect(result).toEqual(state.getProjetosLaudoAssinar);
    });

    test('getProjetosLaudoEmAssinatura', () => {
        const result = getters.getProjetosLaudoEmAssinatura(state);
        expect(result).toEqual(state.getProjetosLaudoEmAssinatura);
    });
    
    test('getProjetosLaudoFinalizados', () => {
        const result = getters.getProjetosLaudoFinalizados(state);
        expect(result).toEqual(state.getProjetosLaudoFinalizados);
    });
    
    
});
