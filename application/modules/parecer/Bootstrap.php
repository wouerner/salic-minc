<?php
class Parecer_Bootstrap extends Zend_Application_Module_Bootstrap
{
    public function _initPath()
    {
        require_once APPLICATION_PATH . '/modules/parecer/controllers/GenericController.php';
    }
}
