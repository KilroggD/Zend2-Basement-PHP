<?php
namespace User\Controller;
use User\Entity\Users as UserEntity;
use Zend\View\Model\ViewModel;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegistrationController
 *
 * @author kopychev
 */
class RegistrationController extends MyAbstractController{
    public $errors=array();
    public function indexAction() {

            }
    
      public function registerAction(){
          $form=$this->getFormByKey("User\Form\Registration");
          $request=$this->getRequest();
          if($request->isPost()){
              $user=new UserEntity();
              $form->bind($user);
              $post=$request->getPost();
              $form->setData($post);
              if($form->isValid()){
                     if($user=$this->checkUserData($user, $post)){
                         $activation=new \User\Entity\UserActivation();
                         $token=$this->getServiceLocator()->get('tokenService')->generateToken($user->getEmail(), 'RegSecretTextKey'.rand(1000, 3000));
                         $activation->setToken($token);                         
                         $user->setUserActivation($activation);
                         $activation->setUser($user);
                         $this->getEntityManager()->persist($user);
                        $this->getEntityManager()->flush();   
                        $link=$this->base.$this->url()->fromRoute('register/activate',array("uid"=>$user->getId(),"token"=>$token));
                        $this->getEventManager()->trigger("registration",$this, array("email"=>$user->getEmail(),"login"=>$user->getLogin(),"link"=>$link));
                        return $this->redirect()->toRoute("home");
                        }
              }
          }
          return array("form"=>$form, "errors"=>$this->errors);
      }      
      
      public function activateAction(){
          
      }
      
    
        private function checkUserData($user,$post){            
            $uFounde=$this->getRepository("User\Entity\Users")->validateUnique("email",$post["user"]["email"]);
            $uFoundl=$this->getRepository("User\Entity\Users")->validateUnique("login",$post["user"]["login"]);
            if($uFounde){
                $this->errors["user"]["email"]="Пользователь с таким email уже зарегистрирован";
                return false;
            }
            if($uFoundl){
                $this->errors["user"]["login"]="Пользователь с таким логином уже зарегистрирван";
                return false;
            }
        if($post["user"]["password"] && $post["user"]["confirmpassword"]) {            
            if($post["user"]["password"]===$post["user"]["confirmpassword"]){
            $user->setPassword($post["user"]["password"]);
            }
            else {
                $this->errors["user"]["password"]="Пароль и подтверждение не совпадают";
                return false;
            }
        }
        return $user;
    }
}
