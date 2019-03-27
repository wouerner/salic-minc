<?php
/**
 * Created by IntelliJ IDEA.
 * User: voltAir
 * Date: 27/03/19
 * Time: 15:12
 */

namespace Application\Modules\Assinatura\Service\Assinatura;


class UrlResolver
{

    private function definirModuloDeOrigem()
    {
        $get = Zend_Registry::get('get');
        $post = (object)$this->getRequest()->getPost();
        $this->view->origin = "{$this->moduleName}/index";
        if (!empty($get->origin) || !empty($post->origin)) {
            $this->view->origin = (!empty($post->origin)) ? $post->origin : $get->origin;
        }
        if (preg_match('/\[FRONT\]',  $this->view->origin)) {
            $url = preg_replace('/\[FRONT\]', '#', $this->view->origin)) {
                $this->redirect($url);
            }
        $this->moduloDeOrigem = $this->view->origin;
        }
    }

    public function indexAction()
    {
        $this->redirect("/{$this->moduleName}/index/gerenciar-assinaturas");
    }

    public function gerenciarAssinaturasAction()
    {
        $this->view->idUsuarioLogado = $this->auth->getIdentity()->usu_codigo;
        $this->view->dados = [];
        $this->view->codGrupo = $this->grupoAtivo->codGrupo;
    }


parent::message($objException->getMessage(), "/{$this->view->origin}/gerenciar-assinaturas");


if (count($arrayIdPronacs) > 1) {
    parent::message(
        "Projetos assinados com sucesso!",
        "/{$this->view->origin}/gerenciar-assinaturas",
        'CONFIRM'
    );
} else {
    parent::message(
        "Projeto assinado com sucesso!",
        "/{$this->moduleName}/index/visualizar-projeto?idDocumentoAssinatura={$idDocumentoAssinatura}&origin={$this->view->origin}",
        'CONFIRM'
    );
}


$urlRedirectPadrao = '"/{$this->moduleName}/index/gerenciar-assinaturas";
"/{$this->view->origin}/gerenciar-assinaturas
 "/{$this->moduleName}/index/visualizar-projeto?idDocumentoAssinatura={$idDocumentoAssinatura}&origin={$this->view->origin}",
"/{$this->moduleName}/index/assinar-projeto?IdPRONAC={$idPronac}&idTipoDoAtoAdministrativo={$idTipoDoAtoAdministrativo}&origin={$this->view->origin}",



$links['redirect'] = '''
$links['projetoAssinado'] = '''


                } catch (Exception $objException) {
                    parent::message(
                        $objException->getMessage(),
                        $service->parseLink('assinarProjeto, [$idPronac, $idTipoDoAtoAdministrativo], $origin),
                        'ERROR'
                    );

class service
{

    public function parseLink($nomeUrl, $params, $origin = false)
    {
        if ($origin) {
            if (preg_match('/FRONT/'....

            } else {

        }
    }

}




parent::message .... $links['projetoAssinado']::class;

}
