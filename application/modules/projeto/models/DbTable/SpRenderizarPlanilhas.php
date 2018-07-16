<?php

class Projeto_Model_DbTable_SpRenderizarPlanilhas extends MinC_Db_Table_Abstract
{
    protected $_schema = 'SAC';
    protected $_name = 'spRenderizarPlanilhas';

    const TIPO_PLANILHA_READEQUADA = 'RE';
    const TIPO_PLANILHA_HOMOLOGADA = 'AP';

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

    /**
     * @todo: melhorar esse codigo quando tiver tempo...
     */
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
            $row['JustProponente'] = $item["JustProponente"];
            $row['QtdeDias'] = $item["QtdeDias"];
            $row['Unidade'] = $item["Unidade"];
            $row['Quantidade'] = $item["Quantidade"];
            $row['Ocorrencia'] = $item["Ocorrencia"];
            $row['vlUnitario'] = $item["vlUnitario"];
            $row['idPlanilhaAprovacao'] = $item["idPlanilhaAprovacao"];
            $row['idPlanilhaAprovacaoPai'] = $item["idPlanilhaAprovacaoPai"];
            $row['vlAprovado'] = $item["vlAprovado"];
            $row['VlComprovado'] = $item["VlComprovado"];   # @todo padronizar o nome
            $row['tpPlanilha'] = $item["tpPlanilha"];

            if ($tipo == $this::TIPO_PLANILHA_HOMOLOGADA) {
                $row['vlSolicitado'] = $item["vlSolicitado"];
                $row['vlSugerido'] = $item["vlSugerido"];
                $row['JustParecerista'] = $item["JustParecerista"];
                $row['JustComponente'] = $item["JustComponente"];
                $row['stCustoPraticado'] = $item["stCustoPraticado"];
                $row['idPlanilhaAprovacao'] = $item["idPlanilhaAprovacao"];
                $row['idPlanilhaAprovacaoPai'] = $item["idPlanilhaAprovacaoPai"];
            }

            if ($tipo == $this::TIPO_PLANILHA_READEQUADA) {
                $row['tpAcao'] = $item["tpAcao"];
                $row['DescAcao'] = $this->obterNomeAcao($item["tpAcao"]);
                $row['JustProponente'] = $item["dsJustificativa"]; # @todo padronizar o nome
                $row['vlSolicitado'] = $item["vlAprovado"]; # o componente monta o valor total com vlSolicitado
            }

            foreach ($row as $cel => $val) {
                $planilha[$row['FonteRecurso']][$produto][$row['Etapa']][$row['UF'] . ' - '
                . $row['Municipio']][$count][$cel] = $val;
            }
            $count++;
            $i++;
        }

        return $planilha;
    }

    public function obterNomeAcao($tipoAcao)
    {
        switch ($tipoAcao) {
            case 'I':
                return 'Inclu&iacute;do';
                break;
            case 'E':
                return 'Exclu&iacute;do';
                break;
            case 'A':
                return 'Alterado';
                break;
            default:
                return '';
        }
    }


}
