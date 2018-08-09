import * as MockAPI from '@/../test/unit/helpers/api';
import * as fooHelperAPI from '@/helpers/api/Foo';
import * as actions from './actions';

describe('Foo actions', () => {
    let commit;
    let mockReponse;

    describe('obterDadosTabela', () => {
        beforeEach(() => {
            mockReponse = {
                data: {
                    dadosTabela: [
                        {
                            Codigo: 1,
                            DadoNr: 'Random String 1',
                        },
                    ],
                },
            };

            commit = jest.fn();

            MockAPI.setResponse(mockReponse);
        });

        afterEach(() => {
            MockAPI.setResponse(null);
        });

        test('it is commit to obterDadosTabela', (done) => {
            const dadosTabela = mockReponse.data;
            actions.obterDadosTabela({ commit });
            done();
            expect(commit).toHaveBeenCalledWith('SET_REGISTROS_TABELA', dadosTabela);
        });

        test('it calls fooHelperAPI.obterDadosTabela', () => {
            jest.spyOn(fooHelperAPI, 'obterDadosTabela');
            actions.obterDadosTabela({ commit });
            expect(fooHelperAPI.obterDadosTabela).toHaveBeenCalled();
        });
    });

    describe('criarRegistro', () => {
        beforeEach(() => {
            mockReponse = {
                data: {
                    data: {
                        Codigo: 1,
                        DadoNr: 'Random String 1',
                    },
                },
            };

            commit = jest.fn();

            MockAPI.setResponse(mockReponse);

            function FormDataMock() {
                this.append = jest.fn();
            }

            global.FormData = FormDataMock;
        });

        afterEach(() => {
            MockAPI.setResponse(null);
        });

        // test('it is commit to criarRegistro', (done) => {
        //     const registro = mockReponse;
        //     actions.criarRegistro({ commit }, registro);
        //     done();
        //     expect(commit).toHaveBeenCalledWith('SET_REGISTRO_TABELA', registro);
        // });

        test('it calls fooHelperAPI.criarRegistro', () => {
            jest.spyOn(fooHelperAPI, 'criarRegistro');
            const registro = mockReponse.data;
            actions.criarRegistro({ commit }, registro);
            expect(fooHelperAPI.criarRegistro).toHaveBeenCalled();
        });
    });

    describe('atualizarRegistro', () => {
        beforeEach(() => {
            mockReponse = {
                data: {
                    data: {
                        Codigo: 1,
                        DadoNr: 'Random String 1',
                    },
                },
            };

            commit = jest.fn();

            MockAPI.setResponse(mockReponse);

            function FormDataMock() {
                this.append = jest.fn();
            }

            global.FormData = FormDataMock;
        });

        afterEach(() => {
            MockAPI.setResponse(null);
        });

        // test('it is commit to atualizarRegistro', (done) => {
        //     const registro = mockReponse;
        //     actions.atualizarRegistro({ commit }, registro);
        //     done();
        //     expect(commit).toHaveBeenCalledWith('ATUALIZAR_REGISTRO_TABELA', registro);
        // });

        test('it calls fooHelperAPI.atualizarRegistro', () => {
            jest.spyOn(fooHelperAPI, 'atualizarRegistro');
            const registro = mockReponse.data;
            actions.atualizarRegistro({ commit }, registro);
            expect(fooHelperAPI.atualizarRegistro).toHaveBeenCalled();
        });
    });
});
