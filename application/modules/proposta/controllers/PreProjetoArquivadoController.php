<?php
class Proposta_PreProjetoArquivadoController extends Proposta_GenericController
{
    private $blnPossuiDiligencias = 0;

    public function init()
    {
        parent::init();

        if (!empty($this->idPreProjeto)) {
            $this->view->idPreProjeto = $this->idPreProjeto;

            $this->verificarPermissaoAcesso(true, false, false);

            //VERIFICA SE A PROPOSTA TEM DILIGENCIAS
            $PreProjeto = new Proposta_Model_DbTable_PreProjeto();
            $rsDiligencias = $PreProjeto->listarDiligenciasPreProjeto(array('pre.idpreprojeto = ?' => $this->idPreProjeto));
            $this->view->blnPossuiDiligencias = $rsDiligencias->count();

            $this->view->acao = $this->_urlPadrao . "/proposta/manterpropostaincentivofiscal/salvar";
        }

        // Busca na tabela apoio ExecucaoImediata
        $tableVerificacao = new Proposta_Model_DbTable_Verificacao();
        $listaExecucaoImediata = $tableVerificacao->fetchPairs('idVerificacao', 'Descricao', array('idTipo' => 23), array('idVerificacao'));
        $this->view->listaExecucaoImediata = $listaExecucaoImediata;

        $this->auth = Zend_Auth::getInstance();

        $this->events = new Zend_EventManager_EventManager();
        $this->events->attach('email', $this->email('teste'));
    }

    public function verificaPermissaoAcessoProposta($idPreProjeto)
    {
        $tblProposta = new Proposta_Model_DbTable_PreProjeto();
        $rs = $tblProposta->buscar(array("idPreProjeto = ? " => $idPreProjeto, "1=1 OR idEdital IS NULL OR idEdital > 0" => "?", "idUsuario =?" => $this->idResponsavel));
        return $rs->count();
    }

    public function storeAction()
    {
        $message = null;
        $success = true;

        $idAvaliador = $this->auth->getIdentity()->usu_codigo;
        $idPreProjeto = $this->getRequest()->getParam("idPreProjeto");
        $MotivoArquivamento = $this->getRequest()->getParam("MotivoArquivamento");

        $arquivar = new Proposta_Model_PreProjetoArquivado();

        $data = [
            'idPreProjeto' => $idPreProjeto,
            'MotivoArquivamento' => $MotivoArquivamento,
            'idAvaliador' => $idAvaliador,
            'stEstado' =>  1, // arquivamento ativo.
            'dtArquivamento' => date('Y-m-d h:i')
        ];

        try {
            $arquivar->insert($data);
        } catch(Exception $e){
            $message = $e->getMessage();
            $success = false;
        }

        $agente = new Proposta_Model_DbTable_PreProjeto();
        $agente = $agente->buscaCompleta(['a.idPreProjeto = ? ' => $idPreProjeto]);

        $email = new StdClass();
        $email->text = 'Motivo Arquivamento: '. $MotivoArquivamento;
        $email->to = $agente->current()->EmailAgente;
        $email->subject = 'SALIC - Arquivamento Proposta: ' . $idPreProjeto;

        $this->events->trigger('email', $this, $email);

        $this->_helper->json(
            [
                'data' => $data,
                'success' => $success,
                'message' => $message
            ]
        );
    }

    private function email($texto)
    {
        return function($e) {
            $email = $e->getParams();
            $config = new Zend_Config_Ini(APPLICATION_PATH .'/configs/application.ini', APPLICATION_ENV);
            $emailDefault = $config->mail->default->toArray();
            $config = $config->mail->transport->toArray();

            $transport = new Zend_Mail_Transport_Smtp($config['host'], $config);
            $mail = new Zend_Mail();

            $mail->setBodyHtml($email->text);
            $mail->setFrom($emailDefault['email'], 'Salic');
            $mail->addTo($email->to);
            $mail->setSubject($email->subject);
            $mail->send($transport);
        };
    }
}
