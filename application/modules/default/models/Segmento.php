<?php
class Segmento extends MinC_Db_Table_Abstract
{
    protected $_schema = 'sac';
    protected $_name = 'Segmento';
    const SEGMENTOS_ARTIGO_18 =  [
        '11','12','13','14','15','17','23','26','2A','2B','2E','2F','2G','2H',
        '2I','2J','2K','2L','32','33','36','4B','4D','5A','5D','5E','5F','5G',
        '5H','5I','5J','5K','5L','5M','5N','5O','5P','62','65','68','6C','6D',
        '6E','6G','6H'
    ];

    public function buscaCompleta($where=array(), $order=array(), $tamanho=-1, $inicio=-1, $count=false)
    {
        $slct = $this->select();
        $slct->setIntegrityCheck(false);
        $slct->from(
            array('s'=>$this->_name),
                    array('id'=>'Codigo', 'descricao'=>'Descricao')
        );

        $slct->joinInner(
            array('a'=>'Area'),
            'LEFT(s.Codigo, 1) = a.Codigo',
                            array(),
            'SAC.dbo'
        );

        //adiciona quantos filtros foram enviados
        foreach ($where as $coluna => $valor) {
            $slct->where($coluna, $valor);
        }

        //adicionando linha order ao select
        $slct->order($order);

        // paginacao
        if ($tamanho > -1) {
            $tmpInicio = 0;
            if ($inicio > -1) {
                $tmpInicio = $inicio;
            }
            $slct->limit($tamanho, $tmpInicio);
        }


        return $this->fetchAll($slct);
    }


    /**
     * Busca os segmentos para as combos
     *
     * @name combo
     * @access public
     * @param array $where (filtros)
     * @param array $order (ordenacao)
     * @return object
     *
     * @author Ruy Junior Ferreira Silva <ruyjfs@gmail.com>
     * @since  17/08/2016
     */
    public function combo($where = array(), $order = array())
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);

        $select->from(
            array('s' => 'vSegmento'),
            array('s.codigo AS id', 's.segmento AS descricao', 'tp_enquadramento'),
            $this->_schema
        );

        $select->joinInner(
            array('a' => 'area'),
            's.area = a.codigo',
            array(),
            $this->_schema
        );

        // adiciona quantos filtros foram enviados
        foreach ($where as $coluna => $valor) :
            $select->where($coluna, $valor);
        endforeach;

        // adicionando linha order ao select
        $select->order($order);
        //echo $select;die;

        return $this->fetchAll($select);
    }

    public function buscaSegmentos()
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        return $this->fetchAll($select);
    }
}
