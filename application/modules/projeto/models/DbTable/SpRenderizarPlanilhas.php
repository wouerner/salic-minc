<?php

class Projeto_Model_DbTable_SpRenderizarPlanilhas extends MinC_Db_Table_Abstract
{
    protected $_schema = 'SAC';
    protected $_name = 'spRenderizarPlanilhas';

    public function exec($idPronac, $tipoPlanilha)
    {
        $sql = "exec {$this->_schema}.{$this->_name} {$idPronac}, {$tipoPlanilha}";

        return $this->getAdapter()->fetchAll($sql);
    }

    public function obterPlanilhaPorTipo($idPronac, $tipoPlanilha)
    {

        if (empty($idPronac) || empty($tipoPlanilha)) {
            throw new Exception("Pronac e tipo são obrigatórios");
        }

        $planilha = $this->exec($idPronac, $tipoPlanilha);

        if (empty($planilha)) {
            return false;
        }

        $planilha = $this->montarPlanilha($planilha, $tipoPlanilha);
        $planilha = TratarArray::utf8EncodeArrayTemp($planilha);

        return $planilha;
    }


    public function montarPlanilha($planilhaOrcamentaria, $tipo)
    {

        if (!is_array($planilhaOrcamentaria)) {
            return [];
        }

        $count = 0;
        $i = 1;

        $planilha = [];

        foreach ($planilhaOrcamentaria as $item) {
            $row = [];

                $row["Seq"] = $i;
                $row['FonteRecurso'] = $item["FonteRecurso"];
                $produto = !empty($item['Produto']) ? $item['Produto'] : html_entity_decode('Administra&ccedil;&atilde;o do Projeto');
                $row['Etapa'] = $item["Etapa"];
                $row['UF'] = $item["UF"];
                $row['Municipio'] = $item["Municipio"];
                $row['Item'] = $item["Item"];
                $row['vlSolicitado'] = $item["vlSolicitado"];
                $row['JustProponente'] = $item["JustProponente"];
                $row['vlSugerido'] = $item["vlSugerido"];
                $row['JustParecerista'] = $item["JustParecerista"];
                $row['QtdeDias'] = $item["QtdeDias"];
                $row['Unidade'] = $item["Unidade"];
                $row['Quantidade'] = $item["Quantidade"];
                $row['Ocorrencia'] = $item["Ocorrencia"];
                $row['vlUnitario'] = $item["vlUnitario"];
                $row['vlAprovado'] = $item["vlAprovado"];
                $row['VlComprovado'] = $item["VlComprovado"];   # @todo padronizar o nome
                $row['JustComponente'] = $item["JustComponente"];
                $row['tpPlanilha'] = $item["tpPlanilha"];
                $row['stCustoPraticado'] = $item["stCustoPraticado"];
                $row['idPlanilhaAprovacao'] = $item["idPlanilhaAprovacao"];
                $row['idPlanilhaAprovacaoPai'] = $item["idPlanilhaAprovacaoPai"];

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
