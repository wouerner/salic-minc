<?php

namespace Application\Modules\Navegacao\Service\Perfil;

class Perfil
{
    private $request;
    private $response;

    function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function buscarVersao()
    {
        $vcs = $this->getVcs();
        if ($vcs) {
            $functionName = "get" . ucfirst($vcs) . "FullVersion";
            if (is_callable(array($this, $functionName))) {
                return $this->$functionName();
            }
        }
    }


    private function getVcs() {
        $folders = array('.git', '.svn');
        foreach ($folders as $vcs) {
            if (is_dir(realpath(constant('APPLICATION_PATH') . "/../{$vcs}"))) {
                return substr($vcs, 1);
            }
        }
    }
}
