<?php

namespace Install\Controller;

use Zend\Mvc\MvcEvent;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InstallController
 *
 * @author kopychev
 */
class InstallController extends \Zend\Mvc\Controller\AbstractActionController {

    //put your code here
    private $em, $dm;
    public $config, $userParams;

    /**
     * Текущие разрешения из конфига
     * @var array 
     */
    public $currentPermissions;

    /**
     * Варианты состояния подключения к постгре
     * @var array 
     */
    private static $pgState = array("Не удалось подключиться к PostgreSQL. Проверьте настройки в config/autoload/db.local.php", "Успешное подключение");

    /**
     * Варианты состояния подключения к монге
     * @var array 
     */
    private static $mongoState = array("Не удалось подключиться к MongoDB. Проверьте настройки в config/autoload/db.local.php", "Успешное подключение");

    /**
     * Начальная страница инсталляции - результаты тестов соединений с БД
     */
    public function indexAction() {
        //изначально считаем, что обе БД подключаются и работают
        $pgtest = 1;
        $mongotest = 1;
        $modules = array("list" => array(), "message" => "Модули не найдены, проверьте пути в файле config/application.config.php");
        try {
            $this->getEntityManager()->getConnection()->connect();
        } catch (\Exception $e) {
            $pgtest = 0;
        }
        try {
            $this->getDocumentManager()->getConnection()->connect();
        } catch (\MongoConnectionException $e) {
            $mongotest = 0;
        }
        $configArray = $this->getServiceLocator()->get("Application\Config");
        $modules_path = $configArray["module_listener_options"]["module_paths"];
        foreach ($modules_path as $path) {
            $module_path_dirs = scandir($path);
            if (in_array("Install", $module_path_dirs)) {
                $modules["list"] = array_filter($module_path_dirs, function(&$value) {
                    return preg_match('/[A-Za-z0-9]{1,}.*/', $value);
                });
                $modules["message"] = "Найденные модули";
                break;
            }
        }

        return array("pg" => array("state" => $pgtest, "message" => self::$pgState[$pgtest]), "mongo" => array("state" => $mongotest, "message" => self::$mongoState[$mongotest]), "modules" => $modules);
    }

    /**
     * Генерация монго
     */
    public function installAction() {
        $request = $this->getRequest();
        //получаем форму
        $form = $this->getServiceLocator()->get('FormElementManager')->get('InstallForm');
        $mm = $this->getServiceLocator()->get("ModuleManager");
        //    var_dump($this->currentPermissions);
        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setData($data);
            if ($form->isValid()) {
                $srv = new \Install\Service\DbService($this->getEntityManager(), $this->getDocumentManager());
                if ($srv->installPg()) {
                    $this->flashMessenger()->addMessage("Таблицы БД созданы успешно");
                    $this->getEventManager()->trigger("aclInstall", $this);
                    if ($srv->installRoles($data) && $srv->installPermissions($this->currentPermissions)) {
                        $this->flashMessenger()->addMessage("Успешно созданы роли и разрешения");
                        $this->flashMessenger()->addMessage("Установка прошла успешно, можете воспользоваться учетной записью администратора");
                        if ($srv->installModules($mm->getModules())) {
                            $this->flashMessenger()->addMessage("Успешно созданы данные для модулей");
                        }
                        if ($data["mongo"] == 1) {
                            if ($srv->installMongo()) {
                                $this->flashMessenger()->addMessage("Коллекция Mongo создана успешно");
                            } else {
                                $this->flashMessenger()->addMessage("Ошибка создания коллекции mongo");
                            }
                        }

                        $this->redirect()->toRoute("home");
                    } else {
                        $this->flashMessenger()->addMessage("Не удалось загрузить роли и разрешения");
                    }
                } else {
                    $this->flashMessenger()->addMessage("Не удалось создать таблицы БД");
                }
            }
        }
        return array("form" => $form, "messages" => $this->flashMessenger()->getMessages());
    }

    /**
     * Вернуть менеджер сущностей DoctrineORM
     * @return Doctrine\ORM\EntityManager
     */
    protected function getEntityManager() {
        if (null === $this->em) {
            $this->setEntityManager($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        }
        return $this->em;
    }

    /**
     * Установить менеджер сущностей DoctrineORM
     * @param type $em
     * @return \User\Controller\MyAbstractController
     */
    protected function setEntityManager($em) {
        $this->em = $em;
        return $this;
    }

    protected function getDocumentManager() {
        if (null === $this->dm) {
            $this->setDocumentManager($this->getServiceLocator()->get('doctrine.documentmanager.odm_default'));
        }
        return $this->dm;
    }

    protected function setDocumentManager($dm) {
        $this->dm = $dm;
        return $this;
    }

}
