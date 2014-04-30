<?php
namespace User\Controller;
use Zend\View\Model\ViewModel;
use User\Entity\Users as UserEntity;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfileController
 *
 * @author kopychev
 */
class ProfileController extends MyAbstractController{
    protected $errors, $myevent;
    
    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
       if(!$this->userParams) {
           $this->getEventManager()->trigger("error403");
           exit("error403!");
                  }
        parent::onDispatch($e);
    }
    /**
     * Посмотреть инфу в профайле
     */          
    public function indexAction() {           
        $id=$this->userParams->getId();
        $result=array();
        $user=$this->getRepository("User\Entity\Users")->find($id);
        if($user){
        $result["login"]=$user->getLogin();
        $result["email"]=$user->getEmail();
        $profile=$user->getProfile();
        if($profile){
            $result["firstName"]=$profile->getFirstName()?$profile->getFirstName():"";
            $result["lastName"]=$profile->getLastName()?$profile->getLastName():"";    
            $result["middleName"]=$profile->getMiddleName()?$profile->getMiddleName():"";
            $result["occupation"]=$profile->getOccupation()?$profile->getOccupation():"";
            $result["phone"]=$profile->getPhone()?$profile->getPhone():"";
        }
        } 
        return array("profile"=>$result);        
            }
    
    /**
     * Редактировать свой профайл
     */
    public function editAction(){
        $this->myevent=null;
        $id=$this->userParams->getId();
        $request=$this->getRequest();
        $user=$this->getRepository("User\Entity\Users")->find($id);
        $oldemail=$user->getEmail();
        if(!$user){
            return array("notFound"=>"Пользователь не найден");
        }
        $form=$this->getFormByKey("User\Form\Profile");
        $form->get("email")->setValue($user->getEmail());
        $profile=$user->getProfile();
        if(!$profile){
            $profile=new \User\Entity\UserProfile();
        }
        $form->bind($profile);
        if($request->isPost()){
        $post=$request->getPost()->toArray();    
        $form->setData($post);
        //валидна ли форма на серваке
        if($form->isValid()){
            //проверка емэйла и пароля - есть ли смена и т д
            if($user=$this->checkUserData($user,$post)){
             $user->setProfile($profile);
             $profile->setUser($user);
             $this->getEntityManager()->persist($user);
             $this->getEntityManager()->flush();
             if($this->myevent){
                 $this->getEventManager()->trigger($this->myevent,$this,array("id"=>$user->getId(),"oldemail"=>$oldemail,"newemail"=>$user->getEmail(),"login"=>$user->getLogin()));
             }
             return $this->redirect()->toRoute('profile');
            }       
        }
        }
        //добавляем в форму емэйл
        return array("form"=>$form,"errors"=>$this->errors);
    }
    /**
     * Проверяет заданы ли новая почта и пароль для юзера. Если да, то валидирует их и возвращает новую Entity юзера с новыми данными, либо false в случае ошибки
     * @param User\Entity\User $user
     * @param array $post
     */
    private function checkUserData($user,$post){
            $uFound=$this->getRepository("User\Entity\Users")->findOneByEmail($post["email"]);
            if($uFound && $uFound->getId()!==$user->getId()){
                $this->errors["email"]="Пользователь с таким email уже зарегистрирован";               
                return false;
            }
            elseif($user->getEmail()!==$post["email"]) {
                $user->setEmail($post["email"]);
                $this->myevent="emailChange";
            }
        if($post["password"]) {
            //проверим, верен ли старый пароль
            if(md5($post["oldpassword"])===$user->getPassword()){
            $user->setPassword(md5($post["password"]));
            }
            else {
                $this->errors["oldpassword"]="Старый пароль не верен";
                return false;
            }
        }
        return $user;
    }
    
    
    
    
}
