<?php
namespace Acl\Listener;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Code\Scanner\DirectoryScanner;
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
        protected $listeners=array(),$_sm,$target;
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
     $this->listeners[]=$sharedEvents->attach('Acl\Controller\AclController', 'aclUpdate', array($this,'onAclUpdate'), 100);
    }
    
    public function detach(EventManagerInterface $events) {
        
              foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
    /**
     * 
     * @param Event $e
     * @return boolean
     */
    public function onAclUpdate($e){
       $controller=$e->getTarget();
       $config=$controller->getServiceLocator()->get('Config');
            try {
          $aclService=$this->_sm->get("aclService");
          $currentPermissions=$aclService->getCurrentPermissions($config);
          $controller->currentPermissions=$currentPermissions;
          return true;
            }
            catch (\Exception $e){
               print($e->getMessage());
               return false;
            }
    }
    

    
    
}
