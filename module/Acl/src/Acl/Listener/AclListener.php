<?php
namespace Acl\Listener;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AclListener
 * Обработчик событий для модуля Acl
 * @author kopychev
 */
class AclListener implements \Zend\EventManager\ListenerAggregateInterface{
       /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
        private $invokables,$controllers;
        protected $listeners=array(),$_sm,$target, $permissions;
        /**
         * В конструкторе определяем сервис-менеджер
         * @param type $sm
         */
    public function __construct($sm) {        
        $this->_sm=$sm;
        $this->permissions=array();
        $this->invokables=array();
        $this->controllers=array();
    }
    public function attach(EventManagerInterface $events) {
     $sharedEvents=$events->getSharedManager();
     $this->listeners[]=$sharedEvents->attach('Acl\Controller\AdminController', 'aclUpdate', array($this,'onAclUpdate'), 100);
    }
    
    public function detach(EventManagerInterface $events) {
        
              foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
    
    public function onAclUpdate($e){
        $controller=$e->getTarget();
       $config=$controller->getServiceLocator()->get('Config');
       $controllerList=$config["controllers"]["invokables"];
       //алиасы контроллеров
       $this->invokables=  array_keys($controllerList);
       //классы контроллеров
       $this->controllers=  array_values($controllerList);
       //все роуты
       $routes=$config["router"]["routes"];       
       foreach($routes as $key=>$route){
         $this->addPermission($route);           
       }
       var_dump($this->permissions);
        exit;
    }
    
    private function addPermission($route,$ctrl=null,$grp=null){
        $options=$route["options"]["defaults"];
        $group=isset($options["group"])?$options["group"]:$grp;
        $controller=isset($options["controller"])?$options["controller"]:$ctrl;
      if(in_array($controller, $this->invokables) || in_array($controller, $this->controllers)) {
        $permission=array(
        "controller"=>$controller,
        "action"=>$options["action"],
        "description"=>isset($options["description"])?$options["description"]:"",
        "system"=>isset($options["system"])?1:0,
        "exclude"=>isset($options["exclude"])?1:0,
        );
        $this->permissions[$group][]=$permission;
       
        if(isset($route["child_routes"])){
            foreach($route["child_routes"] as $key=>$childroute){
                $this->addPermission($childroute,$permission["controller"],$group);
            }
        }
         }
        return true;
    }
    
    
}
