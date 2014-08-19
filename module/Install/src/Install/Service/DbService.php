<?php
namespace Install\Service;
use Doctrine\ORM\Mapping\Driver\YamlDriver as YamlDriverORM;
use Doctrine\ODM\MongoDB\Mapping\Driver\YamlDriver as YamlDriverODM;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DbService
 *
 * @author kopychev
 */
class DbService {
    //put your code here
        private $em, $dm;
        public function __construct($em,$dm=null) {
            $this->em=$em;
            $this->dm=$dm;
            
        }
    /**
     * Установка таблиц постгре
     * @return boolean|\Install\Service\DbService
     */
        public function installPg(){        
        try {
        $classes=array();
        $yml=new YamlDriverORM("./yml");
            $pgTables=$yml->getAllClassNames();
            $tool=new \Doctrine\ORM\Tools\SchemaTool($this->em);
            foreach($pgTables as $ns){
                $classes[]=$this->em->getClassMetadata($ns);
            }
            $tool->createSchema($classes);  
            return $this;
        }
        catch (\Exception $e){
            return false;
        }
    }
    
    public function installMongo(){
             try {
                 $this->dm->getConnection()->connect();
            $helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'dm' => new \Doctrine\ODM\MongoDB\Tools\Console\Helper\DocumentManagerHelper($this->dm),
));
            $app = new \Symfony\Component\Console\Application('Doctrine MongoDB ODM');
$app->setHelperSet($helperSet);
$app->addCommands(array(
        new \Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\CreateCommand(),
    )
        );
  $command = $app->find('odm:schema:create');
        $commandTester = new \Symfony\Component\Console\Tester\CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));
       return true;
        }
        catch (\Exception $e){
            die($e->getMessage());
            return false;
        }   
    }
    
    /**
     * Устанавливаем роли и начального юзера админа
     * @param array $data
     */
    public function installRoles($data){
        try {
        $initRoles=$this->em->getRepository("Acl\Entity\AclRoles")->initRoles();
        //ищем администраторскую роль
        $adminRole=$initRoles->find(\Acl\Repository\AclRolesRepository::ADMIN);
        //создаем дефолтного админа
        $user=new \User\Entity\Users();
        $user->setLogin($data["login"])->setEmail($data["login"]);
        $user->setPassword($data["password"]);
        $user->setStatus(\User\Entity\Users::ACTIVE);
        $user->setBuiltIn(1);
        $user->addRole($adminRole);
        $this->em->persist($user);
        $this->em->flush();
        return true;
        }
        catch(\Exception $e) {
            echo $e->getMessage();
            die("roles creation exception");
        return false;
        }
    }
    
    /**
     * Установка пермишнов
     */
    public function installPermissions($permissions){
        try {
        $this->em->getRepository("Acl\Entity\AclPermissions")->addAcls($permissions);
        $loginPermissions=$this->em->getRepository("Acl\Entity\AclPermissions")->findByGrp("login");
        $guestRole=$this->em->getRepository("Acl\Entity\AclRoles")->find(\Acl\Repository\AclRolesRepository::GUEST);
        foreach($loginPermissions as $permission) {
            $guestRole->addPermission($permission);
        }
        $this->em->flush();
        return true;
        }
        catch (\Exception $e) {
            echo $e->getMessage();
            die("permissions creation exception");
        }
    }
    
}
