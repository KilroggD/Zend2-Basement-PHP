<?php
namespace Log\Service;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LogService
 *
 * @author kopychev
 */
class LogService {
    //put your code here
    protected  $dm,$em;
    public function __construct($sm) {
        //документ менеджер для монго
        $this->dm=$sm->get('doctrine.documentmanager.odm_default');
        //em для постгреса
        $this->em=$sm->get('Doctrine\ORM\EntityManager');
    }
    
    public function write($params){
        if($params["type"]==="m"){
        $log=new \Log\Document\Log();
        $proc=$this->dm;
        }
        if($params["type"]==="pg"){
            $log=new \Log\Entity\Log();
            $proc=$this->em;
        }        
        $log->setCategory($params["category"]);
        $log->setImportance($params["importance"]);
        $log->setText($params["text"]);
        $log->setUrl($params["url"]);
        $proc->persist($log);
        $proc->flush();
    }
    
}
