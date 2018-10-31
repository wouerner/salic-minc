<?php

namespace Application\Modules\AvaliacaoResultados\Service\ParecerTecnico;


class Diligencia
{
    /** modules/proposta/controllers/DiligenciarController -> listardiligenciaanalistaAction */
        public function listaDiligenciaPainel (Array $params = null) {
              $Projetosdao = new Projetos();
              $PreProjetodao = new Proposta_Model_DbTable_PreProjeto();

              var_dump('EEEIIII' + $params);
              die;

              $this->view->idPronac = $this->idPronac;
              $this->view->idPreProjeto = $this->idPreProjeto;
              $this->view->situacao = $this->situacao;
              $this->view->idProduto = $this->idProduto;
              $this->view->tpDiligencia = $this->tpDiligencia;

               if ($this->view->idPronac) {
                   if ($this->idProduto) {
                       $this->view->diligencias = $Projetosdao->listarDiligencias(
                            array(
                                'pro.IdPRONAC = ?' => $this->idPronac,
                                'dil.idProduto = ?' => $this->idProduto,
                                'dil.stEnviado = ?' => 'S'
                            )
                        );
                   } else {
                         $projeto = $Projetosdao->buscar(array('IdPRONAC = ?' => $this->idPronac));
                         $_idProjeto = isset($projeto[0]->idProjeto) && !empty($projeto[0]->idProjeto) ? $projeto[0]->idProjeto : 0;
                         $this->view->diligenciasProposta = $PreProjetodao->listarDiligenciasPreProjeto(
                                array(
                                    'pre.idPreProjeto = ?' => $_idProjeto,
                                    'aval.ConformidadeOK = ?' => 0
                                )
                         );

                         $this->view->diligencias = $Projetosdao->listarDiligencias(array('pro.IdPRONAC = ?' => $this->idPronac));
                   }
               } else {
                    if ($this->view->idPreProjeto) {
            //          $this->view->diligenciasProposta = $dao->listarDiligenciasPreProjeto(array('pre.idPreProjeto = ?' => $this->idPreProjeto, 'aval.ConformidadeOK = ? ' => 0));
                    }
               }
        }

        public function coisinha(){
            return 'teste';
        }

        /** module/default/models/projetos.php */
    public function listarDiligencias($consulta = array(), $retornaSelect = false)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(
            array('pro' => $this->_name),
            array('nomeProjeto' => 'pro.NomeProjeto', 'pronac' => new Zend_Db_Expr('pro.AnoProjeto+pro.Sequencial'))
        );

        $select->joinInner(
            array('dil' => 'tbDiligencia'),
            'dil.idPronac = pro.IdPRONAC',
            array(
                'dil.stProrrogacao',
                'idDiligencia' => 'dil.idDiligencia',
                'dataSolicitacao' => 'dil.DtSolicitacao',
                'dataResposta' => 'dil.DtResposta',
                'Solicitacao' => 'dil.Solicitacao',
                'Resposta' => new Zend_Db_Expr('CAST(dil.Resposta AS TEXT)'),
                'dil.idCodigoDocumentosExigidos',
                'dil.idTipoDiligencia',
                'dil.stEnviado'
            )
        );
        $select->joinInner(array('ver' => 'Verificacao'), 'ver.idVerificacao = dil.idTipoDiligencia', array('tipoDiligencia' => 'ver.Descricao'));
        $select->joinLeft(array('prod' => 'Produto'), 'prod.Codigo = dil.idProduto', array('produto' => 'prod.Descricao'));


        foreach ($consulta as $coluna => $valor) {
            $select->where($coluna, $valor);
        }

        if ($retornaSelect) {
            return $select;
        } else {
            return $this->fetchAll($select);
        }
    }

    /** modules/proposta/models/DbTable/preprojeto.php */
    public function listarDiligenciasPreProjeto($consulta = array(), $retornaSelect = false)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(
            array('pre' => $this->_name),
            array('nomeProjeto' => 'pre.nomeprojeto', 'pronac' => 'pre.idpreprojeto'),
            $this->_schema
        );

        $select->joinInner(
            array('aval' => 'tbAvaliacaoProposta'),
            'aval.idProjeto = pre.idPreProjeto',
            array(
                'aval.stProrrogacao',
                'idDiligencia' => 'aval.idAvaliacaoProposta',
                'idAvaliacaoProposta' => 'aval.idAvaliacaoProposta',
                'dataSolicitacao' => new Zend_Db_Expr('CONVERT(VARCHAR,aval.DtAvaliacao,120)'),
                'dataResposta' => new Zend_Db_Expr('CONVERT(VARCHAR,aval.dtResposta,120)'),
                'Solicitacao' => 'aval.Avaliacao',
                'Resposta' => 'aval.dsResposta',
                'aval.idCodigoDocumentosExigidos',
                'aval.stEnviado'
            ),
            $this->_schema
        );

        $select->joinLeft(
            array('arq' => 'tbArquivo'),
            'arq.idArquivo = aval.idArquivo',
            array(
                'arq.nmArquivo',
                'arq.idArquivo'
            ),
            $this->getSchema('bdcorporativo', true, 'sccorp')
        );

        $select->joinLeft(
            array('a' => 'AGENTES'),
            'pre.idAgente = a.idAgente',
            array(
                'a.idAgente'
            ),
            $this->getSchema('agentes')
        );

        $select->joinLeft(
            array('n' => 'NOMES'),
            'a.idAgente = n.idAgente',
            array(
                'n.Descricao'
            ),
            $this->getSchema('agentes')
        );

        foreach ($consulta as $coluna => $valor) {
            $select->where($coluna, $valor);
        }


        if ($retornaSelect) {
            return $select;
        } else {
            return $this->fetchAll($select);
        }
    }


}
