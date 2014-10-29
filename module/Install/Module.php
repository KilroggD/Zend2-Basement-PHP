<?php
namespace Install;
use Zend\Mvc\MvcEvent;
class Module
{
    const  NON_CONNECTION_MESSAGE="Не установлено соединение с БД. Пожалуйста, скопируйте или переименуйте файл config/autoload/db.example.php в config/autoload/db.local.php и задайте в нем настройки подключения к БД. Затем обновите страницу";

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
    
           public function onBootstrap(MvcEvent $e)
    {
                   $eventManager = $e->getTarget()->getEventManager();
                   try {
                       $em=@$e->getApplication()->getServiceManager()->get('doctrine.entitymanager.orm_default');
                       $em->getConnection();
                   } catch (\Exception $ex) {
                       die(self::NON_CONNECTION_MESSAGE);
                   }
    $eventManager->attach(new Listener\InstallListener());
 
           }
    
}
