<?php 

class TbTipoEncaminhamento extends MinC_Db_Table_Abstract {
    
    protected  $_banco = 'SAC';
    protected  $_name = 'tbTipoEncaminhamento';

    const SOLICITACAO_ENCAMINHADA_AO_MINC = 1;
    const SOLICITACAO_FINALIZADA_PELO_MINC = 15;
}
?>
