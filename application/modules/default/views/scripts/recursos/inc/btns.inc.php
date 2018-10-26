<?php
/**
 * Bot�es "Planilha de Or�amento Aprovado" e "Parecer Consolidado"
 * @author Equipe RUP - Politec
 * @since 20/07/2010
 * @version 1.0
 * @package application
 * @subpackage application.view.scripts.recurso.inc
 * @copyright � 2010 - Minist�rio da Cultura - Todos os direitos reservados.
 * @link http://www.cultura.gov.br
 */


?>

<table class="tabela">
	<tr>
		<th width="50%" class="<?php if (strstr($this->url(), 'orcamento') == 'orcamento') {
    echo "fundo_linha4";
} else {
    echo "fundo_linha2";
} ?>"><a href="<?php echo $this->url(array('controller' => 'recursos', 'action' => 'orcamento'));?>?idPronac=<?php echo $_GET['idPronac']; ?>&idRecurso=<?php echo $_GET['idRecurso']; ?>">Planilha Or�ament&aacute;ria</a></th>
		<th width="50%" class="<?php if (strstr($this->url(), 'parecer')   == 'parecer') {
    echo "fundo_linha4";
} else {
    echo "fundo_linha2";
} ?>"><a href="<?php echo $this->url(array('controller' => 'recursos', 'action' => 'parecer'));?>?idPronac=<?php echo $_GET['idPronac']; ?>&idRecurso=<?php echo $_GET['idRecurso']; ?>">Parecer Consolidado</a></th>
	</tr>
</table>