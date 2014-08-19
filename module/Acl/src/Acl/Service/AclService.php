<?php
namespace Acl\Service;
use Acl\Entity\AclPermissions;
use Zend\Permissions\Acl;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Permissions\Acl\Resource\GenericResource;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AclService
 * Служба для проверки прав доступа
 * @author kopychev
 */



class AclService {
    //разрешения инсталлятора
    const INSTALL_GROUP="install";
            private $invokables,$controllers,$permissions,$_sm,$_em, $acl;
            public function __construct($sm) {
                $this->_sm=$sm;
                $locator = $sm;
                $em = $locator->get('doctrine.entitymanager.orm_default');
                $this->_em=$em;
            }
/**
 * Текущие маршруты с пермишнами из конфига приложения
 * @param array $config
 * @return array
 */
    public function getCurrentPermissions($config){
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
       unset($this->permissions[self::INSTALL_GROUP]);
       return $this->permissions;
    }     
    
    /**
     * Получить ресурсы и white пермишны Acl-ки из БД
     */
    public function getDbResorces(){
              $permissions=$this->_em->getRepository("Acl\Entity\AclPermissions")->findAll();
              return $permissions;
     }
    /**
     * Получаем все роли из БД
     * @return type
     */
     public function getDbRoles(){
         return $this->_em->getRepository("Acl\Entity\AclRoles")->findAll();
     }
//выдернуть 1 роль
    public function getDbRole($id){
    return $this->_em->getRepository("Acl\Entity\AclRoles")->find($id);
    }
    /**
     * Добавить разрешение в текущий массив
     * @param array $route
     * @param mixed $ctrl
     * @param mixed $grp
     * @return boolean
     */
    
    private function addPermission($route,$ctrl=null,$grp=null){
        $options=$route["options"]["defaults"];
        $group=isset($options["group"])?$options["group"]:$grp;
        $controller=isset($options["controller"])?$options["controller"]:$ctrl;
      if(in_array($controller, $this->invokables) || in_array($controller, $this->controllers)) {
      $action=$options["action"];
        $permission=array(
        "description"=>isset($options["description"])?$options["description"]:"",
        "system"=>isset($options["system"])?1:0,
        "exclude"=>isset($options["exclude"])?1:0,
        );
        $this->permissions[$group][$controller][$action]=$permission;
       
        if(isset($route["child_routes"])){
            foreach($route["child_routes"] as $key=>$childroute){
                $this->addPermission($childroute,$controller,$group);
            }
        }
         }
        return true;
    }
    
    /**
     * Вспомогательная функция для сканирования директорий контроллеров и извлечения имен классов
     * @return array
     */
    
    public function allowed($acl,$roles,$res,$action){
        //проверяем, разрешено ли хотя бы 1 роли это действие
        foreach($roles as $role){
            if($acl->isAllowed((string)$role,$res,$action)) {
                return true;
            }
        }
        //если не нашли совпадений - действие запрещено
        return false;
    }
    
    public function checkAclExistance(){
        $schemaManager = $this->_em->getConnection()->getSchemaManager();
        return $schemaManager->tablesExist(array('acl_permissions'));
    }
    
    private function scanDir(){
        $modules=array();
                foreach (glob("module/*", GLOB_ONLYDIR) as $module) {
                    
            if (file_exists('module/' . basename($module) . '/src/' . basename($module) . '/Controller/')) {
                $sc = new DirectoryScanner('module/' . basename($module) . '/src/' . basename($module) . '/Controller/');

                foreach ($sc->getClasses(true) as $classScanner) {
                    $classname = $classScanner->getName();
                    $modules[]=$classname;
                }

                
            }
        }
        return $modules;
    }
    
    
    
    
}
