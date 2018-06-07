<?php

namespace Application\Modules\Readequacao\Service\Assinatura;

class DocumentoAssinatura implements \MinC\Assinatura\Servico\IDocumentoAssinatura
{
    private $idPronac;
    private $idTipoDoAtoAdministrativo;
    private $idAtoDeGestao;

    public function __construct(
        $idPronac,
        $idTipoDoAtoAdministrativo,
        $idAtoDeGestao = null
    )
    {
        if (!isset($idPronac) || empty($idPronac)) {
            throw new \Exception("Identificador do projeto n&atilde;o informado");
        }

        if (!isset($idTipoDoAtoAdministrativo) || empty($idTipoDoAtoAdministrativo)) {
            throw new \Exception("Identificador do Tipo do Ato Administrativo n&atilde;o informado");
        }

        $this->idPronac = $idPronac;
        $this->idTipoDoAtoAdministrativo = $idTipoDoAtoAdministrativo;
        $this->idAtoDeGestao = $idAtoDeGestao;
    }

    public function iniciarFluxo()
    {
        $auth = \Zend_Auth::getInstance();
        $objDbTableDocumentoAssinatura = new \Assinatura_Model_DbTable_TbDocumentoAssinatura();

        $objModelDocumentoAssinatura = new \Assinatura_Model_TbDocumentoAssinatura([
            'IdPRONAC' => $this->idPronac,
            'idTipoDoAtoAdministrativo' => $this->idTipoDoAtoAdministrativo,
            'conteudo' => $this->criarDocumento(),
            'dt_criacao' => $objDbTableDocumentoAssinatura->getExpressionDate(),
            'idCriadorDocumento' => $auth->getIdentity()->usu_codigo,
            'cdSituacao' => \Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA,
            'idAtoDeGestao' => $this->idAtoDeGestao,
            'stEstado' => \Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_ATIVO,
        ]);

        $objDocumentoAssinatura = new \MinC\Assinatura\Servico\DocumentoAssinatura();
        $objDocumentoAssinatura->registrarDocumentoAssinatura($objModelDocumentoAssinatura);
    }

    /**
     * @return string
     */
    public function criarDocumento()
    {
        $view = new \Zend_View();
        $view->setScriptPath(
            __DIR__
            . DIRECTORY_SEPARATOR
            . 'template'
        );

        $view->titulo = 'Parecer T&eacute;cnico de Aprova&ccedil;&atilde;o Preliminar';

        $objPlanoDistribuicaoProduto = new \Projeto_Model_vwPlanoDeDistribuicaoProduto();
        $view->dadosProducaoProjeto = $objPlanoDistribuicaoProduto->obterProducaoProjeto(array(
            'IdPRONAC = ?' => $this->idPronac
        ));

        $view->IdPRONAC = $this->idPronac;

        $objProjeto = new \Projeto_Model_DbTable_Projetos();
        $view->projeto = $objProjeto->findBy(array('IdPRONAC' => $this->idPronac));

        $objAgentes = new \Agente_Model_DbTable_Agentes();
        $dadosAgente = $objAgentes->buscarFornecedor(array('a.CNPJCPF = ?' => $view->projeto['CgcCpf']));
        $arrayDadosAgente = $dadosAgente->current();

        $view->nomeAgente = (count($arrayDadosAgente) > 0) ? $arrayDadosAgente['nome'] : ' - ';

        $mapperArea = new \Agente_Model_AreaMapper();
        $view->areaCultural = $mapperArea->findBy(array(
            'Codigo' => $view->projeto['Area']
        ));
        $objSegmentocultural = new \Segmentocultural();
        $view->segmentoCultural = $objSegmentocultural->findBy(
            array(
                'Codigo' => $view->projeto['Segmento']
            )
        );
        $view->valoresProjeto = $objProjeto->obterValoresProjeto($this->idPronac);

        $objProjeto = new \Projeto_Model_DbTable_Projetos();
        $dadosProjeto = $objProjeto->findBy(array(
            'IdPRONAC' => $this->idPronac
        ));

        $objEnquadramento = new \Admissibilidade_Model_Enquadramento();
        $arrayPesquisa = array(
            'AnoProjeto' => $dadosProjeto['AnoProjeto'],
            'Sequencial' => $dadosProjeto['Sequencial'],
            'IdPRONAC' => $this->idPronac
        );

        $view->dadosEnquadramento = $objEnquadramento->findBy($arrayPesquisa);

        $auth = \Zend_Auth::getInstance();
        $dadosUsuarioLogado = $auth->getIdentity();
        $view->orgaoSuperior = $dadosUsuarioLogado->usu_org_max_superior;

        return $view->render('documento-assinatura.phtml');
    }

    public function finalizarFluxo()
    {
        $objProjetos = new \Projetos();
        $objProjetos->alterarSituacao(
            $this->idPronac,
            null,
            \Projeto_Model_Situacao::PROJETO_APROVADO_AGUARDANDO_ANALISE_DOCUMENTAL,
            'Projeto aprovado - aguardando an&aacute;lise documental'
        );

        $objTbProjetos = new \Projeto_Model_DbTable_Projetos();
        $dadosProjeto = $objTbProjetos->findBy(array(
            'IdPRONAC' => $this->idPronac
        ));

        $orgaoDestino = \Orgaos::ORGAO_SAV_DAP;
        $objOrgaos = new \Orgaos();
        $dadosOrgaoSuperior = $objOrgaos->obterOrgaoSuperior($dadosProjeto['Orgao']);

        if ($dadosOrgaoSuperior['Codigo'] == \Orgaos::ORGAO_SUPERIOR_SEFIC) {
            $orgaoDestino = \Orgaos::ORGAO_GEAAP_SUAPI_DIAAPI;
        }
        $objTbProjetos->alterarOrgao($orgaoDestino, $this->idPronac);

        $enquadramento = new \Admissibilidade_Model_Enquadramento();
        $dadosEnquadramento = $enquadramento->obterEnquadramentoPorProjeto($this->idPronac, $dadosProjeto['AnoProjeto'], $dadosProjeto['Sequencial']);

        $objModelDocumentoAssinatura = new \Assinatura_Model_DbTable_TbDocumentoAssinatura();
        $data = [
            'cdSituacao' => \Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_FECHADO_PARA_ASSINATURA
        ];
        $where = [
            'IdPRONAC = ?' => $this->idPronac,
            'idTipoDoAtoAdministrativo = ?' => $this->idTipoDoAtoAdministrativo,
            'idAtoDeGestao = ?' => $dadosEnquadramento['IdEnquadramento'],
            'cdSituacao = ?' => \Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA,
            'stEstado = ?' => \Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_ATIVO
        ];
        $objModelDocumentoAssinatura->update($data, $where);

        $valoresProjeto = $objTbProjetos->obterValoresProjeto($this->idPronac);
        $auth = \Zend_Auth::getInstance();
        $objAprovacao = new \Aprovacao();
        $idAprovacao = $objAprovacao->inserir([
            'IdPRONAC' => $this->idPronac,
            'AnoProjeto' => $dadosProjeto['AnoProjeto'],
            'Sequencial' => $dadosProjeto['Sequencial'],
            'TipoAprovacao' => 1,
            'dtAprovacao' => $objTbProjetos->getExpressionDate(),
            'ResumoAprovacao' => $dadosEnquadramento['Observacao'],
            'AprovadoReal' => $valoresProjeto['ValorProposta'],
            'Logon' => $auth->getIdentity()->usu_codigo,
        ]);

        $idTecnico = new \Zend_Db_Expr("sac.dbo.fnPegarTecnico(110, {$orgaoDestino}, 3)");

        $tblVerificaProjeto = new \tbVerificaProjeto();
        $dadosVP['idPronac'] = $this->idPronac;
        $dadosVP['idOrgao'] = $orgaoDestino;
        $dadosVP['idAprovacao'] = $idAprovacao;
        $dadosVP['idUsuario'] = $idTecnico;
        $dadosVP['stAnaliseProjeto'] = 1;
        $dadosVP['dtRecebido'] = $tblVerificaProjeto->getExpressionDate();
        $dadosVP['stAtivo'] = 1;
        $tblVerificaProjeto->inserir($dadosVP);
    }

    public function devolverProjeto($motivoDevolucao)
    {

        $objProjetosDbTable = new \Projeto_Model_DbTable_Projetos();
        $projeto = $objProjetosDbTable->findBy(array(
            'IdPRONAC' => $this->idPronac
        ));

        $objTbDepacho = new \Proposta_Model_DbTable_TbDespacho();
        $objTbDepacho->devolverProjetoEncaminhadoParaAssinatura($this->idPronac, $motivoDevolucao);

        $objOrgaos = new \Orgaos();
        $orgaoSuperior = $objOrgaos->obterOrgaoSuperior($projeto['Orgao']);

        $orgaoDestino = \Orgaos::ORGAO_SAV_DAP;
        if ($orgaoSuperior['Codigo'] == \Orgaos::ORGAO_SUPERIOR_SEFIC) {
            $orgaoDestino = \Orgaos::ORGAO_GEAAP_SUAPI_DIAAPI;
        }

        $objProjetosDbTable->alterarOrgao($orgaoDestino, $this->idPronac);
        $objProjetos = new \Projetos();
        $objProjetos->alterarSituacao(
            $this->idPronac,
            null,
            \Projeto_Model_Situacao::PROJETO_DEVOLVIDO_PARA_ENQUADRAMENTO,
            'Projeto encaminhado para nova avalia&ccedil;&atilde;o do readequacao'
        );

        $objModelDocumentoAssinatura = new \Assinatura_Model_DbTable_TbDocumentoAssinatura();
        $data = array(
            'cdSituacao' => \Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_FECHADO_PARA_ASSINATURA,
            'stEstado' => \Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_INATIVO
        );
        $where = array(
            'IdPRONAC = ?' => $this->idPronac,
            'idTipoDoAtoAdministrativo = ?' => $this->idTipoDoAtoAdministrativo,
            'cdSituacao = ?' => \Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA,
            'stEstado = ?' => \Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_ATIVO
        );

        $objModelDocumentoAssinatura->update($data, $where);
    }
}
