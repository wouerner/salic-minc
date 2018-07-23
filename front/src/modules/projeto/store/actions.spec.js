import * as actions from './actions';
import * as MockAPI from '../../../../test/unit/helpers/api';
import * as ProjetoHelperAPI from '@/helpers/api/Projeto';

describe('Projeto actions', () => {
  let commit;
  let mockReponse;

  describe('buscaProjeto', () => {
    beforeEach(() => {
      mockReponse = {
        data: {
          data: {
            projeto: {
              IdPRONAC: '132451',
              Item: 'Hospedagem sem Alimentação',
              NomeProjeto: 'Criança Para Vida - 15 anos',
            },
          },
        },
      };

      commit = jest.fn();

      MockAPI.setResponse(mockReponse);
    });

    afterEach(() => {
      MockAPI.setResponse(null);
    });

    test('it calls ProjetoHelperAPI.buscaProjeto', () => {
      jest.spyOn(ProjetoHelperAPI, 'buscaProjeto');
      actions.buscaProjeto({ commit });
      expect(ProjetoHelperAPI.buscaProjeto).toHaveBeenCalled();
    });

    test('it is commit to buscaProjeto', (done) => {
      const projeto = mockReponse.data;
      actions.buscaProjeto({ commit }, 132451);
      done();
      expect(commit).toHaveBeenCalledWith('SET_PROJETO', projeto);
    });
  });
});
