<?php

/**
 * spPlanilhaOrcamentaria
 *
 * @uses GenericModel
 * @author
 */
class spPlanilhaOrcamentaria extends MinC_Db_Table_Abstract {

    protected $_schema = 'sac';
    protected $_name  = 'spPlanilhaOrcamentaria';

    public function exec($idPronac, $tipoPlanilha)
    {
        // tipoPlanilha = 0 : Planilha Orcamentaria da Proposta
        // tipoPlanilha = 1 : Planilha Orcamentaria do Proponente
        // tipoPlanilha = 2 : Planilha Orcamentaria do Parecerista
        // tipoPlanilha = 3 : Planilha Orcamentaria Aprovada Ativa
        // tipoPlanilha = 4 : Cortes Orcamentarios Aprovados
        // tipoPlanilha = 5 : Remanejamento menor que 20%
        // tipoPlanilha = 6 : Readequacao

        $fnVerificarProjetoAprovadoIN2017 = new fnVerificarProjetoAprovadoIN2017();
        $projetoIN2017 = $fnVerificarProjetoAprovadoIN2017->verificar($idPronac);

        if ($tipoPlanilha == 3 && $projetoIN2017) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->setFetchMode(Zend_DB::FETCH_OBJ);

            $sql = $db->select()
                ->from('tbPlanilhaAprovacao',
                    array(new Zend_Db_Expr("TOP 1 IdPRONAC")),
                    $this->_schema)
                ->where('tpPlanilha = ? ', 'CO')
                ->where('IdPRONAC = ? ', $idPronac);

            if ($db->fetchRow($sql)) {
                $tipoPlanilha = 0;
            }
        }

        switch ($tipoPlanilha) {
            case 0:
                return $this->planilhaOrcamentariaProposta($idPronac);
                break;
            case 1:
                return $this->orcamentariaProponente($idPronac);
                break;
            case 2:
                return $this->orcamentariaParecerista($idPronac);
                break;
            case 3:
            case 4:
            case 5:
            case 6:
            default:
                $spVisualizarPlanilha = new Projeto_Model_spVisualizarPlanilhaOrcamentaria();
                return $spVisualizarPlanilha->exec($idPronac); // @todo: atualmente o codigo migrado apresenta algumas divergencias, usar a sp agora e migrar assim que possivel
                break;
// @todo: nao apagar, migrar a sp VisualizarPlanilha  para o codigo, atualizando os metodos abaixo
//            case 3:
//                return $this->orcamentariaAprovadaAtiva($idPronac);
//                break;
//            case 4:
//                return $this->cortesOrcamentariosAprovados($idPronac);
//                break;
//            case 5:
//                return $this->remanejamentoMenor20($idPronac);
//                break;
//            case 6:
//                return $this->readequacao($idPronac);
//                break;
        }
    }

    /**
     * planilhaOrcamentariaProposta
     *
     * @param mixed $idPronac
     * @access public
     * @return void
     * @author wouerner <wouerner@gmail.com>
     */
    public function planilhaOrcamentariaProposta($idPronac)
    {
        $a = array(
            'a.idpreprojeto as idPronac',
            new Zend_Db_Expr("' ' AS PRONAC"),
            'a.nomeprojeto',
            new Zend_Db_Expr(" CASE WHEN idproduto = 0
                       THEN 'Administra&ccedil;&atilde;o do Projeto'
                       ELSE c.descricao
                  END as Produto"),
        );

        $b = array(
            'b.idproduto',
            'b.idplanilhaproposta',
            'b.idetapa',
            'b.quantidade as Quantidade',
            'b.ocorrencia as Ocorrencia',
            'b.valorunitario as vlUnitario',
            'ROUND((b.quantidade * b.ocorrencia * b.valorunitario),2) as vlSolicitado',
            'b.fonterecurso as idFonte',
            'b.qtdedias as QtdeDias',
            'b.stCustoPraticado as stCustoPraticado',
            new Zend_Db_Expr(MinC_Db_Expr::convertOrToChar('b.dsjustificativa').' as JustProponente'),
        );

        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB::FETCH_OBJ);

        $sac = $this->getSchema('sac');
        $concat = MinC_Db_Expr::concat();
        $convert = MinC_Db_Expr::convertOrToChar('d.idplanilhaetapa');

        $sql = $db->select()
            ->from(array('a' => 'preprojeto'), $a, $sac)
            ->joinInner(array('b' => 'tbplanilhaproposta'), '(a.idpreProjeto = b.idprojeto)', $b, $sac)
            ->joinLeft(array('c' => 'produto'), '(b.idproduto = c.codigo)', null, $sac)
            ->joinInner(array('d' => 'tbplanilhaetapa'), '(b.idetapa = d.idplanilhaetapa)', 'd.descricao as Etapa', $sac)
            ->joinInner(array('e' => 'tbplanilhaunidade'), '(b.unidade = e.idunidade)', 'e.descricao as Unidade', $sac)
            ->joinInner(array('i' => 'tbplanilhaitens'), '(b.idplanilhaitem=i.idplanilhaitens)', 'i.descricao as Item', $sac)
            ->joinInner(array('x' => 'verificacao'), '(b.fonterecurso = x.idverificacao)', 'x.descricao as FonteRecurso', $sac)
            ->joinLeft(array('f' => 'municipios'), '(b.municipiodespesa = f.idmunicipioibge)',array('u.sigla as UF'),$this->getSchema('agentes'))
            ->joinLeft(array('u' => 'uf'), '(f.idufibge = u.iduf and b.ufdespesa = u.iduf)',array('f.descricao as Municipio'),$this->getSchema('agentes'))
            ->where('a.idpreprojeto = ? ', $idPronac)
            ->order("x.descricao")
            ->order("c.descricao DESC")
            ->order("$convert  $concat '-'  $concat d.descricao")
            ->order('u.sigla')
            ->order('f.descricao')
            ->order('i.descricao');

        return $db->fetchAll($sql);
    }

    /**
     * orcamentariaProponente
     *
     * @param mixed $idPronac
     * @access public
     * @return void
     */
    public function orcamentariaProponente($idPronac)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB::FETCH_OBJ);
        
        $a =array(
            'a.idPronac',
            'a.AnoProjeto',
            'a.Sequencial AS PRONAC',
            'a.NomeProjeto',
            new Zend_Db_Expr('QtdeDias')
        );

        $b =array(
            'b.idProduto',
            'b.idPlanilhaProposta',
            new Zend_Db_Expr("
                CASE
                  WHEN idProduto = 0
                       THEN 'Administra&ccedil;&atilde;o do Projeto'
                       ELSE c.Descricao
                  END as Produto
            "),
            'b.idEtapa',
            'b.Quantidade',
            'b.Ocorrencia',
            'b.ValorUnitario as vlUnitario',
            "b.FonteRecurso as idFonte",
            new Zend_Db_Expr("ROUND((b.Quantidade * b.Ocorrencia * b.ValorUnitario),2) as vlSolicitado"),
            new Zend_Db_Expr("convert(varchar(max),b.dsJustificativa) as JustProponente")
        );

        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB::FETCH_OBJ);

        $sac = 'sac.dbo';
        $concat = MinC_Db_Expr::concat();

        $sql = $db->select()
            ->from(array('a' => 'projetos'), $a, $sac)
            ->joinInner(array('b' => 'tbplanilhaproposta'), 'a.idProjeto = b.idProjeto', $b, $sac)
            ->joinLeft(array('c' => 'produto'), '(b.idproduto = c.codigo)', null, $sac)
            ->JoinInner(array('d' => 'tbplanilhaetapa '), '(b.idetapa = d.idplanilhaetapa)', 'd.Descricao as Etapa', $sac)
            ->joinInner(array('e' => 'tbplanilhaunidade'), '(b.unidade = e.idunidade)', 'e.descricao as Unidade', $sac)
            ->joinInner(array('i' => 'tbplanilhaitens '), '(b.idplanilhaitem=i.idplanilhaitens)', 'i.descricao as Item', $sac)
            ->joinInner(array('x' => 'verificacao'), '(b.fonterecurso = x.idverificacao)', 'x.descricao as FonteRecurso', $sac)
            ->joinInner(array('f' => 'vufmunicipio '), '(b.ufdespesa = f.iduf and b.municipiodespesa = f.idmunicipio)', array('f.uf as UF','f.municipio as  Municipio'), 'agentes.dbo')
            ->where('a.idpronac = ? ', $idPronac)
            ->order("x.Descricao")
            ->order("c.Descricao DESC")
            ->order("CONVERT(VARCHAR(8),d.idPlanilhaEtapa) $concat ' - '$concat  d.Descricao")
            ->order('f.UF')
            ->order('f.Municipio')
            ->order('i.Descricao');

        return $db->fetchAll($sql);
    }

    /**
     * orcamentariaParecerista
     *
     * @param mixed $idPronac
     * @access public
     * @return void
     */
    public function orcamentariaParecerista($idPronac)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB::FETCH_OBJ);

        $concat = MinC_Db_Expr::concat();

        $a = array(
            'a.idPronac',
            new Zend_Db_Expr("a.AnoProjeto $concat a.Sequencial as PRONAC"),
            'a.NomeProjeto',
        );

        $b = array(
            'b.idProduto',
            'b.idPlanilhaProjeto',
            new Zend_Db_Expr("
                     CASE
                       WHEN b.idProduto = 0
                            THEN 'Administra&ccedil;&atilde;o do Projeto'
                            ELSE c.Descricao
                       END as Produto
                 "),
            'b.idEtapa',
            'b.idPlanilhaItem',
            'b.UfDespesa as idUF',
            'b.MunicipioDespesa as idMunicipio',
            'b.Quantidade as Quantidade',
            'b.Ocorrencia as Ocorrencia',
            'b.ValorUnitario as vlUnitario',
            'b.QtdeDias as QtdeDias',
            'b.FonteRecurso as idFonte',
            'b.idUsuario',
            new Zend_Db_Expr('convert(varchar(max),b.Justificativa) as JustParecerista'),
            new Zend_Db_Expr('round((b.quantidade * b.ocorrencia * b.valorunitario),2) as vlSugerido')
        );

        $z = array(
            new Zend_Db_Expr(' round((z.quantidade * z.ocorrencia * z.valorunitario),2) as vlSolicitado'),
            new Zend_Db_Expr('convert(varchar(max),z.dsjustificativa) as JustProponente')
        );

        $f = array('f.uf as UF', 'f.municipio as Municipio');

        $sac = 'sac.dbo';

        $sql = $db->select()
            ->from(array('a' => 'projetos'), $a, $sac)
            ->joinInner(array('b' => 'tbplanilhaprojeto'), '(a.idpronac = b.idpronac)', $b, $sac)
            ->joinInner(array('z' => 'tbplanilhaproposta'), '(b.idplanilhaproposta=z.idplanilhaproposta)', $z, $sac)
            ->joinLeft(array('c' => 'produto'), '(b.idproduto = c.codigo)', null, $sac)
            ->joinInner(array('d' => 'tbPlanilhaEtapa'), '(b.idEtapa = d.idPlanilhaEtapa)', 'd.Descricao as Etapa', $sac)
            ->joinInner(array('e' => 'tbplanilhaunidade'), '(b.idunidade = e.idunidade)', 'e.descricao as Unidade', $sac)
            ->joinInner(array('i' => 'tbplanilhaitens'), '(b.idplanilhaitem=i.idplanilhaitens)', 'i.descricao as Item', $sac)
            ->joinInner(array('x' => 'verificacao'), '(b.fonterecurso = x.idverificacao)', 'x.descricao as FonteRecurso', $sac)
            ->joinInner(array('f' => 'vufmunicipio'), '(b.ufdespesa = f.iduf and b.municipiodespesa = f.idmunicipio)', $f, $this->getSchema('agentes'))
            ->where('a.idPronac = ?', $idPronac)
            ->order('x.Descricao')
            ->order('c.Descricao DESC')
            ->order("CONVERT(VARCHAR(8),d.idPlanilhaEtapa) $concat ' - ' $concat d.Descricao")
            ->order('f.uf')
            ->order('f.Municipio')
            ->order('i.Descricao');
//        xd($db->fetchAll($sql)); die;

        return $db->fetchAll($sql);
    }

    /**
     * orcamentariaAprovadaAtiva
     *
     * @param mixed $idPronac
     * @access public
     * @return void
     */
    public function orcamentariaAprovadaAtiva($idPronac)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB::FETCH_OBJ);

        $subA = array(
            'sum(b1.vlComprovacao) AS vlPagamento',
        );

        $subSQLA = $db->select()
            ->from(array('a1' => 'tbComprovantePagamentoxPlanilhaAprovacao'), $subA, 'BDCORPORATIVO.scSAC')
            ->join(array('b1' => 'tbComprovantePagamento'), '(a1.idComprovantePagamento = b1.idComprovantePagamento)', null, 'BDCORPORATIVO.scSAC')
            ->join(array('c1' => 'tbPlanilhaAprovacao'), '(a1.idPlanilhaAprovacao = c1.idPlanilhaAprovacao)', null, $this->_schema)
            ->where("c1.stAtivo = 'S'")
            ->where("c1.idPlanilhaAprovacao = k.idPlanilhaAprovacao")
            ->where("(c1.idPronac = k.idPronac)")
            ->group("a1.idPlanilhaAprovacao")
        ;

        $subB = array(
            'sum(b1.vlComprovacao) AS vlPagamento',
        );

        $subSQLB = $db->select()
            ->from(array('a1' =>'tbComprovantePagamentoxPlanilhaAprovacao'), $subB, 'BDCORPORATIVO.scSAC')
            ->join(array('b1' => 'tbComprovantePagamento'), '(a1.idComprovantePagamento = b1.idComprovantePagamento)', null, 'BDCORPORATIVO.scSAC')
            ->join(array('c1' => 'tbPlanilhaAprovacao'), '(a1.idPlanilhaAprovacao = c1.idPlanilhaAprovacaoPai)', null, $this->_schema)
            ->where("c1.stAtivo = 'S'")
            ->where("c1.idPlanilhaAprovacaoPai = k.idPlanilhaAprovacaoPai")
            ->where("(c1.idPronac = k.idPronac)")
            ->group("a1.idPlanilhaAprovacao")
        ;

//echo $subSQLB;die;

        $a = array(
            new Zend_Db_Expr("
                CASE
                    WHEN k.tpPlanilha = 'CO' THEN
                    ($subSQLA)
                   ELSE
                    ($subSQLB)
            END as vlComprovado"),
        new Zend_Db_Expr("CASE WHEN k.idProduto = 0 THEN 'Administra&ccedil;&atilde;o do Projeto' ELSE c.Descricao END as Produto"),
        'CONVERT(varchar(max), k.dsJustificativa) as JustComponente',
        'ROUND((b.Quantidade * b.Ocorrencia * b.ValorUnitario),2) as vlSugerido',
        'ROUND((k.QtItem * k.nrOcorrencia * k.VlUnitario),2) as vlAprovado',
        'ROUND((z.Quantidade * z.Ocorrencia * z.ValorUnitario),2) as vlSolicitado',
        new Zend_Db_Expr('a.AnoProjeto+a.Sequencial as PRONAC'),
        'a.NomeProjeto',
        'a.idPronac',
        'b.idEtapa',
        'convert(varchar(max),b.Justificativa) as JustParecerista',
        'convert(varchar(max),z.dsJustificativa) as JustProponente',
        'd.Descricao as Etapa',
        'e.Descricao as Unidade',
        'f.Municipio',
        'f.UF',
        'i.Descricao as Item',
        'k.QtDias as QtdeDias',
        'k.QtItem as Quantidade',
        'k.TpDespesa',
        'k.TpPessoa',
        'k.idMunicipioDespesa as idMunicipio',
        'k.idPlanilhaAprovacao',
        'k.idPlanilhaItem',
        'k.idProduto',
        'k.idUfDespesa as idUF',
        'k.nrContrapartida',
        'k.nrFonteRecurso as idFonte',
        'k.nrOcorrencia as Ocorrencia',
        'k.tpPlanilha',
        'k.vlUnitario',
        'x.Descricao as FonteRecurso',
        );

        $sql = $db->select()
            ->from(array('a' => 'Projetos'), $a, $this->_schema)
            ->join(array('b' => 'tbPlanilhaProjeto'), '(a.idPronac = b.idPronac)', null, $this->_schema)
            ->join(array('z' => 'tbPlanilhaProposta'), '(b.idPlanilhaProposta=z.idPlanilhaProposta)', null, $this->_schema)
            ->join(array('k' => 'tbPlanilhaAprovacao'), '(b.idPlanilhaProposta=k.idPlanilhaProposta)', null, $this->_schema)
            ->joinLeft(array('c' => 'Produto'), '(b.idProduto = c.Codigo)', null, $this->_schema)
            ->join(array('d' => 'tbPlanilhaEtapa'), '(k.idEtapa = d.idPlanilhaEtapa)', null, $this->_schema)
            ->join(array('e' => 'tbPlanilhaUnidade'), '(b.idUnidade = e.idUnidade)', null, $this->_schema)
            ->join(array('i' => 'tbPlanilhaItens'), '(b.idPlanilhaItem=i.idPlanilhaItens)', null, $this->_schema)
            ->join(array('x' => 'Verificacao'), '(b.FonteRecurso = x.idVerificacao)', null, $this->_schema)
            ->join(array('f' => 'vUfMunicipio'), '(b.UfDespesa = f.idUF and b.MunicipioDespesa = f.idMunicipio)', null, 'agentes.dbo')
            ->where("k.stAtivo = 'S'")
            ->where("a.idPronac = ?", $idPronac)
            ->order("x.Descricao")
            ->order("c.Descricao DESC")
            ->order("CONVERT(VARCHAR(8),d.idPlanilhaEtapa) + ' - ' + d.Descricao")
            ->order("f.UF")
            ->order("f.Municipio")
            ->order("i.Descricao")
            ;

        return $db->fetchAll($sql);
    }

    /**
     * cortesOrcamentariosAprovados
     *
     * @param mixed $idPronac
     * @access public
     * @return void
     */
    public function cortesOrcamentariosAprovados($idPronac)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB::FETCH_OBJ);

        $a = array(
            new Zend_Db_Expr("CASE WHEN k.idProduto = 0 THEN 'Administra&ccedil;&atilde;o do Projeto' ELSE c.Descricao END as Produto"),
            'ROUND((b.Quantidade * b.Ocorrencia * b.ValorUnitario),2) as vlSugerido',
            'ROUND((k.QtItem * k.nrOcorrencia * k.VlUnitario),2) as vlAprovado',
            'ROUND((z.Quantidade * z.Ocorrencia * z.ValorUnitario),2) as vlSolicitado',
            new Zend_Db_Expr('a.AnoProjeto+a.Sequencial as PRONAC'),
            'a.NomeProjeto',
            'a.idPronac',
            'b.idEtapa',
            'b.idPlanilhaProjeto',
            'convert(varchar(max),k.dsJustificativa) as JustComponente',
            'convert(varchar(max),b.Justificativa) as JustParecerista',
            'convert(varchar(max),z.dsJustificativa) as JustProponente',
            'd.Descricao as Etapa',
            'e.Descricao as Unidade',
            'f.Municipio',
            'f.UF',
            'i.Descricao as Item',
            'k.QtDias as QtdeDias',
            'k.QtItem as Quantidade',
            'k.TpDespesa',
            'k.TpPessoa',
            'k.idPlanilhaAprovacao',
            'k.idProduto',
            'k.nrContrapartida',
            'k.nrFonteRecurso as idFonte',
            'k.nrOcorrencia as Ocorrencia',
            'k.vlUnitario',
            'x.Descricao as FonteRecurso',
        );

        $sql = $db->select()->from(array('a' => 'Projetos'), $a, $this->_schema)
            ->join(array('b' => 'tbPlanilhaProjeto'), '(a.idPronac = b.idPronac)', null, $this->_schema)
            ->join(array('z' => 'tbPlanilhaProposta'), '(b.idPlanilhaProposta=z.idPlanilhaProposta)', null, $this->_schema)
            ->join(array('k' => 'tbPlanilhaAprovacao'), '(b.idPlanilhaProposta=k.idPlanilhaProposta)', null, $this->_schema)
            ->joinLeft(array('c' => 'Produto'), '(b.idProduto = c.Codigo)', null, $this->_schema)
            ->join(array('d' => 'tbPlanilhaEtapa'), '(k.idEtapa = d.idPlanilhaEtapa)', null, $this->_schema)
            ->join(array('e' => 'tbPlanilhaUnidade'), '(b.idUnidade = e.idUnidade)', null, $this->_schema)
            ->join(array('i' => 'tbPlanilhaItens'), '(b.idPlanilhaItem=i.idPlanilhaItens)', null, $this->_schema)
            ->join(array('x' => 'Verificacao'), '(b.FonteRecurso = x.idVerificacao)', null, $this->_schema)
            ->join(array('f' => 'vUfMunicipio'), '(b.UfDespesa = f.idUF and b.MunicipioDespesa = f.idMunicipio)', null, 'agentes.dbo')
            ->where("a.idPronac = ?", $idPronac)
            ->where("k.stAtivo = 'S'")
            ->where("
                (ROUND((z.Quantidade * z.Ocorrencia * z.ValorUnitario),2) <> ROUND((b.Quantidade * b.Ocorrencia * b.ValorUnitario),2) OR
                     ROUND((z.Quantidade * z.Ocorrencia * z.ValorUnitario),2) <> ROUND((k.QtItem * k.nrOcorrencia * k.vlUnitario),2))
            ")
            ->order("x.Descricao")
            ->order('c.Descricao DESC')
            ->order("CONVERT(VARCHAR(8), d.idPlanilhaEtapa) + ' - ' + d.Descricao")
            ->order("f.UF")
            ->order("f.Municipio")
            ->order("i.Descricao")
        ;
        return $db->fetchAll($sql);
    }

    /**
     * remanejamentoMenor20
     *
     * @param mixed $idPronac
     * @access public
     * @return void
     */
    public function remanejamentoMenor20($idPronac)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB::FETCH_OBJ);

        $sql = $db->select()->from(array('tbPlanilhaAprovacao'), '*', $this->_schema)
            ->where('idPronac = ?', $idPronac)
            ->where("stAtivo = 'S'")
            ->where("tpPlanilha = 'RP'")
            ->limit(1)
            ;
        $planilha = $db->fetchAll($sql);

        if (empty($planilha)) {
            $subA = array(
                "sum(b1.vlComprovacao) AS vlPagamento",
            );

            $subSql = $db->select()->from(array('a1' => 'tbComprovantePagamentoxPlanilhaAprovacao'), $subA, 'BDCORPORATIVO.scSAC')
                ->join(array('b1' => 'tbComprovantePagamento'), '(a1.idComprovantePagamento = b1.idComprovantePagamento)', null, 'BDCORPORATIVO.scSAC')
                ->join(array('c1' => 'tbPlanilhaAprovacao'), '(a1.idPlanilhaAprovacao = c1.idPlanilhaAprovacao)', null, $this->_schema)
                ->where("c1.idPlanilhaItem = k.idPlanilhaItem")
                ->where("c1.idPronac = k.idPronac")
                ->group("c1.idPlanilhaItem")
            ;

            $a = array(
                "($subSql) AS vlComprovado",
                new Zend_Db_Expr("CASE WHEN k.idProduto = 0 THEN 'Administra&ccedil;&atilde;o do Projeto' ELSE c.Descricao END as Produto"),
                "ROUND((k.QtItem * k.nrOcorrencia * k.VlUnitario),2) as vlAprovado",
                "(a.AnoProjeto+a.Sequencial) as PRONAC",
                "a.NomeProjeto",
                "a.idPronac",
                "d.Descricao as Etapa",
                "d.tpGrupo",
                "e.Descricao as Unidade",
                "f.Municipio",
                "f.UF",
                "i.Descricao as Item",
                "k.QtDias as QtdeDias",
                "k.QtItem as Quantidade",
                "k.dsJustificativa",
                "k.idAgente",
                "k.idEtapa",
                "k.idPlanilhaAprovacao",
                "k.idPlanilhaAprovacaoPai",
                "k.idProduto",
                "k.nrFonteRecurso as idFonte",
                "k.nrOcorrencia as Ocorrencia",
                "k.vlUnitario",
                "x.Descricao as FonteRecurso",
            );

            $sql = $db->select()->from(array('a' => 'Projetos'), $a, $this->_schema)
                ->join(array('k' => 'tbPlanilhaAprovacao'), '(a.idPronac = k.idPronac)', null, $this->_schema)
                ->joinLeft(array('c' => 'Produto'), '(k.idProduto = c.Codigo)', null, $this->_schema)
                ->join(array('d' => 'tbPlanilhaEtapa'), '(k.idEtapa = d.idPlanilhaEtapa)', null, $this->_schema)
                ->join(array('e' => 'tbPlanilhaUnidade'), '(k.idUnidade = e.idUnidade)', null, $this->_schema)
                ->join(array('i' => 'tbPlanilhaItens'), '(k.idPlanilhaItem=i.idPlanilhaItens)', null, $this->_schema)
                ->join(array('x' => 'Verificacao'), '(k.nrFonteRecurso = x.idVerificacao)', null, $this->_schema)
                ->join(array('f' => 'vUfMunicipio'), '(k.idUfDespesa = f.idUF and k.idMunicipioDespesa = f.idMunicipio)', null, 'agentes.dbo')
                ->where("k.stAtivo = 'N'")
                ->where("k.tpPlanilha = 'RP'")
                ->where("((ROUND((k.qtItem * k.nrOcorrencia * k.vlUnitario),2) <> 0) OR (k.dsJustificativa IS NOT NULL))")
                ->where("a.idPronac = ?", $idPronac)
                ->order("x.Descricao")
                ->order('c.Descricao DESC')
                ->order("CONVERT(VARCHAR(8),d.idPlanilhaEtapa) + ' - ' + d.Descricao")
                ->order('f.UF')
                ->order('f.Municipio')
                ->order('i.Descricao')
            ;
        } else {

            $subA = array(
                "sum(b1.vlComprovacao) AS vlPagamento",
            );

            $subSql = $db->select()->from(array('a1' => 'tbComprovantePagamentoxPlanilhaAprovacao'), $subA, 'BDCORPORATIVO.scSAC')
                ->join(array('b1' => 'tbComprovantePagamento'), '(a1.idComprovantePagamento = b1.idComprovantePagamento)', null, 'BDCORPORATIVO.scSAC')
                ->join(array('c1' => 'tbPlanilhaAprovacao'), '(a1.idPlanilhaAprovacao = c1.idPlanilhaAprovacao)', null, $this->_schema)
                ->where("c1.idPlanilhaItem = k.idPlanilhaItem")
                ->where("c1.idPronac = k.idPronac")
                ->group("c1.idPlanilhaItem")
            ;

            $c = array(
                "($subSql) AS vlComprovado",
                new Zend_Db_Expr("CASE WHEN k.idProduto = 0 THEN 'Administra&ccedil;&atilde;o do Projeto' ELSE c.Descricao END as Produto"),
                "ROUND((k.QtItem * k.nrOcorrencia * k.VlUnitario),2) as vlAprovado",
                "(a.AnoProjeto+a.Sequencial) as PRONAC",
                "a.NomeProjeto",
                "a.idPronac",
                "d.Descricao as Etapa",
                "d.tpGrupo",
                "e.Descricao as Unidade",
                "f.Municipio",
                "f.UF",
                "i.Descricao as Item",
                "k.QtDias as QtdeDias",
                "k.QtItem as Quantidade",
                "k.dsJustificativa",
                "k.idAgente",
                "k.idEtapa",
                "k.idPlanilhaAprovacao",
                "k.idPlanilhaAprovacaoPai",
                "k.idProduto",
                "k.nrFonteRecurso as idFonte",
                "k.nrOcorrencia as Ocorrencia",
                "k.vlUnitario",
                "x.Descricao as FonteRecurso",
            );

            $sql = $db->select()->from(array('a' => 'Projetos'), $c, $this->_schema)
                ->join(array('k' => 'tbPlanilhaAprovacao'), '(a.idPronac = k.idPronac)', null, $this->_schema)
                ->joinLeft(array('c' => 'Produto'), '(k.idProduto = c.Codigo)', null, $this->_schema)
                ->join(array('d' => 'tbPlanilhaEtapa'), '(k.idEtapa = d.idPlanilhaEtapa)', null, $this->_schema)
                ->join(array('e' => 'tbPlanilhaUnidade'), '(k.idUnidade = e.idUnidade)', null, $this->_schema)
                ->join(array('i' => 'tbPlanilhaItens'), '(k.idPlanilhaItem=i.idPlanilhaItens)', null, $this->_schema)
                ->join(array('x' => 'Verificacao'), '(k.nrFonteRecurso = x.idVerificacao)', null, $this->_schema)
                ->join(array('f' => 'vUfMunicipio'), '(k.idUfDespesa = f.idUF and k.idMunicipioDespesa = f.idMunicipio)', null, 'agentes.dbo')
                ->where("k.stAtivo = 'S'")
                ->where("k.tpPlanilha = 'RP'")
                ->where("((ROUND((k.qtItem * k.nrOcorrencia * k.vlUnitario),2) <> 0) OR (k.dsJustificativa IS NOT NULL))")
                ->where("a.idPronac = ?", $idPronac)
                ->order("x.Descricao")
                ->order('c.Descricao DESC')
                ->order("CONVERT(VARCHAR(8),d.idPlanilhaEtapa) + ' - ' + d.Descricao")
                ->order('f.UF')
                ->order('f.Municipio')
                ->order('i.Descricao')
            ;
        }

        return $db->fetchAll($sql);
    }

    public function readequacao($idPronac)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB::FETCH_OBJ);

        $a = array("*",);

        $sql = $db->select()->from(array('a' => 'tbplanilhaaprovacao'), $a, $this->_schema)
            ->join(array('b' => 'tbReadequacao'), '(a.idPronac = b.idPronac)', null, $this->_schema)
            ->where("a.idPronac = ?", $idPronac)
            ->where("a.stAtivo = 'N'")
            ->where("a.tpPlanilha = 'SR'")
            ->where("b.idTipoReadequacao = 2")
            ->where("b.siEncaminhamento <> 15")
            ->where("b.stEstado = 0")
            ->limit(1)
        ;

        $readequacao = $db->fetchAll($sql);

        if (!empty($readequacao)) {
            $subA = array(
                "sum(b1.vlComprovacao) AS vlPagamento",
            );

            $subSQL = $db->select()->from(array('a1' => 'tbComprovantePagamentoxPlanilhaAprovacao'), $subA, 'BDCORPORATIVO.scSAC')
                ->join(array('b1' => 'tbComprovantePagamento'), '(a1.idComprovantePagamento = b1.idComprovantePagamento)', null, 'BDCORPORATIVO.scSAC')
                ->join(array('c1' => 'tbPlanilhaAprovacao'), '(a1.idPlanilhaAprovacao = c1.idPlanilhaAprovacao)', null, $this->_schema)
                ->where("c1.idPlanilhaItem = k.idPlanilhaItem")
                ->where("c1.idPronac = k.idPronac")
                ->group("c1.idPlanilhaItem")
            ;

            $a = array(
                "($subSQL) as vlComprovado",
                new Zend_Db_Expr("CASE WHEN k.idProduto = 0 THEN 'Administra&ccedil;&atilde;o do Projeto' ELSE c.Descricao END as Produto"),
                "ROUND((k.QtItem * k.nrOcorrencia * k.VlUnitario),2) as vlAprovado",
                "( a.AnoProjeto+a.Sequencial ) as PRONAC",
                "a.NomeProjeto",
                "a.idPronac",
                "d.Descricao as Etapa",
                "d.tpGrupo",
                "e.Descricao as Unidade",
                "f.Municipio",
                "f.UF",
                "i.Descricao as Item",
                "k.QtDias as QtdeDias",
                "k.QtItem as Quantidade",
                "k.dsJustificativa",
                "k.idAgente",
                "k.idEtapa",
                "k.idPlanilhaAprovacao",
                "k.idPlanilhaAprovacaoPai",
                "k.idProduto",
                "k.nrFonteRecurso as idFonte",
                "k.nrOcorrencia as Ocorrencia",
                "k.tpAcao",
                "k.vlUnitario",
                "x.Descricao as FonteRecurso",
            );
            $sql = $db->select()->from(array('a' => 'Projetos'), $a, $this->_schema)
                ->join(array('k' => 'tbPlanilhaAprovacao'), '(a.idPronac = k.idPronac)', null, $this->_schema)
                ->joinLeft(array('c' => 'Produto'), '(k.idProduto = c.Codigo)', null, $this->_schema)
                ->join(array('d' => 'tbPlanilhaEtapa'), '(k.idEtapa = d.idPlanilhaEtapa)', null, $this->_schema)
                ->join(array('e' => 'tbPlanilhaUnidade'), '(k.idUnidade = e.idUnidade)', null, $this->_schema)
                ->join(array('i' => 'tbPlanilhaItens'), '(k.idPlanilhaItem=i.idPlanilhaItens)', null, $this->_schema)
                ->join(array('x' => 'Verificacao'), '(k.nrFonteRecurso = x.idVerificacao)', null, $this->_schema)
                ->join(array('f' => 'vUfMunicipio'), '(k.idUfDespesa = f.idUF and k.idMunicipioDespesa = f.idMunicipio)', null, $this->getSchema('agentes'))
                ->where("k.stAtivo = 'N'")
                ->where("k.tpPlanilha = 'SR'")
                ->where("((ROUND((k.qtItem * k.nrOcorrencia * k.vlUnitario),2) <> 0) OR (k.dsJustificativa IS NOT NULL))")
                ->where("a.idPronac = ?", $idPronac)
                ->order("x.Descricao")
                ->order("c.Descricao DESC")
                ->order("f.UF")
                ->order("f.Municipio")
                ->order("i.Descricao")
                ->order("CONVERT(VARCHAR(8),d.idPlanilhaEtapa) + ' - ' + d.Descricao")
            ;
        } else {
            $subA = array(
                "sum(b1.vlComprovacao) AS vlPagamento",
            );

            $subSQL = $db->select()->from(array('a1' => 'tbComprovantePagamentoxPlanilhaAprovacao'), $subA, 'BDCORPORATIVO.scSAC')
                ->join(array('b1' => 'tbComprovantePagamento'), '(a1.idComprovantePagamento = b1.idComprovantePagamento)', null, 'BDCORPORATIVO.scSAC')
                ->join(array('c1' => 'tbPlanilhaAprovacao'), '(a1.idPlanilhaAprovacao = c1.idPlanilhaAprovacao)', null, $this->_schema)
                ->where("c1.idPlanilhaItem = k.idPlanilhaItem")
                ->where("c1.idPronac = k.idPronac")
                ->group("c1.idPlanilhaItem")
            ;

            $a = array(
                "($subSQL) as vlComprovado",
                new Zend_Db_Expr("CASE WHEN k.idProduto = 0 THEN 'Administra&ccedil;&atilde;o do Projeto' ELSE c.Descricao END as Produto"),
                "ROUND((k.QtItem * k.nrOcorrencia * k.VlUnitario),2) as vlAprovado",
                "(a.AnoProjeto+a.Sequencial) as PRONAC",
                "a.NomeProjeto",
                "a.idPronac",
                "d.Descricao as Etapa",
                "d.tpGrupo",
                "e.Descricao as Unidade",
                "f.Municipio",
                "f.UF",
                "i.Descricao as Item",
                "k.QtDias as QtdeDias",
                "k.QtItem as Quantidade",
                "k.dsJustificativa",
                "k.idAgente",
                "k.idEtapa",
                "k.idPlanilhaAprovacao",
                "k.idPlanilhaAprovacaoPai",
                "k.idProduto",
                "k.nrFonteRecurso as idFonte",
                "k.nrOcorrencia as Ocorrencia",
                "k.tpAcao",
                "k.vlUnitario",
                "x.Descricao as FonteRecurso",
            );

            $sql = $db->select()->from(array('a' => 'Projetos'), $a, $this->_schema)
                ->join(array('k' => 'tbPlanilhaAprovacao'), '(a.idPronac = k.idPronac)', null, $this->_schema)
                ->joinLeft(array('c' => 'Produto'), '(k.idProduto = c.Codigo)', null, $this->_schema)
                ->join(array('d' => 'tbPlanilhaEtapa'), '(k.idEtapa = d.idPlanilhaEtapa)', null, $this->_schema)
                ->join(array('e' => 'tbPlanilhaUnidade'), '(k.idUnidade = e.idUnidade)', null, $this->_schema)
                ->join(array('i' => 'tbPlanilhaItens'), '(k.idPlanilhaItem=i.idPlanilhaItens)', null, $this->_schema)
                ->join(array('x' => 'Verificacao'), '(k.nrFonteRecurso = x.idVerificacao)', null, $this->_schema)
                ->join(array('f' => 'vUfMunicipio'), '(k.idUfDespesa = f.idUF and k.idMunicipioDespesa = f.idMunicipio)', null, $this->getSchema('agentes'))
                ->where("k.stAtivo = 'S'")
                ->where("k.tpPlanilha = 'SR'")
                ->where("k.tpAcao <> 'E'")
                ->where("((ROUND((k.qtItem * k.nrOcorrencia * k.vlUnitario),2) <> 0) OR (k.dsJustificativa IS NOT NULL))")
                ->where("a.idPronac = ? ", $idPronac)
                ->order("x.Descricao")
                ->order("c.Descricao DESC")
                ->order("f.UF")
                ->order("f.Municipio")
                ->order("i.Descricao")
                ->order("CONVERT(VARCHAR(8),d.idPlanilhaEtapa) + ' - ' + d.Descricao")
            ;
        }
        return $db->fetchAll($sql);
    }
}
