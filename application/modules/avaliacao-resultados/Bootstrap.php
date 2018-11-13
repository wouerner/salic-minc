<?php
class AvaliacaoResultados_Bootstrap extends Zend_Application_Module_Bootstrap
{
    public function _initREST()
    {
        $frontController = Zend_Controller_Front::getInstance();

        $restRoute = new Zend_Rest_Route(
            $frontController,
            [],
            [
                'avaliacao-resultados' => [
                    'index',
                    'assinatura',
                    'avaliacao-comprovante',
                    'diligencia',
                    'emissao-parecer-rest',
                    'encaminhamento-prestacao-contas',
                    'estado',
                    'fluxo',
                    'historico',
                    'laudo',
                    'tecnicos',
                    'tipo-avaliacao-rest',
                    'projeto',
                    'projeto-assinatura',
                    'projeto-inicio',
                    'planilha-aprovada',
                    'projetos-avaliacao-tecnica',
                    'fluxo-projeto',
                ]
            ]
        );

        $frontController->getRouter()->addRoute('rest-avaliacao-resultados', $restRoute);
    }
}
