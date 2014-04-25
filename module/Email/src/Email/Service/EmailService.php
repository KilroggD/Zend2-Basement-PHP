<?php
namespace Email\Service;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail as SendmailTransport;
use Zend\Mime;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmailService
 *
 * @author kopychev
 */
class EmailService {
    //put your code here    
    const WFROMADDR="noreply@imc.spb.ru";
    const WFROMNAME="Администратор";
    private $_sm, $repository,$_em;
    private $text,$to,$subj;
    public function __construct($sm) {
        $this->_sm=$sm;
        $this->_em=$sm->get('Doctrine\ORM\EntityManager');
        $this->repository=$this->_em->getRepository("Email\Entity\EmailTemplates");
    }
    /**
     * 
     * @param string $to - адрес, куда отправлять
     * @param string $link - ссылка, которую отправлять
     * @param string $login - Логин юзера, которому адресовано
     */
    public function sendPasswordChange($to,$link,$login=null){
        $template=$this->repository->findOneByKey("passwordChange");
       $login=is_null($login)?'':$login;
        $text=str_replace("{{TO}}", $to, $template->getTemplate());
        $text=  str_replace("{{LINK}}", $link, $text);
        $text= str_replace("{{LOGIN}}", $login, $text);
        $this->subj=$template->getSubject();
        $this->text=$text;
        $this->to=$to;
        return $this->send();
    }
    
        protected function send(){
        try {
        $message = new Message();
        $html = new \Zend\Mime\Part($this->text);
        $html->type = 'text/html';
        $html->charset='utf-8';
        $body = new \Zend\Mime\Message;
        $body->setParts(array($html));
        $message->addFrom(self::WFROMADDR, self::WFROMNAME)->addTo($this->to)->setSubject($this->subj);
        $message->setBody($body);
        $headers = $message->getHeaders();
        $headers->removeHeader('Content-Type');
        $headers->addHeaderLine('Content-Type', 'text/html; charset=UTF-8');
        $transport = new SendmailTransport();
        $transport->send($message);
        return true;
        }
        catch (\Exception $e){
            
            return false;
        }
    }
}
