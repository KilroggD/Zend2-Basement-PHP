<?php
namespace User\Controller;
use Zend\View\Model\ViewModel;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminController
 * Контроллер для администрирования раздела "пользователи"
 * @author kopychev
 */
class AdminController extends MyAbstractController{
    //put your code here
    public $query, $refUrl, $errors=array();
    public function indexAction(){
            $page=isset($this->query["page"])?$this->query["page"]:1;
            $form=$this->getFormByKey('User\Form\Search');
            if($this->query) {
            $form->setData($this->query);
            }
            $gform=$this->getFormByKey('User\Form\Group');
            $records=$this->getRepository('User\Entity\Users')->search($this->query);
            $paginated=$this->Paginator()->paginate($records,20,$page);
            return array("users"=>$paginated->getItems(),"pages"=>$paginated->getCount(),"currentPage"=>$page,"form"=>$form, "pagelimit"=>3, "gform"=>$gform, "messages"=>$this->flashMessenger()->getMessages(),"query"=>$this->query);        
    }
    
    public function editAction(){
        $id=$this->params()->fromRoute('id');
        $request=$this->getRequest();
        if($id){
            $user=$this->getRepository('User\Entity\Users')->find($id);
            if($user){
                $form = $this->getFormByKey('User\Form\User');
                $form->bind($user);
                if($request->isPost()){
                    $post=$request->getPost();
                    $form->setData($post);
                    if($form->isValid()){            
                        if($user=$this->checkUserData($user, $post)){
                        $this->getEntityManager()->persist($user);
                        $this->getEntityManager()->flush();                         
                        return $this->redirect()->toRoute("user\\admin");
                        }
                    }
                           }
                return array("form"=>$form, "errors"=>$this->errors);
            }
                    }
        else {
            return $this->redirect()->toRoute("user\\admin");
        }
      }
    
    /**
     * Групповые операции
     */
     public function groupAction(){
     $request=$this->getRequest();
     if($request->isPost()){
            $users=$request->getPost('user');
            //все это нужно если выбраны юзеры
            if($users){
            $type=$request->getPost('actiontype');
            switch($type){
             case 'assign':
                 $role=$this->getRepository("Acl\Entity\AclRoles")->find($request->getPost('role'));
                 $this->assignAction($users, $role);
                 break;
             case 'block':
                 $this->blockAction($users);
                 break;
             case 'unblock':
                 $this->unblockAction($users);
                 break;
             case 'delete':
                 $this->gdeleteAction($users);
                 break;
             default : break;
            }          
            }
            else {
                $this->flashMessenger()->addMessage("Не выбрано ни одного пользователя");
            }
                }
        $this->redirect()->toRoute("user\\admin",array(),array("query"=>$this->query));
    }
    /**
     * Назначить роль
     */
    public function assignAction($users,$role){           
          foreach($users as $user){               
                $userFound=$this->getRepository('User\Entity\Users')->find($user);
                 if($userFound->getBuiltIn()){
                    //админа не изменяем
                    continue;
                }
               if($userFound && !$userFound->getRoles()->contains($role)){
                   /**
                    * Если нашли юзера с таким id - назначаем роль
                    */
                   $userFound->addRole($role);
                   
               }
            }
            $this->getEntityManager()->flush();
       $this->flashMessenger()->addMessage("Роли пользователей успешно изменены");             
        return;
                }
    
    /**
     * Блокировать выбранных
     */
    public function blockAction($users){
   
            foreach($users as $user){
                if($user==1){
                    //админа не изменяем
                    continue;
                }
                    $userFound=$this->getRepository('User\Entity\Users')->find($user);
               if($userFound){
                   $userFound->setStatus(\User\Entity\Users::BLOCKED);
               } 
            }
             $this->getEntityManager()->flush();
            $this->flashMessenger()->addMessage("Выбранные пользователи блокированы");
        return;
    }
    /**
     * Разблокировать выбранных
     */
    public function unblockAction($users){
            foreach($users as $user){
                if($user==1){
                    //админа не изменяем
                    continue;
                }
                    $userFound=$this->getRepository('User\Entity\Users')->find($user);
               if($userFound){
                   $userFound->setStatus(\User\Entity\Users::ACTIVE);
               } 
            }
        $this->getEntityManager()->flush();
        $this->flashMessenger()->addMessage("Выбранные пользователи разблокированы");
        return;      
    }
    /**
     * Удалить выбранных
     */
    public function gdeleteAction($users){  
        $deleted=array();
            foreach($users as $user){
                if($user==1){
                    //админа не изменяем
                    continue;
                }
                    $userFound=$this->getRepository('User\Entity\Users')->find($user);
               if($userFound){                   
                   $this->getEntityManager()->remove($userFound);
                  $this->getEntityManager()->flush();
               } 
            }
            $this->getEntityManager()->flush();
            $this->flashMessenger()->addMessage("Выбранные пользователи удалены");
        return;        
    }
    /**
     * Сделать юзера системным администратором
     */
    public function toadminAction(){
        $id=$this->params()->fromRoute("id");
        if($id){
            $user=$this->getRepository("User\Entity\Users")->find($id);
            if($user) {
                $user->addRole($this->getRepository("Acl\Entity\AclRoles")->find(1));
                $this->getEntityManager()->flush();
            }
        }
        return $this->redirect()->toRoute("user\\admin");
    }
    
        private function checkUserData($user,$post){
           // var_dump($post);
            //exit();
            $uFound=$this->getRepository("User\Entity\Users")->findOneByEmail($post["user"]["email"]);
            if($uFound && $uFound->getId()!==$user->getId()){
                $this->errors["user"]["email"]="Пользователь с таким email уже зарегистрирован";               
                return false;
            }
        if($post["user"]["password"] && $post["user"]["confirmpassword"]) {            
            if($post["user"]["password"]===$post["user"]["confirmpassword"]){
            $user->setPassword(md5($post["user"]["password"]));
            }
            else {
                $this->errors["user"]["password"]="Пароль и подтверждение не совпадают";
                return false;
            }
        }
        return $user;
    }
    
    
    
}
