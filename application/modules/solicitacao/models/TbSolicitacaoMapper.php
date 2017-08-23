<?php

/**
 * Class Solicitacao_Model_TbSolicitacaoMapper
 */
class Solicitacao_Model_TbSolicitacaoMapper extends MinC_Db_Mapper
{
    protected $_idUsuario;

    public function __construct()
    {
        $this->setDbTable('Solicitacao_Model_DbTable_TbSolicitacao');

        $auth = Zend_Auth::getInstance(); // pega a autenticacao
        $arrAuth = array_change_key_case((array)$auth->getIdentity());

        $this->_idUsuario = !empty($arrAuth['usu_codigo']) ? $arrAuth['usu_codigo'] : $arrAuth['idusuario'];
    }

    public function existeSolicitacaoNaoRespondida($arrData, $estado = 1)
    {
        if (isset($arrData['idSolicitacao'])) {
            $where['idSolicitacao = ?'] = $arrData['idSolicitacao'];
        }

        if (isset($arrData['idPronac'])) {
            $where['idPronac = ?'] = $arrData['idPronac'];
        }

        if (isset($arrData['idProjeto'])) {
            $where['idProjeto = ?'] = $arrData['idProjeto'];
        }


        $where['idSolicitante = ?'] = $this->_idUsuario;


        $where['stEstado = ?'] = $estado;

        return ($this->findBy($where)) ? true : false;
    }

    public function isValid($model)
    {
        $booStatus = true;
        $arrData = $model->toArray();
        if (empty($arrData['idSolicitacao'])) {
            $arrRequired = array(
                'idOrgao',
                'dsSolicitacao',
            );
        } else {
            $arrRequired = array(
                'dsResposta',
            );
        }
        foreach ($arrRequired as $strValue) {
            if (!isset($arrData[$strValue]) || empty($arrData[$strValue])) {
                $this->setMessage('Campo obrigat&oacute;rio!', $strValue);
                $booStatus = false;
            }
        }
        return $booStatus;
    }

    public function salvar($arrData)
    {
        $booStatus = 0;
        $idDocumento = '';

        if (!empty($arrData)) {

            try {

                $sp = new Solicitacao_Model_SpSelecionarTecnicoSolicitacao();
                
                if (!empty($arrData['idPronac'])) {
                    $tecnico = $sp->exec($arrData['idPronac'], 'projeto');

                } elseif (!empty($arrData['idProjeto'])) {
                    $tecnico = $sp->exec($arrData['idProjeto'], 'proposta');
                }

                if (empty($tecnico))
                    throw new Exeception("Erro ao salvar! T&eacute;cnico n&atilde;o encontrado!");

                $arrData['idOrgao'] = $tecnico['idOrgao'];
                $arrData['idTecnico'] = $tecnico['idTecnico'];
                $arrData['idAgente'] = $tecnico['idAgente'];
                $model = new Solicitacao_Model_TbSolicitacao();
                $model->setDtSolicitacao(date('Y-m-d h:i:s'));
                $model->setIdOrgao($arrData['idOrgao']);
                $model->setIdAgente($arrData['idAgente']);
                $model->setSiEncaminhamento(Solicitacao_Model_TbSolicitacao::SOLICITACAO_CADASTRADA);
                $model->setDsSolicitacao($arrData['dsSolicitacao']);
                $model->setStEstado(1);
                $model->setIdPronac($arrData['idPronac']);
                $model->setIdProjeto($arrData['idProjeto']);
                $model->setIdTecnico($arrData['idTecnico']);
                $model->setIdSolicitante($arrData['idUsuario']);

                $file = new Zend_File_Transfer();

                if (!empty($file->getFileInfo())) {

                    $arrDoc = [];
                    $arrDoc['idTipoDocumento'] = 24;
                    $arrDoc['dsDocumento'] = 'Anexo solicita&ccedil;&atilde;o';

                    $mapperArquivo = new Arquivo_Model_TbDocumentoMapper();
                    $idDocumento = $mapperArquivo->saveCustom($arrDoc, $file);

                }
                $model->setIdDocumento($idDocumento);

                if ($id = $this->save($model)) {
                    $booStatus = $id;
                    $this->setMessage('Rascunho salvo com sucesso!');
                } else {
                    $this->setMessage('N&atilde;o foi poss&iacute;vel salvar o rascunho!');
                }
            } catch (Exception $e) {
                $this->setMessage($e->getMessage());
            }
        }
        return $booStatus;
    }

    public function responder($arrData)
    {
        $booStatus = 0;

        if (!empty($arrData)) {

            try {
                $model = new Solicitacao_Model_TbSolicitacao();
                $model->setIdSolicitacao($arrData['idSolicitacao']);
                $model->setDtResposta(date('Y-m-d h:i:s'));
                $model->setDsResposta($arrData['dsResposta']);
                $model->setIdTecnico($this->_idUsuario);
                $model->setSiEncaminhamento(Solicitacao_Model_TbSolicitacao::SOLICITACAO_FINALIZADA_MINC);
                $model->setStEstado(0);

                if ($id = $this->save($model)) {
                    $booStatus = $id;
                    $this->setMessage('Solicita&ccedil;&atilde;o respondida com sucesso!');
                } else {
                    $this->setMessage('N&atilde;o foi poss&iacute;vel salvar a resposta da solicita&ccedil;&atilde;o!');
                }
            } catch (Exception $e) {
                $this->setMessage($e->getMessage());
            }
        }
        return $booStatus;
    }
}
