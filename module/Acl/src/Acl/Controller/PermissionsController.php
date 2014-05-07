<?php
namespace Acl\Controller;
use Acl\Entity\AclPermissions;
use Zend\View\Model\ViewModel;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PermissionController
 * Распрелеление разрешений по ролям
 * @author kopychev
 */
class PermissionsController extends MyAbstractController {
    //put your code here
    /**
     * Листинг пермишнов
     */
    public function indexAction(){
        //выбираем массивы с нужной инфой из entities
        $permissions=$this->getRepository("Acl\Entity\AclPermissions")->getAllIncluded();
        $roles=$this->getRepository("Acl\Entity\AclRoles")->getRolesWithPermissions();
        return array("permissions"=>$permissions,"roles"=>$roles,"messages"=>$this->flashMessenger()->getMessages(), "saveUrl"=>$this->url()->fromRoute("acl\\admin\\permissions/save"));
     }
    /**
     * Сохранение пермишнов
     */
    public function saveAction(){
        $request=$this->getRequest();
        if($request->isPost()){
            $acl=$request->getPost('acl');
            //перебираем роли с айдишниками пермишнов из пост-запроса
            foreach($acl as $roleid=>$params){
                if($params["enabled"]){                    
                $role=$this->getRepository('Acl\Entity\AclRoles')->find($roleid);
                if($role){
                $role->getPermissions()->clear();
                $permend=array();
                if(isset($params["permissions"])){
                    foreach($params["permissions"] as $permid){
                        $permission=$this->getRepository('Acl\Entity\AclPermissions')->find($permid);
                        $permend[]=$permission->getId();
                        $role->getPermissions()->add($permission);
                    }
                }
                 $this->getEntityManager()->flush();
                    }     
                }
            }
                $this->flashMessenger()->addMessage("Разрешения назначены");
        }
        $this->redirect()->toRoute("acl\\admin\\permissions");
    }
}
