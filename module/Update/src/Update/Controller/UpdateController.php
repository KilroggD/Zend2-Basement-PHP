<?php
namespace Update\Controller;
use  \Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\Mapping\Driver\YamlDriver as YamlDriverORM;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UpdateController
 *
 * @author kopychev
 */
class UpdateController extends AbstractActionController{
    //put your code here
    public $userParams;
    public function indexAction(){
        $migrations=$this->getServiceLocator()->get("MigrationService")->getMigrations();       
        $new=  array_diff($migrations["available"], $migrations["migrated"]);
        $migrations["new"]=$new;
        $yml=new YamlDriverORM("./yml");
        $pgTables=$yml->getAllClassNames();
        
        return array("migrations"=>$migrations,"messages"=>$this->flashMessenger()->getMessages());
    }
    /**
     * Создание новых миграций, исходя из различий схемы и yml/entity
     */
    public function diffAction(){

        $response=$this->getServiceLocator()->get("MigrationService")->createDiff();
        if($response instanceof \Exception){
            die($response->getMessage());
        }
        return $this->redirect()->toRoute("admin\\update");
    }    
    
    /**
     * Миграция к выбранной версии
     */
    public function migrateAction(){
        $version=0;
        if($this->params()->fromRoute("version")){
            $version=$this->params()->fromRoute("version");
        }
        $response=$this->getServiceLocator()->get("MigrationService")->migrate($version);
              if($response instanceof \Exception){
            die($response->getMessage());
        }
        $this->flashMessenger()->addMessage($response);
        return $this->redirect()->toRoute("admin\\update");
    }
    /**
     * Обновляет entites по миграции
     */
    public function entityAction(){
        try {
         $response=$this->getServiceLocator()->get("MigrationService")->updateEntity();
        $this->flashMessenger()->addMessage($response);
            $this->flashMessenger()->addMessage("Модели обновлены");
            return $this->redirect()->toRoute("admin\\update");
        } catch (\Exception $ex) {
            die ($ex->getMessage());
        }
    }
    
    public function deleteAction(){
        $version=$this->params()->fromRoute("version");
        $response=$this->getServiceLocator()->get("MigrationService")->delete($version);
        $this->flashMessenger()->addMessage($response);
        return $this->redirect()->toRoute("admin\\update");
    }
    
}
