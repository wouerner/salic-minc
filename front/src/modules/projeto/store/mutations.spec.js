import { mutations } from './mutations';

describe('Projeto Mutations', () => {
  let state;
  let defaultState;
  let projeto;

  beforeEach(() => {
    defaultState = {
      projeto: {
        IdPRONAC: '',
        Item: '',
        NomeProjeto: '',
      },
    };

    state = Object.assign({}, defaultState);

    projeto = {
      IdPRONAC: '132451',
      Item: 'Hospedagem sem Alimentação',
      NomeProjeto: 'Criança Para Vida - 15 anos',
    };
  });

  test('SET_PROJETO', () => {
    mutations.SET_PROJETO(state, projeto);
    expect(state.projeto).toEqual(projeto);
  });
});
