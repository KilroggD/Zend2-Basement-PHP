<?php
namespace Acl\Listener;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Code\Scanner\DirectoryScanner;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Permissions\Acl\Resource\GenericResource;
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
 * Константы встроенных ролей
 */
const ADMIN="1", USER="2", GUEST="3";
       /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
        protected $listeners=array(),$_sm,$target, $acl;
        /**
         * В конструкторе определяем сервис-менеджер
         * @param type $sm
         */
    public function __construct($sm) {        
        $this->_sm=$sm;
        $this->acl=new Acl();
        $this->permissions=array();
        $this->invokables=array();
        $this->controllers=array();      
            }
    public function attach(EventManagerInterface $events) {
     $sharedEvents=$events->getSharedManager();
     $this->listeners[]=$sharedEvents->attach('Acl\Controller\AclController', 'aclUpdate', array($this,'onAclUpdate'), 100);
     $this->listeners[]=$sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController','dispatch', array($this, 'checkAcl'),200);
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
    /**
     * Проверяем, доступно ли действие пользователю
     * @param type $e
     */
    public function checkAcl($e){
        $routeMatch = $e->getRouteMatch();
        $controller=$e->getTarget();
        $controllerName=$routeMatch->getParam('controller');
        $actionName=$routeMatch->getParam('action');
        $user=$controller->userParams;      
        //если не задан юзер
        $roles=$this->getUserRoles($user);
        $view=$e->getViewModel();
        if(!$this->_sm->get("aclService")->allowed($this->acl,$roles,$controllerName,$actionName)){
          $e->setError('ACL_ACCESS_DENIED'); 
          $controller->getEventManager()->trigger('forbidden.error', $e);
          exit("Forbidden!");
          return false;
        }
        return true;
    }
    
    public function initAcl($e){
        $resources=$this->_sm->get("aclService")->getDbResorces();
        $roles=$this->_sm->get("aclService")->getDbRoles();
        //грузим роли, премишны и ресурсы
        $this->addResources($resources)->addRolesPermissions($roles);
        $adminRole=new GenericRole(self::ADMIN);
        $this->acl->allow($adminRole);
        $e->getViewModel()->acl=$this->acl;
            }
    /**
     * Грузим начальные ресурсы 
     * @param type $resources
     */
    public function addResources($resources) {
        foreach($resources as $record){
            $controller=$record->getController();
            $action=$record->getAction();
            //создаем ресурс и добавляем если такого нет
            $resource=new GenericResource($controller);
            if(!$this->acl->hasResource($resource)){
                $this->acl->addResource($resource);
            }
            //если разрешение в эксклудах - сразу прописываем, что его можно всем
            if($record->getExclude()){
                $this->acl->allow(null,$controller,$action);
            }
        }
        return $this;
    }
    /**
     * грузим роли с разрешениями
     * @param type $role
     */
    public function addRolesPermissions($roles){
        foreach($roles as $record){
            $roleid=$record->getId();
            $permissions=$record->getPermissions();
            $role=new GenericRole((string)$roleid);
            if(!$this->acl->hasRole($role)){
                $this->acl->addRole($role);
                foreach($permissions as $permission){
                    $this->acl->allow($role,$permission->getController(), $permission->getAction());
                }                
            }
        }
    }
    
      /**
   * Возвращает массив из Id ролей, которые присвоены данному пользователю
   * @param User\Entity\Users $user
   * @return array $roles
   */
    public function getUserRoles($user){
               if(!$user){
         $roles=array(self::GUEST);      
        }
        else{
         $userRoles=$user->getRoles();
         $count=$userRoles->count();
         //если ролей нет
         if(!$count){
             $roles=array(self::USER);
         }
         else {
             $roles=array();
           foreach($userRoles as $role){
               $roles[]=(string)$role->getId();
           }  
         }
        }
        return $roles;
    }
    
}
