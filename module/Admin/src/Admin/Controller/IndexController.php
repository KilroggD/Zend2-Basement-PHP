<?php
namespace Admin\Controller;
use Zend\Mvc\Controller\AbstractActionController;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexController
 *
 * @author kopychev
 */
class IndexController extends AbstractActionController{
    //put your code here
    public $userParams;
    public function indexAction() {
       $mm=$this->getServiceLocator()->get("ModuleManager");
       $modules=$mm->getModules("Log");
       return array("modules"=>$modules);
    }
    
}
