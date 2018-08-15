import * as actions from './actions';
import * as ProjetoHelperAPI from '@/helpers/api/Projeto';
import axios from 'axios';

jest.mock('axios');

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
                            Item: 'Hospedagem sem Alimenta��o',
                            NomeProjeto: 'Crian�a Para Vida - 15 anos',
                        },
                    },
                },
            };

            axios.get.mockResolvedValue(mockReponse);

            commit = jest.fn();
            jest.spyOn(ProjetoHelperAPI, 'buscaProjeto');
            actions.buscaProjeto({ commit });
        });

        test('it calls ProjetoHelperAPI.buscaProjeto', () => {
            expect(ProjetoHelperAPI.buscaProjeto).toHaveBeenCalled();
        });

        test('it is commit to buscaProjeto', (done) => {
            const projeto = mockReponse.data;
            done();
            expect(commit).toHaveBeenCalledWith('SET_PROJETO', projeto.data);
        });
    });
});
