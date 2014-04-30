<?php
namespace Acl\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminController
 *
 * @author kopychev
 */
class AdminController extends MyAbstractController{
    //put your code here
    public function indexAction(){
        exit("here will be acl list!");
    }    
    
    public function modulesAction(){
        
        $this->getEventManager()->trigger('aclUpdate', $this);
        return true;
    }
    
}
