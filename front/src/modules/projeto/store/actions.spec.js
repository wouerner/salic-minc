import axios from 'axios';
import * as projetoHelperAPI from '@/helpers/api/Projeto';
import * as actions from './actions';

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
                            Item: 'Hospedagem sem Alimenta\xE7\xE3o',
                            NomeProjeto: 'Crian\xE7a Para Vida - 15 anos',
                        },
                    },
                },
            };

            axios.get.mockResolvedValue(mockReponse);

            commit = jest.fn();
            jest.spyOn(projetoHelperAPI, 'buscaProjeto');
            actions.buscaProjeto({ commit });
        });

        test('it calls projetoHelperAPI.buscaProjeto', () => {
            expect(projetoHelperAPI.buscaProjeto).toHaveBeenCalled();
        });

        test('it is commit to buscaProjeto', (done) => {
            const projeto = mockReponse.data;
            done();
            expect(commit).toHaveBeenCalledWith('SET_PROJETO', projeto.data);
        });
    });

    describe('buscaProponente', () => {
        beforeEach(() => {
            mockReponse = {
                data: {
                    data: {
                        proponente: {
                            Proponente: 'Associa\xE7\xC3o Beneficiente Cultural Religiosa Centro Judaico do Brooklin',
                            idAgente: '24806',
                            TipoPessoa: 'Jur\xCDdica',
                        },
                    },
                },
            };

            axios.get.mockResolvedValue(mockReponse);

            commit = jest.fn();
            jest.spyOn(projetoHelperAPI, 'buscaProponente');
            actions.buscaProponente({ commit });
        });

        test('it calls projetoHelperAPI.buscaProponente', () => {
            expect(projetoHelperAPI.buscaProponente).toHaveBeenCalled();
        });

        test('it is commit to buscaProponente', (done) => {
            const proponente = mockReponse.data;
            done();
            expect(commit).toHaveBeenCalledWith('SET_PROPONENTE', proponente.data);
        });
    });

    describe('buscaPlanilhaHomologada', () => {
        beforeEach(() => {
            mockReponse = {
                data: {
                    data: {
                        planilhaHomologada: {
                            tpPlanilha: 'CO',
                            IdPronac: '189786',
                            PRONAC: '150151',
                        },
                    },
                },
            };

            axios.get.mockResolvedValue(mockReponse);

            commit = jest.fn();
            jest.spyOn(projetoHelperAPI, 'buscaPlanilhaHomologada');
            const idPronac = 123456;
            actions.buscaPlanilhaHomologada({ commit }, idPronac);
        });

        test('it calls projetoHelperAPI.buscaPlanilhaHomologada', () => {
            expect(projetoHelperAPI.buscaPlanilhaHomologada).toHaveBeenCalled();
        });

        test('it is commit to buscaPlanilhaHomologada', (done) => {
            const planilhaHomologada = mockReponse.data;
            done();
            expect(commit).toHaveBeenCalledWith('SET_PLANILHA_HOMOLOGADA', planilhaHomologada.data);
        });
    });

    describe('buscaPlanilhaOriginal', () => {
        beforeEach(() => {
            mockReponse = {
                data: {
                    data: {
                        planilhaOriginal: {
                            idPlanilhaProposta: '3675289',
                            FonteRecurso: 'Incentivo Fiscal Federal',
                            idEtapa: '2',
                        },
                    },
                },
            };

            axios.get.mockResolvedValue(mockReponse);

            commit = jest.fn();
            jest.spyOn(projetoHelperAPI, 'buscaPlanilhaOriginal');
            const idPreProjeto = 273246;
            actions.buscaPlanilhaOriginal({ commit }, idPreProjeto);
        });

        test('it calls projetoHelperAPI.buscaPlanilhaOriginal', () => {
            expect(projetoHelperAPI.buscaPlanilhaOriginal).toHaveBeenCalled();
        });

        test('it is commit to buscaPlanilhaOriginal', (done) => {
            const planilhaOriginal = mockReponse.data;
            done();
            expect(commit).toHaveBeenCalledWith('SET_PLANILHA_ORIGINAL', planilhaOriginal.data);
        });
    });

    describe('buscaPlanilhaReadequada', () => {
        beforeEach(() => {
            mockReponse = {
                data: {
                    data: {
                        planilhaReadequada: {
                            tpPlanilha: 'RP',
                            IdPronac: '189786',
                            PRONAC: '150151',
                        },
                    },
                },
            };

            axios.get.mockResolvedValue(mockReponse);

            commit = jest.fn();
            jest.spyOn(projetoHelperAPI, 'buscaPlanilhaReadequada');
            const idPronac = 123456;
            actions.buscaPlanilhaReadequada({ commit }, idPronac);
        });

        test('it calls projetoHelperAPI.buscaPlanilhaReadequada', () => {
            expect(projetoHelperAPI.buscaPlanilhaReadequada).toHaveBeenCalled();
        });

        test('it is commit to buscaPlanilhaReadequada', (done) => {
            const planilhaReadequada = mockReponse.data;
            done();
            expect(commit).toHaveBeenCalledWith('SET_PLANILHA_READEQUADA', planilhaReadequada.data);
        });
    });

    describe('buscaPlanilhaAutorizada', () => {
        beforeEach(() => {
            mockReponse = {
                data: {
                    data: {
                        planilhaAutorizada: {
                            tpPlanilha: 'CO',
                            idPronac: '200728',
                            PRONAC: '1510482',
                        },
                    },
                },
            };

            axios.get.mockResolvedValue(mockReponse);

            commit = jest.fn();
            jest.spyOn(projetoHelperAPI, 'buscaPlanilhaAutorizada');
            const idPreProjeto = 273246;
            actions.buscaPlanilhaAutorizada({ commit }, idPreProjeto);
        });

        test('it calls projetoHelperAPI.buscaPlanilhaAutorizada', () => {
            expect(projetoHelperAPI.buscaPlanilhaAutorizada).toHaveBeenCalled();
        });

        test('it is commit to buscaPlanilhaAutorizada', (done) => {
            const planilhaAutorizada = mockReponse.data;
            done();
            expect(commit).toHaveBeenCalledWith('SET_PLANILHA_AUTORIZADA', planilhaAutorizada.data);
        });
    });

    describe('buscaPlanilhaAdequada', () => {
        beforeEach(() => {
            mockReponse = {
                data: {
                    data: {
                        planilhaAdequada: {
                            Seq: '28',
                            idPlanilhaProposta: '4913779',
                            idEtapa: '8',
                        },
                    },
                },
            };

            axios.get.mockResolvedValue(mockReponse);

            commit = jest.fn();
            jest.spyOn(projetoHelperAPI, 'buscaPlanilhaAdequada');
            const idPreProjeto = 273246;
            actions.buscaPlanilhaAdequada({ commit }, idPreProjeto);
        });

        test('it calls projetoHelperAPI.buscaPlanilhaAdequada', () => {
            expect(projetoHelperAPI.buscaPlanilhaAdequada).toHaveBeenCalled();
        });

        test('it is commit to buscaPlanilhaAdequada', (done) => {
            const planilhaAdequada = mockReponse.data;
            done();
            expect(commit).toHaveBeenCalledWith('SET_PLANILHA_ADEQUADA', planilhaAdequada.data);
        });
    });

    describe('buscarTransferenciaRecursos', () => {
        beforeEach(() => {
            mockReponse = {
                data: {
                    data: {
                        transferenciaRecursos: {
                            idPronacTransferidor: 1,
                            PronacTransferidor: 111111,
                            NomeProjetoTranferidor: 'Criança Para Vida - 15 anos',
                            idPronacRecebedor: 2,
                            PronacRecebedor: 222222,
                            NomeProjetoRecedor: 'Criança Para Vida - 15 anos',
                            dtRecebimento: new Date(),
                            vlRecebido: parseFloat('1000000'),
                        },
                    },
                },
            };

            axios.get.mockResolvedValue(mockReponse);

            commit = jest.fn();
            jest.spyOn(projetoHelperAPI, 'buscarTransferenciaRecursos');
            const acao = 'transferidor';
            actions.buscarTransferenciaRecursos({ commit }, acao);
        });

        test('it calls projetoHelperAPI.buscarTransferenciaRecursos', () => {
            expect(projetoHelperAPI.buscarTransferenciaRecursos).toHaveBeenCalled();
        });

        test('it is commit to buscarTransferenciaRecursos', (done) => {
            const transferenciaRecursos = mockReponse.data;
            done();
            expect(commit).toHaveBeenCalledWith('SET_TRANSFERENCIA_RECURSOS', transferenciaRecursos.data);
        });
    });

    describe('buscarCertidoesNegativas', () => {
        beforeEach(() => {
            mockReponse = {
                data: {
                    data: {
                        items: {
                            certidoes: {
                                dsCertidao: 'Quita&ccedil;&atilde;o de Tributos Federais',
                                CodigoCertidao: 49,
                                Pronac: 160059,
                            },
                        },
                    },
                },
            };

            axios.get.mockResolvedValue(mockReponse);

            commit = jest.fn();
            jest.spyOn(projetoHelperAPI, 'buscarCertidoesNegativas');
            const idPronac = 216941;
            actions.buscarCertidoesNegativas({ commit }, idPronac);
        });

        test('it calls projetoHelperAPI.buscarCertidoesNegativas', () => {
            expect(projetoHelperAPI.buscarCertidoesNegativas).toHaveBeenCalled();
        });

        test('it is commit to buscarCertidoesNegativas', (done) => {
            const certidoesNegativas = mockReponse.data;
            done();
            expect(commit).toHaveBeenCalledWith('SET_CERTIDOES_NEGATIVAS', certidoesNegativas.data.items);
        });
    });

    describe('buscarDocumentosAssinados', () => {
        beforeEach(() => {
            mockReponse = {
                data: {
                    data: {
                        items: {
                            dsAtoAdministrativo: 'Parecer de Aprova&ccedil;&atilde;o Preliminar',
                            idDocumentoAssinatura: 3564,
                            pronac: 178894,
                        },
                    },
                },
            };

            axios.get.mockResolvedValue(mockReponse);

            commit = jest.fn();
            jest.spyOn(projetoHelperAPI, 'buscarDocumentosAssinados');
            const idPronac = 216941;
            actions.buscarDocumentosAssinados({ commit }, idPronac);
        });

        test('it calls projetoHelperAPI.buscarDocumentosAssinados', () => {
            expect(projetoHelperAPI.buscarDocumentosAssinados).toHaveBeenCalled();
        });

        test('it is commit to buscarDocumentosAssinados', (done) => {
            const documentosAssinados = mockReponse.data;
            done();
            expect(commit).toHaveBeenCalledWith('SET_DOCUMENTOS_ASSINADOS', documentosAssinados.data.items);
        });
    });

    describe('buscarDadosComplementares', () => {
        beforeEach(() => {
            mockReponse = {
                data: {
                    data: {
                        items: {
                            CustosVinculados: {
                                Descricao: 'Custos de Administra&ccedil;&atilde;o',
                                Percentual: 15,
                            },
                            Proposta: {
                                Objetivos: 'Objetivo espec&iacute;fico do projeto &eacute; a realiza&ccedil;&atilde;o de tr&ecirc;s atra&ccedil;&otilde;es',
                            },
                        },
                    },
                },
            };

            axios.get.mockResolvedValue(mockReponse);

            commit = jest.fn();
            jest.spyOn(projetoHelperAPI, 'buscarDadosComplementares');
            const idPronac = 216941;
            actions.buscarDadosComplementares({ commit }, idPronac);
        });

        test('it calls projetoHelperAPI.buscarDadosComplementares', () => {
            expect(projetoHelperAPI.buscarDadosComplementares).toHaveBeenCalled();
        });

        test('it is commit to buscarDadosComplementares', (done) => {
            const dadosComplementares = mockReponse.data;
            done();
            expect(commit).toHaveBeenCalledWith('SET_DADOS_COMPLEMENTARES', dadosComplementares.data.items);
        });
    });

    describe('buscarDocumentosAnexados', () => {
        beforeEach(() => {
            mockReponse = {
                data: {
                    data: {
                        items: {
                            documentos: {
                                Anexado: 'Documento do Proponente',
                                idArquivo: 180609,
                                AgenteDoc: 1,
                            },
                        },
                    },
                },
            };

            axios.get.mockResolvedValue(mockReponse);

            commit = jest.fn();
            jest.spyOn(projetoHelperAPI, 'buscarDocumentosAnexados');
            const idPronac = 216941;
            actions.buscarDocumentosAnexados({ commit }, idPronac);
        });

        test('it calls projetoHelperAPI.buscarDocumentosAnexados', () => {
            expect(projetoHelperAPI.buscarDocumentosAnexados).toHaveBeenCalled();
        });

        test('it is commit to buscarDocumentosAnexados', (done) => {
            const documentosAnexados = mockReponse.data;
            done();
            expect(commit).toHaveBeenCalledWith('SET_DOCUMENTOS_ANEXADOS', documentosAnexados.data.items);
        });
    });

    describe('buscarLocalRealizacaoDeslocamento', () => {
        beforeEach(() => {
            mockReponse = {
                data: {
                    data: {
                        items: {
                            localRealizacoes: {
                                Descricao: 'Brasil',
                                UF: 'Santa Catarina',
                                Cidade: 'Conc&oacute;rdia',
                            },
                            Deslocamento: {
                                Qtde: 28,
                                PaisOrigem: 'Brasil',
                            },
                        },
                    },
                },
            };

            axios.get.mockResolvedValue(mockReponse);

            commit = jest.fn();
            jest.spyOn(projetoHelperAPI, 'buscarLocalRealizacaoDeslocamento');
            const idPronac = 216941;
            actions.buscarLocalRealizacaoDeslocamento({ commit }, idPronac);
        });

        test('it calls projetoHelperAPI.buscarLocalRealizacaoDeslocamento', () => {
            expect(projetoHelperAPI.buscarLocalRealizacaoDeslocamento).toHaveBeenCalled();
        });

        test('it is commit to buscarLocalRealizacaoDeslocamento', (done) => {
            const localRealizacaoDeslocamento = mockReponse.data;
            done();
            expect(commit).toHaveBeenCalledWith('SET_LOCAL_REALIZACAO_DESLOCAMENTO', localRealizacaoDeslocamento.data.items);
        });
    });
});
