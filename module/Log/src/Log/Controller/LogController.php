<?php
namespace Log\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LogController
 *
 * @author kopychev
 */
class LogController extends \Log\Controller\MyAbstractController{
    //put your code here
    public function indexAction() {
        $dm=$this->getDocumentManager();
        $repo1=$this->getRepository("Log\Entity\Log");
        $repo=$dm->getRepository("Log\Document\Log");
        $logs=$repo->findAll();
        //$this->getEventManager()->trigger("log",$this, array("category"=>"logs", "importance"=>"notification", "text"=>"тест логов"));
        echo "From mongo: <br/>";
        print_r($logs);
        $logs=$repo1->findAll();
        echo "<br/>From Pg: <br/>";
        print_r($logs);
        exit;
        
    }
    
    public function addAction(){
        $log=new \Log\Document\Log();
        $log->setCategory("admin");
        $log->setImportance("error");
        $log->setText("SomeError".rand(1, 100));
        $this->getDocumentManager()->persist($log);
        $this->getDocumentManager()->flush();
        return $this->redirect()->toRoute("log");
    }
    
}
