<?php
namespace Acl\Controller;
use Acl\Entity;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RoleController
 * Управление ролями пользователей
 * @author kopychev
 */
class RoleController extends MyAbstractController{
    private $repository;
    //put your code here
    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        $this->repository=$this->getRepository("Acl\Entity\AclRoles");
        parent::onDispatch($e);
    }
    /**
     * Список доступных ролей в системе
     */
    public function indexAction(){
         $roles=array();
        $records=$this->repository->findBy(array(),array('name'=>'ASC'));
        foreach ($records as $role){
            $roles[]=array(
              "id"=>$role->getId(),
               "name"=>$role->getName(),
                "builtIn"=>$role->getBuiltIn(),
            );
        }
        $form=$this->getFormByKey("Acl\Form\RoleForm");
        $form->setAttribute("action",$this->url()->fromRoute("acl\\admin\\roles/add"));
        return array("roles"=>$roles, "form"=>$form, "messages"=>$this->flashMessenger()->getMessages());
    }
    /**
     * Добавить роль
     */
    public function addAction(){
                $request=$this->getRequest();
        $form=$this->getFormByKey("Acl\Form\RoleForm");
        $id=$this->params()->fromRoute("id");
        $role=new Entity\AclRoles();        
        if($id){
            $role=$this->repository->find($id);
        }
        if($request->isPost()){
            $form->bind($role);
            $post=$request->getPost();
            $roleFound=$this->repository->findOneByName($post["name"]);
            if($roleFound){
            $this->flashMessenger()->addMessage("Роль с таким именем уже существует");
                        }
        else {
            $form->setData($post);
            if($form->isValid()){
            $this->getEntityManager()->persist($role);
            $this->getEntityManager()->flush();
            $this->flashMessenger()->addMessage("Роль успешно добавлена");
            }
            else {
                $this->flashMessenger()->addMessage($form->get('name')->getMessages('isEmpty'));
            }
        }
        }
        $this->redirect()->toRoute("acl\\admin\\roles");
    }
    /**
     * Редактировать роль
     */
    public function editAction(){
                $id=$this->params()->fromRoute('id');
        if(!$id) {
            $this->redirect()->toRoute("acl\\admin\\roles");
        }
        $role=$this->repository->find($id);
        if(!$role){
            $this->flashMessenger()->addMessage("Роль не найдена");
        }
        $form=$this->getFormByKey('Acl\Form\RoleForm');
        $form->bind($role);
        $form->setAttribute("action",$this->url()->fromRoute("acl\\admin\\roles/add",array("id"=>$id)));
        return array("form"=>$form);
    }
    /**
     * Удалить роль
     */
    public function deleteAction(){
        
    }   
    
}
