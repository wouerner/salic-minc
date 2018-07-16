<?php

class Projeto_Model_DbTable_SpRenderizarPlanilhas extends MinC_Db_Table_Abstract
{
    protected $_schema = 'SAC';
    protected $_name  = 'spRenderizarPlanilhas';

    public function exec($idPronac, $tipoPlanilha)
    {
        $sql = "exec {$this->_schema}.{$this->_name} {$idPronac}, {$tipoPlanilha}";

        return $this->getAdapter()->fetchAll($sql);
    }

    public function obterPlanilhaPorTipo($idPronac, $tipo)
    {

        if (empty($idPronac) || empty($tipo)) {
            throw new Exception("Pronac e tipo são obrigatórios");
        }

        $planilha = $this->exec($idPronac, $tipo);

        if (empty($planilha)) {
            return false;
        }

        $planilha = TratarArray::utf8EncodeArrayTemp($planilha);
        $planilha = $this->montarPlanilhaProposta($planilha);

        return $planilha;
    }



    public function montarPlanilha($planilha, $tipo)
    {
        $planilha = array();
        $count = 0;
        $i = 1;

        foreach ($planilha as $item) {
            $row = [];

            $produto = !empty($item['idProduto']) ? $item['DescricaoProduto'] : html_entity_decode('Administra&ccedil;&atilde;o do Projeto');

            $row["Seq"] = $i;
            $row["idPlanilhaProposta"] = $item['idPlanilhaProposta'];
            $row["Item"] = $item['DescricaoItem'];
            $row['FonteRecurso'] = $item['DescricaoRecurso'];
            $row['Municipio'] = $item['DescricaoMunicipio'];
            $row['UF'] = $item['DescricaoUf'];
            $row['idEtapa'] = $item['idEtapa'];
            $row['Etapa'] = $item['DescricaoEtapa'];
            $row['Ocorrencia'] = $item['Ocorrencia'];
            $row['Quantidade'] = $item['Quantidade'];
            $row['QtdeDias'] = $item['QtdeDias'];
            $row['vlUnitario'] = $item['ValorUnitario'];
            $row["vlSolicitado"] = $item['Quantidade'] * $item['Ocorrencia'] * $item['ValorUnitario'];
            $row['JustProponente'] = $item['dsJustificativa'];
            $row['stCustoPraticado'] = $item['stCustoPraticado'];

            foreach ($row as $cel => $val) {
                $planilha[$row['FonteRecurso']][$produto][$row['Etapa']][$row['UF'] . ' - '
                . $row['Municipio']][$count][$cel] = $val;
            }
            $count++;
            $i++;
        }

        return $planilha;
    }



}
