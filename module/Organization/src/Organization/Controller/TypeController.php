<?php
namespace Organization\Controller;
use Organization\Entity\OrganizationTypes;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Управление типами организаций
 *
 * @author kopychev
 */
class TypeController extends MyAbstractController{
    //put your code here
    /**
     *
     * @var \Doctrine\ORM\EntityRepository
     */
        private $repository;
    //put your code here
    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        $this->repository=$this->getRepository("Organization\Entity\OrganizationTypes");
        parent::onDispatch($e);
    }
    /**
     * Список доступных ролей в системе
     */
    public function indexAction(){        
         $items=array();
        $records=$this->repository->findBy(array(),array('name'=>'ASC'));
        foreach ($records as $item){
            $items[]=array(
              "id"=>$item->getId(),
               "name"=>$item->getName()
            );
        }
        $form=$this->getFormByKey("Organization\Form\TypeForm");
        $form->setAttribute("action",$this->url()->fromRoute("organizations\admin\types/add"));
        return array("types"=>$items, "form"=>$form, "messages"=>$this->flashMessenger()->getMessages());
    }
    /**
     * Добавить роль
     */
    public function addAction(){
                $request=$this->getRequest();
        $form=$this->getFormByKey("Organization\Form\TypeForm");
        $id=$this->params()->fromRoute("id");
        $type=new OrganizationTypes();        
        if($id){
            $type=$this->repository->find($id);
        }
        if($request->isPost()){
            $form->bind($type);
            $post=$request->getPost();
            $typeFound=$this->repository->findOneByName($post["name"]);
            if($typeFound && $typeFound->getId()!=$type->getId()){
                          $this->flashMessenger()->addMessage("Тип с таким именем уже существует");
                        }
        else {
            $form->setData($post);
            if($form->isValid()){
            $this->getEntityManager()->persist($type);
            $this->getEntityManager()->flush();
            $this->flashMessenger()->addMessage("Тип успешно сохранен");
            }
            else {
                $this->flashMessenger()->addMessage($form->get('name')->getMessages('isEmpty'));
            }
        }
        }
        $this->redirect()->toRoute("organizations\admin\types");
    }
    /**
     * Редактировать роль
     */
    public function editAction(){
                $id=$this->params()->fromRoute('id');
        if(!$id) {
            $this->redirect()->toRoute("organizations\admin\types");
        }
        $type=$this->repository->find($id);
        if(!$type){
            $this->flashMessenger()->addMessage("Тип не найден");
        }
        $form=$this->getFormByKey('Organization\Form\TypeForm');
        $form->bind($type);
        $form->setAttribute("action",$this->url()->fromRoute("organizations\admin\types/add",array("id"=>$id)));
        return array("form"=>$form);
    }
    /**
     * Удалить роль
     */
    public function deleteAction(){
                        $id=$this->params()->fromRoute('id');
                        if($id){
                            $type=$this->repository->find($id);
                            if($type){
                                $this->getEntityManager()->remove($type);
                                $this->getEntityManager()->flush();
                                $this->flashMessenger()->addMessage("Тип удален");
                            }
                        }
                                  
            $this->redirect()->toRoute("organizations\admin\types");     
    }   
    

}
