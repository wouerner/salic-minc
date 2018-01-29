<?php

class Admissibilidade_AvaliacaoPropostaController extends MinC_Controller_Action_Abstract
{
    public function init()
    {
        parent::perfil();
        parent::init();
        $this->auth = Zend_Auth::getInstance();
        $this->grupoAtivo = new Zend_Session_Namespace('GrupoAtivo');
    }

//    public function indexAction()
//    {
//        $this->redirect("/admissibilidade/enquadramento-proposta/gerenciar-enquadramento");
//    }

    public function encaminharPropostaAction()
    {
        try {
            $post = $this->getRequest()->getPost();
            $id_preprojeto = trim($post['id_preprojeto']);
            if (empty($id_preprojeto)) {
                throw new Exception("Identificador da Proposta nao informado.");
            }

            $id_perfil = trim($post['id_perfil']);
            if (empty($id_perfil)) {
                throw new Exception("Identificador do Perfil nao informado.");
            }

//            $get = $this->getRequest()->getParams();

//            $this->view->id_perfil_usuario = $this->grupoAtivo->codGrupo;
//            $this->view->id_orgao = $this->grupoAtivo->codOrgao;
//            $this->view->id_usuario_avaliador = $this->auth->getIdentity()->usu_codigo;
//
//            $id_area = ($post['id_area']) ? $post['id_area'] : null;
//            $id_segmento = ($post['id_segmento']) ? $post['id_segmento'] : null;
//            $objEnquadramento = new Admissibilidade_Model_DbTable_SugestaoEnquadramento();
//
//            $arrayArmazenamentoEnquadramento = array(
//                'id_preprojeto' => $get['id_preprojeto'],
//                'id_orgao' => $this->grupoAtivo->codOrgao,
//                'id_perfil_usuario' => $this->grupoAtivo->codGrupo,
//                'id_usuario_avaliador' => $this->auth->getIdentity()->usu_codigo,
//                'id_area' => $id_area,
//                'id_segmento' => $id_segmento,
//                'descricao_motivacao' => $descricao_motivacao,
//                'data_avaliacao' => $objEnquadramento->getExpressionDate(),
//            );
//
//            $arrayDadosEnquadramento = $objEnquadramento->findBy(
//                [
//                    'id_preprojeto' => $get['id_preprojeto'],
//                    'id_orgao' => $this->grupoAtivo->codOrgao,
//                    'id_perfil_usuario' => $this->grupoAtivo->codGrupo,
//                    'id_usuario_avaliador' => $this->auth->getIdentity()->usu_codigo
//                ]
//            );
//
//            if (count($arrayDadosEnquadramento) < 1) {
//                $objEnquadramento->inserir($arrayArmazenamentoEnquadramento);
//            } else {
//                $objEnquadramento->update($arrayArmazenamentoEnquadramento, [
//                    'id_sugestao_enquadramento = ?' => $arrayDadosEnquadramento['id_sugestao_enquadramento']
//                ]);
//            }

            parent::message('Enquadramento armazenado com sucesso!', "/admissibilidade/admissibilidade/exibirpropostacultural?idPreProjeto={$get['id_preprojeto']}&realizar_analise=sim", 'CONFIRM');
        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/admissibilidade/enquadramento-proposta/sugerir-enquadramento?id_preprojeto={$get['id_preprojeto']}");
        }
    }
}
