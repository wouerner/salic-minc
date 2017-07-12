<?php

class fnVerificarProjetoAprovadoIN2017 extends MinC_Db_Table_Abstract {

    protected $_schema = 'SAC';
    protected $_name = 'fnVerificarProjetoAprovadoIN2017';

    /**
     * @Deprecated 
     */
    public function verificarProjetoAprovadoIN2017($idPronac) {
        $select = new Zend_Db_Expr("SELECT sac.dbo.fnVerificar_Projeto_Aprovado_IN2017()");
        try {
            $db= Zend_Db_Table::getDefaultAdapter();
            $db->setFetchMode(Zend_DB::FETCH_OBJ);
        } catch (Zend_Exception_Db $e) {
            $this->view->message = $e->getMessage();
        }
        return $db->fetchRow($select);
    }

    /**
     * FUNÇÃO QUE VERIFICA SE PROJETO ESTÁ SOB A IN 2017
     * @author Fernão Lopes Ginez de Lara <fernao.lara@cultura.gov.br>
     * @param null $idPronac
     * @return bool
     */    
    public function verificar($idPronac) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB::FETCH_OBJ);

        $sql = $db->select()
                  ->from(array('a' => 'tbDocumentoAssinatura'),
                  array('a.IdPRONAC'),
                  $this->_schema
                  )
                  ->joinInner(array('b' => 'Projetos'),
                  'b.IdPRONAC = a.IdPRONAC',
                  NULL,
                  $this->_schema)
                  ->joinInner(array('c' => 'Aprovacao'),
                  'c.IdPRONAC = a.IdPRONAC',
                  NULL,
                  $this->_schema)            
                  ->where('a.cdSituacao = ? ', '2')
                  ->where('a.stEstado = ? ', '1')
                  ->where('c.TipoAprovacao = ? ', '1')
                  ->where('b.IdPRONAC = ? ', $idPronac);

        if($db->fetchRow($sql)) {
            return 1;
        } else {
            return 0;
        }
    }
}