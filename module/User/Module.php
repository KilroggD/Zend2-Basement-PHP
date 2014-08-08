<?php
namespace User;

class Module
{
    
              public function getModuleDependencies()
    {
        return array('DoctrineMongoODMModule',  'DoctrineModule');   
    }
    
    public function onBootstrap($e)
    {
    $eventManager = $e->getTarget()->getEventManager();
    $eventManager->attach(new Listener\UserListener($e->getApplication()->getServiceManager()));
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
