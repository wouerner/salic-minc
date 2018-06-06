<?php

namespace Application\Modules\Readequacao\Service;

class Assinatura implements \MinC\Assinatura\Documento\IDocumentoAssinatura
{
    public $idPronac;
    private $idTipoDoAtoAdministrativo;

    private $post;

    public function __construct($post, $idTipoDoAtoAdministrativo)
    {
        $this->post = $post;
        $this->idTipoDoAtoAdministrativo = $idTipoDoAtoAdministrativo;
    }

    public function iniciarFluxo()
    {
        $auth = \Zend_Auth::getInstance();
        $objDbTableDocumentoAssinatura = new \Assinatura_Model_DbTable_TbDocumentoAssinatura();

        /**
         * @todo Campo 'idAtoDeGestao' está definido como null porque o Rômulo
         * ainda não informou qual informação deve ser armazenada.
         */
        $objModelDocumentoAssinatura = new \Assinatura_Model_TbDocumentoAssinatura([
            'IdPRONAC' => $this->idPronac,
            'idTipoDoAtoAdministrativo' => $this->idTipoDoAtoAdministrativo,
            'conteudo' => $this->criarDocumento(),
            'dt_criacao' => $objDbTableDocumentoAssinatura->getExpressionDate(),
            'idCriadorDocumento' => $auth->getIdentity()->usu_codigo,
            'cdSituacao' => \Assinatura_Model_TbDocumentoAssinatura::CD_SITUACAO_DISPONIVEL_PARA_ASSINATURA,
            'idAtoDeGestao' => NULL,
            'stEstado' => \Assinatura_Model_TbDocumentoAssinatura::ST_ESTADO_DOCUMENTO_ATIVO,
        ]);

        $objDocumentoAssinatura = new \MinC\Assinatura\Servico\Assinatura(
            $this->post,
            $auth->getIdentity()
        );
        $objDocumentoAssinatura->obterServicoDocumento()
                               ->registrarDocumentoAssinatura($objModelDocumentoAssinatura);
    }

    /**
     * @return string
     */
    public function criarDocumento()
    {
        $view = new \Zend_View();
        $view->setScriptPath(
            APPLICATION_PATH
            . DIRECTORY_SEPARATOR
            . 'modules/readequacao/views/scripts/enquadramento-documento-assinatura'
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
}
