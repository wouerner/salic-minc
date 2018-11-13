<?php

namespace Application\Modules\Execucao\Service\Fiscalizacao;


class Fiscalizacao implements \MinC\Servico\IServicoRestZend
{
    /**
     * @var \Zend_Controller_Request_Abstract $request
     */
    private $request;

    /**
     * @var \Zend_Controller_Response_Abstract $response
     */
    private $response;

    function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function buscarFiscalizacao()
    {
        $idPronac = $this->request->idPronac;
        $idFiscalizacao = $this->request->idFiscalizacao;

        if (strlen($idPronac) > 7) {
            $idPronac = \Seguranca::dencrypt($idPronac);
        }

        $Projetos = new \Projetos();
        $dadosProj = $Projetos->buscar(array('IdPRONAC = ?' => $idPronac))->current();


        if (empty($idFiscalizacao)) {
            $infoProjeto = $Projetos->projetosFiscalizacaoConsultar(array('Projetos.IdPRONAC = ?' => $idPronac), array('tbFiscalizacao.dtInicioFiscalizacaoProjeto ASC', 'tbFiscalizacao.dtFimFiscalizacaoProjeto ASC'));
        } else {
            $infoProjeto = $Projetos->projetosFiscalizacaoConsultar(array('Projetos.IdPRONAC = ?' => $idPronac, 'tbFiscalizacao.idFiscalizacao = ?' => $idFiscalizacao), array('tbFiscalizacao.dtInicioFiscalizacaoProjeto ASC', 'tbFiscalizacao.dtFimFiscalizacaoProjeto ASC'));

            $OrgaoFiscalizadorDao = new \OrgaoFiscalizador();
            if ($idFiscalizacao) {
                $dadosOrgaos = $OrgaoFiscalizadorDao->dadosOrgaos(array('tbOF.idFiscalizacao = ?' => $idFiscalizacao));
            }
            $ArquivoFiscalizacaoDao = new \ArquivoFiscalizacao();
            if ($idFiscalizacao) {
                $arquivos = $ArquivoFiscalizacaoDao->buscarArquivo(array('arqfis.idFiscalizacao = ?' => $idFiscalizacao));
            }
            $RelatorioFiscalizacaoDAO = new \RelatorioFiscalizacao();
            $relatorioFiscalizacao = $RelatorioFiscalizacaoDAO->buscaRelatorioFiscalizacao($idFiscalizacao);

        }
        xd($infoProjeto);
        return;
    }
}
