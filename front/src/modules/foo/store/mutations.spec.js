import { mutations } from './mutations';

describe('Foo Mutations', () => {
    let state;
    let defaultState;
    let dadosTabela;

    beforeEach(() => {
        defaultState = {
            dadosTabela: [
                {
                    Codigo: '',
                    DadoNr: '',
                },
            ],
        };

        state = Object.assign({}, defaultState);

        dadosTabela = [
            {
                Codigo: 1,
                DadoNr: 'Random String',
            },
        ];
    });

    test('SET_REGISTROS_TABELA', () => {
        mutations.SET_REGISTROS_TABELA(state, dadosTabela);
        expect(state.dadosTabela).toEqual(dadosTabela);
    });
});
