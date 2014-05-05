<?php
namespace Acl\Controller;
/**
 * Description of AclController
 * управление ACL'ами - синхронизация с базой
 * @author kopychev
 */
class AclController extends MyAbstractController{
    //put your code here
    public $currentPermissions,$dbPermissions;
    private $allPermissions;
       public function indexAction(){
           $acls=array();
           $aclRecords=$this->getRepository("Acl\Entity\AclPermissions")->findBy(array(),array("group"=>"asc","controller"=>"asc","action"=>"asc"));
                  foreach($aclRecords as $record){
            //вытаскиваем группу, контроллер, действие
            $group=$record->getGroup();
            $controller=$record->getController();
            $action=$record->getAction();
            $acls[$group][$controller][$action]=array(
                "id"=>$record->getId(),
                "description"=>$record->getDescription(),
                "system"=>$record->getSystem(),
                "exclude"=>$record->getExclude()
            );
                  }
                  return array("acls"=>$acls);
    }    
    
    public function updateAction(){
        $this->getEventManager()->trigger('aclUpdate', $this);  
        $toDelete=array();
        $toUpdate=array();
        $delRecords=array();
        //текущие пермишны из конфига
        $cPermissions=$this->currentPermissions;
        //группы пермишнов из конфигов    
        $groups=  array_keys($cPermissions);
        $dbPermissions=$this->getRepository("Acl\Entity\AclPermissions")->findBy(array(),array("group"=>"asc","controller"=>"asc","action"=>"asc"));
        foreach($dbPermissions as $record){
            //вытаскиваем группу, контроллер, действие
            $group=$record->getGroup();
            $controller=$record->getController();
            $action=$record->getAction();
            if(isset($cPermissions[$group][$controller][$action])){
               unset($cPermissions[$group][$controller][$action]);
            }
            else {
                $toDelete[$group][$controller][$action]=array(
                  "description"=>$record->getDesctiption(),
                  "system"=>$record->getSystem(),
                   "exclude"=>$record->getExclude()
                );
                $delRecords[]=$record;
            }
        }
        $toAdd=$cPermissions;
        if($this->params()->fromRoute("flag")==='load'){
            $this->removeAcls($delRecords);
            $this->addAcls($toAdd);
            return $this->redirect()->toRoute("acl\\admin");
        }
        return array("toAdd"=>$toAdd,"toDelete"=>$toDelete);       
    }

   private function addAcls($acls){
       foreach($acls as $group=>$modules){
              foreach($modules as $module=>$actions){
                  foreach($actions as $action=>$permission){
                      extract($permission);
                      $aclPermission=new \Acl\Entity\AclPermissions();
                      $aclPermission->setAction($action);
                      $aclPermission->setController($module);
                      $aclPermission->setGroup($group);
                      $aclPermission->setDescription($description);
                      $aclPermission->setExclude($exclude);
                      $aclPermission->setSystem($system);
                      $this->getEntityManager()->persist($aclPermission);
                           }
              }
         }
                     $this->getEntityManager()->flush();
                               }
    
   private function removeAcls($records){
       foreach($records as $record){
           $this->getEntityManager()->remove($record);
       }
       $this->getEntityManager()->flush();
   } 
   
}
