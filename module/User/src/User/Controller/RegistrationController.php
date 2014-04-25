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
    
    public function indexAction() {
        $user=new UserEntity();
        $userExists=$this->getRepository("User\Entity\Users")->findOneByLogin("admin");
        if(!$userExists){
        $user->setLogin("admin");
        $user->setEmail("kopych888@gmail.com");
        $user->setPassword("0787");
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
        exit("Admin created!");
        }
        var_dump($userExists->getProfile());
        exit("Admin exists!");
            }
    
    
}
