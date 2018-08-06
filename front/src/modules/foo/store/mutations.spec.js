import { mutations } from './mutations';

describe('Foo Mutations', () => {
    let state;
    let defaultState;
    let dadosTabela;

    describe('when call mutation SET_REGISTROS_TABELA', () => {
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
                DadoNr: 'Random String 1',
            },
        ];

        test('SET_REGISTROS_TABELA', () => {
            mutations.SET_REGISTROS_TABELA(state, dadosTabela);
            expect(state.dadosTabela).toEqual(dadosTabela);
        });
    });
});
