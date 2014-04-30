<?php
namespace Acl;
use Zend\EventManager\StaticEventManager;
use Zend\ModuleManager\ModuleManager as ModuleManager;
class Module
{
    
  
    
        public function onBootstrap($e)
    {
    $eventManager = $e->getTarget()->getEventManager();
    $eventManager->attach(new Listener\AclListener($e->getApplication()->getServiceManager()));
    }    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
 
    
}
