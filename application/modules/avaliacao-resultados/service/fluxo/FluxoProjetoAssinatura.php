<?php

namespace Application\Modules\AvaliacaoResultados\Service\Fluxo;

class FluxoProjetoAssinatura
{
    /**
     * @var \Zend_Controller_Request_Abstract $request
     */
    private $request;

    /**
     * @var \Zend_Controller_Response_Abstract $response
     */
    private $response;

    function __construct(\Zend_Controller_Request_Abstract $request, \Zend_Controller_Response_Abstract $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function projetosAguardandoAssinatura()
    {
        $tbAssinaturaDbTable = new \Assinatura_Model_DbTable_TbDocumentoAssinatura();
        $select = $tbAssinaturaDbTable->select();
        $select->setIntegrityCheck(false);
        $select->from(
            ['a' => $tbAssinaturaDbTable->getTableName()],
            '',
            $tbAssinaturaDbTable->getSchema()
        );
        $select->join(
            ['p' => 'projetos'],
            'p.idpronac = a.idpronac',
            ['*', new \Zend_Db_Expr('p.anoprojeto+p.sequencial as PRONAC')],
            $tbAssinaturaDbTable->getSchema()
        );
        $select->where('a.idTipoDoAtoAdministrativo = ?', 622);
        $select->where('a.stEstado = ?', 1);
        $select->where('a.cdSituacao = ?', 1);
        
        return $tbAssinaturaDbTable->fetchAll($select);
    }
}