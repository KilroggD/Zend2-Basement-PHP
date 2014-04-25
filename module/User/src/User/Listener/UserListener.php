<?php
namespace User\Listener;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserListener
 *
 * @author kopychev
 */
class UserListener  implements ListenerAggregateInterface {
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
        protected $listeners=array(),$_sm;
        /**
         * В конструкторе определяем сервис-менеджер
         * @param type $sm
         */
    public function __construct($sm) {
        $this->_sm=$sm;
    }
        /**
         * Стандартные методы attach и detach - установка и снятие событий
         * @param \Zend\EventManager\EventManagerInterface $events
         */
    public function attach(EventManagerInterface $events) {
        $sharedEvents=$events->getSharedManager();
        $this->listeners[]=$sharedEvents->attach('User\Controller\LoginController', 'successfulLogin', array($this,'onSuccessfulLogin'), 100);
        $this->listeners[]=$sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', array($this,'checkAuth'), 200);
    }
    
    public function detach(EventManagerInterface $events) {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
    /**
     * Обработчик события - возможно потом следует вынести в сервис
     * @param Event $e
     */
    public function onSuccessfulLogin($e){
        $params=$e->getParams();
        $service=$this->_sm;
        $em=$service->get('Doctrine\ORM\EntityManager');
        $userLogged=$em->getRepository("User\Entity\Users")->find($params["id"]);
        $userLogged->setLastLogin(new \DateTime());
        $em->flush();
    }
    /**
     * На каждое действие - проверяет, залогинен
     */
    public function checkAuth($e){
        $authObject=null; 
        $app = $e->getApplication();
         $locator = $app->getServiceManager();
        $authService = $locator->get('authService');
        $authAdapter=$authService->getAdapter();
        $controller=$e->getTarget();
        if($authService->hasIdentity()===true){
        //is logged in
            $authObject=$authService->getStorage()->read();
            $controller->userParams=$authObject;
        }
        $controller->layout()->setVariable('userLogged',$authObject);
        return true;
    }
    
    
}
