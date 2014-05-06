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
           $aclRecords=$this->getRepository("Acl\Entity\AclPermissions")->findBy(array(),array("grp"=>"asc","controller"=>"asc","action"=>"asc"));
                  foreach($aclRecords as $record){
            //вытаскиваем группу, контроллер, действие
            $group=$record->getGrp();
            $controller=$record->getController();
            $action=$record->getAction();
            $acls[$group][$controller][$action]=array(
                "id"=>$record->getId(),
                "description"=>$record->getDescription(),
                "system"=>$record->getSystem(),
                "exclude"=>$record->getExclude()
            );
                  }
                  return array("acls"=>$acls,"messages"=>$this->flashMessenger()->getMessages());                  
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
        $dbPermissions=$this->getRepository("Acl\Entity\AclPermissions")->findBy(array(),array("grp"=>"asc","controller"=>"asc","action"=>"asc"));
        foreach($dbPermissions as $record){
            //вытаскиваем группу, контроллер, действие
            $group=$record->getGrp();
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

    
    public function editAction(){
        $id=$this->params()->fromRoute("id");
        if($id){
        $request=$this->getRequest();
        $form=$this->getFormByKey('Acl\Form\AclForm');
        $form->setAttribute("action",$this->url()->fromRoute("acl\\admin/edit",array("id"=>$id)));
        $aclPermission=$this->getRepository("Acl\Entity\AclPermissions")->find($id);
        $form->bind($aclPermission);
        if($request->isPost()){
          $post=$request->getPost();  
          $form->setData($post);
          if($form->isValid()){
              $this->getEntityManager()->persist($aclPermission);
              $this->getEntityManager()->flush();
              return $this->redirect()->toRoute("acl\\admin");
                                }
        }      
        return array("form"=>$form);
        }
        else {
            return $this->getResponse()->setStatusCode(404);
        }
    }
    
    public function deleteAction(){
     $id=$this->params()->fromRoute("id");
     if($id){
         $aclPermission=$this->getRepository("Acl\Entity\AclPermissions")->find($id);
         if($aclPermission){
             $this->getEntityManager()->remove($aclPermission);
             $this->getEntityManager()->flush();
             $this->flashMessenger()->addMessage("Разрешение удалено");
         }
     }
     return $this->redirect()->toRoute('acl\\admin');
    }
    
    /**
     * Добавление Acl из массива
     * @param array $acls
     */
   private function addAcls($acls){
       foreach($acls as $group=>$modules){
              foreach($modules as $module=>$actions){
                  foreach($actions as $action=>$permission){
                      extract($permission);
                      $aclPermission=new \Acl\Entity\AclPermissions();
                      $aclPermission->setAction($action);
                      $aclPermission->setController($module);
                      $aclPermission->setGrp($group);
                      $aclPermission->setDescription($description);
                      $aclPermission->setExclude($exclude);
                      $aclPermission->setSystem($system);
                      $this->getEntityManager()->persist($aclPermission);
                           }
              }
         }
                     $this->getEntityManager()->flush();
                               }
    /**
     * Удаление коллекции entities Acl
     * @param array $records
     */
   private function removeAcls($records){
       foreach($records as $record){
           $this->getEntityManager()->remove($record);
       }
       $this->getEntityManager()->flush();
   } 
   
}
