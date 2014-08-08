<?php
namespace Acl;
use Zend\EventManager\StaticEventManager;
use Zend\ModuleManager\ModuleManager as ModuleManager;
class Module
{
    
          public function getModuleDependencies()
    {
        return array('DoctrineMongoODMModule',  'DoctrineModule', 'User');   
    }
    
        public function onBootstrap($e)
    {
    $eventManager = $e->getTarget()->getEventManager();
    $listener=new Listener\AclListener($e->getApplication()->getServiceManager());
   //формируем acl-ки
    $listener->initAcl($e);
    //привязываем менеджер событий
    $eventManager->attach($listener);
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
