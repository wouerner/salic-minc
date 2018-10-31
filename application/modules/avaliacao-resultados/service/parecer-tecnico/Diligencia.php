<?php

namespace Application\Modules\AvaliacaoResultados\Service\ParecerTecnico;


class Diligencia
{

            public function listaDiligenciaPainel () {
                $Projetosdao = new Projetos();
                $PreProjetodao = new Proposta_Model_DbTable_PreProjeto();

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
             $this->view->diligenciasProposta = $dao->listarDiligenciasPreProjeto(array('pre.idPreProjeto = ?' => $this->idPreProjeto, 'aval.ConformidadeOK = ? ' => 0));
            }
        }
    };

}
