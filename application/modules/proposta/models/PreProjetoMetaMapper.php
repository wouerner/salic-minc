<?php
class Proposta_Model_PreProjetoMetaMapper extends MinC_Db_Mapper
{
    public function __construct()
    {
        parent::setDbTable('Proposta_Model_DbTable_PreProjetoMeta');
    }

    public function save($model)
    {
        return parent::save($model);
    }

    public function serializarObjeto($object, $where)
    {
        $result = $object->findAll($where);

        if (!$result) {
            return false;
        }

        return serialize($result);
    }

    public function unserializarObjeto($object, $idPreProjeto, $metakey = null)
    {
        if (empty($idPreProjeto)) {
            return false;
        }

        # se não passar o metakey, tenta recuperar a tabela do objeto
        if (empty($metakey)) {
            $metakey = str_replace('dbo.', '', $object->getTableName());
        }

        $PPM = new Proposta_Model_DbTable_PreProjetoMeta();
        $result = $PPM->buscarMeta($idPreProjeto, $metakey);

        return unserialize($result);
    }

    public function salvarObjetoSerializado($object, $idPreProjeto, $metakey = null, $where = null)
    {
        if (empty($where)) {
            $where = array('idProjeto' => $idPreProjeto);
        }

        $serializado = $this->serializarObjeto($object, $where);

        # se não passar o metakey, salva o nome da tabela do objeto
        if (empty($metakey)) {
            $metakey = str_replace('dbo.', '', $object->getTableName());
        }

        $PPM = new Proposta_Model_DbTable_PreProjetoMeta();
        return $PPM->salvarMeta($idPreProjeto, $metakey, $serializado);
    }

    public function salvarArraySerializado($array, $idPreProjeto, $metakey)
    {
        if (empty($metakey)) {
            return false;
        }

        $serializado = serialize($array);

        $PPM = new Proposta_Model_DbTable_PreProjetoMeta();
        return $PPM->salvarMeta($idPreProjeto, $metakey, $serializado);
    }
}